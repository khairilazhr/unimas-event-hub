<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RefundRequestNotification;
use App\Mail\RefundStatusNotification;
use App\Models\EventRegistration;
use App\Models\Refunds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RefundsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ticketId = $request->get('ticket_id');
        $user     = Auth::user();

        // If no ticket_id provided, show user's refund history
        if (! $ticketId) {
            $refunds = Refunds::where('user_id', Auth::id())
                ->with(['ticket', 'eventRegistration.event'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.refunds.index', compact('refunds'));
        }

        // Get the registration details for the specific ticket
        $registration = EventRegistration::where('ticket_id', $ticketId)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('email', $user->email);
            })
            ->with(['event', 'ticket', 'payment'])
            ->first();

        if (! $registration) {
            return redirect()->back()->with('error', 'Registration not found.');
        }

        // Check if refund already exists for this ticket
        $existingRefund = Refunds::where('ticket_id', $ticketId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRefund) {
            return redirect()->back()->with('error', 'A refund request for this ticket already exists.');
        }

        return view('user.refunds.index', compact('registration', 'ticketId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id'     => 'required|exists:tickets,id',
            'refund_reason' => 'required|string|max:1000',
            'notes'         => 'nullable|string|max:500',
        ]);

        // Get the registration to calculate refund amount
        $user         = Auth::user();
        $registration = EventRegistration::where('ticket_id', $request->ticket_id)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('email', $user->email);
            })
            ->with(['event', 'ticket', 'payment'])
            ->first();

        if (! $registration) {
            return redirect()->back()->with('error', 'Registration not found.');
        }

        // Check if refund already exists
        $existingRefund = Refunds::where('ticket_id', $request->ticket_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRefund) {
            return redirect()->back()->with('error', 'A refund request for this ticket already exists.');
        }

        // Get refund amount directly from ticket price
        $refundAmount = $registration->ticket->price;

        // Create the refund request
        $refund = Refunds::create([
            'ticket_id'             => $request->ticket_id,
            'event_registration_id' => $registration->id,
            'user_id'               => Auth::id(),
            'refund_amount'         => $refundAmount,
            'refund_reason'         => $request->refund_reason,
            'status'                => 'pending',
            'notes'                 => $request->notes,
        ]);

        // Send email to user
        try {
            Mail::to(Auth::user()->email)->send(new RefundRequestNotification($refund));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send refund request email to user: ' . $e->getMessage());
        }

        // Send email to organizer
        try {
            $organizer = $registration->event->organizer;
            if ($organizer && $organizer->email) {
                Mail::to($organizer->email)->send(new RefundRequestNotification($refund));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send refund request email to organizer: ' . $e->getMessage());
        }

        return redirect()->route('user.refunds.index')->with('success', 'Refund request submitted successfully. We will review your request and get back to you soon.');
    }

    public function myRefunds()
    {
        $refunds = Refunds::where('user_id', Auth::id())
            ->with(['ticket', 'eventRegistration.event'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.refunds.my-refunds', compact('refunds'));
    }

    public function organizerRefunds()
    {
        $organizerId = Auth::id();

        $refunds = Refunds::whereHas('eventRegistration.event', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })
            ->with(['ticket', 'eventRegistration.event', 'user'])
            ->get()
            ->groupBy('eventRegistration.event.id');

        return view('organizer.refunds.index', compact('refunds'));
    }

    public function updateRefundStatus(Request $request, Refunds $refund)
    {
        $request->validate([
            'status'       => 'required|in:approved,rejected',
            'notes'        => 'nullable|string|max:500',
            'refund_proof' => 'required_if:status,approved|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Verify organizer owns the event
        $organizerId      = Auth::id();
        $eventOrganizerId = $refund->eventRegistration->event->organizer_id;

        if ($organizerId !== $eventOrganizerId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = [
            'status' => $request->status,
            'notes'  => $request->notes,
        ];

        // Handle refund_proof upload if approved
        if ($request->status === 'approved' && $request->hasFile('refund_proof') && $request->file('refund_proof')->isValid()) {
            $refundProofPath      = $request->file('refund_proof')->store('refund_proofs', 'public');
            $data['refund_proof'] = $refundProofPath;
        }

        $refund->update($data);

        // Send email to user about status update
        try {
            Mail::to($refund->user->email)->send(new RefundStatusNotification($refund, $request->status));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send refund status email to user: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Refund status updated successfully.');
    }

    public function refundsReport()
    {
        $user = Auth::user();

        // Get all refunds for this organizer's events
        $refunds = Refunds::whereHas('eventRegistration.event', function ($query) use ($user) {
            $query->where('organizer_id', $user->id);
        })
            ->with(['eventRegistration.event', 'ticket', 'user'])
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->get();

        $statuses = ['pending', 'approved', 'rejected'];

        $response = new StreamedResponse(function () use ($refunds, $statuses) {
            $handle = fopen('php://output', 'w');

            // CSV Header
            fputcsv($handle, [
                'Status',
                'Event',
                'Event Date',
                'Ticket Type',
                'Section',
                'Row',
                'Seat',
                'User Name',
                'User Email',
                'Refund Amount',
                'Refund Reason',
                'Notes',
                'Requested At',
                'Updated At',
            ]);

            foreach ($statuses as $status) {
                $filtered = $refunds->where('status', $status);
                foreach ($filtered as $refund) {
                    fputcsv($handle, [
                        ucfirst($refund->status),
                        $refund->eventRegistration->event->name ?? '',
                        $refund->eventRegistration->event->date ?? '',
                        $refund->ticket->type ?? '',
                        $refund->ticket->section ?? '',
                        $refund->ticket->row ?? '',
                        $refund->ticket->seat ?? '',
                        $refund->user->name ?? '',
                        $refund->user->email ?? '',
                        number_format($refund->refund_amount, 2),
                        $refund->refund_reason,
                        $refund->notes ?? '',
                        $refund->created_at->format('Y-m-d H:i'),
                        $refund->updated_at->format('Y-m-d H:i'),
                    ]);
                }
            }
            fclose($handle);
        });

        $filename = 'refunds_report_' . now()->format('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
