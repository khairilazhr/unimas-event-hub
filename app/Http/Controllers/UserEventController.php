<?php
namespace App\Http\Controllers;

use App\Mail\EventRegistrationNotification;
use App\Mail\OrganizerRegistrationNotification;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

// Add Ticket model import

class UserEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status', 'approved');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->latest()->paginate(6)->withQueryString();

        return view('events.index', compact('events'));
    }

    public function showRegistrationForm(Event $event)
    {
        // Fetch only available tickets associated with this event
        $tickets = Ticket::where('eventId', $event->id)
            ->where('status', 'available')
            ->get();

        // Get authenticated user
        $user = auth()->user();

        return view('events.register', compact('event', 'tickets'));
    }

    public function processRegistration(Request $request, Event $event)
    {
        // Validate the request
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'ticket_id'   => 'required|exists:tickets,id',
            'ticket_type' => 'required|string',
            'section'     => 'required|string',
            'row'         => 'required|string',
            'seat'        => 'required|string',
            'receipt'     => 'required_if:ticket_price,gt,0|file|mimes:jpg,png,pdf|max:2048',
        ]);

        // Get the ticket
        $ticket = Ticket::findOrFail($request->ticket_id);

        // Check if ticket is already booked
        if ($ticket->status === 'comfirmed') {
            return back()->withErrors(['ticket' => 'This ticket has already been booked.']);
        }

        // Validate receipt requirement
        if ($ticket->price > 0 && ! $request->hasFile('receipt')) {
            return back()->withErrors(['receipt' => 'Payment receipt is required for paid tickets']);
        }

        // Store the receipt
        $receiptPath = null;
        if ($request->hasFile('receipt') && $request->file('receipt')->isValid()) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Create registration
            $registration = EventRegistration::create([
                'event_id'    => $event->id,
                'ticket_id'   => $request->ticket_id,
                'user_id'     => auth()->id(),
                'name'        => $request->name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'status'      => $ticket->price > 0 ? 'pending' : 'approved',
                'amount_paid' => $ticket->price, // Add the ticket price as amount paid
            ]);

            // Update ticket status to pending
            $ticket->update([
                'status' => 'pending',
            ]);

            // Create payment record if needed
            if ($ticket->price > 0) {
                Payment::create([
                    'event_reg_id' => $registration->id,
                    'user_id'      => auth()->id(),
                    'receipt'      => $receiptPath,
                    'ref_no'       => 'PAY-' . strtoupper(uniqid()),
                ]);
            }

            DB::commit();

            // Send email notifications
            try {
                // Send email to the user
                Mail::to($request->email)->send(new EventRegistrationNotification($registration));

                // Send email to the organizer if they have an email
                if ($event->organizer && $event->organizer->email) {
                    Mail::to($event->organizer->email)->send(new OrganizerRegistrationNotification($registration));
                }
            } catch (\Exception $e) {
                // Log the email error but don't fail the registration
                \Log::error('Failed to send registration emails: ' . $e->getMessage());
            }

            return redirect()->route('user.events.registration-success', $registration->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while processing your registration. Please try again.']);
        }
    }

    public function registrationSuccess(EventRegistration $registration)
    {
        // Load the event and ticket relations
        if ($registration->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load the payment relationship
        $registration->load(['event', 'ticket', 'payment']);

        return view('events.registration-success', compact('registration'));
    }

    public function myBookings()
    {
        $user = auth()->user();

        $registrations = \App\Models\EventRegistration::where('user_id', $user->id)
            ->with(['event', 'ticket', 'ticket.refunds' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->latest()
            ->get();

        return view('events.my-bookings', compact('registrations'));
    }

    public function registrationDetails(EventRegistration $registration)
    {
        // Security check - only allow users to view their own registrations
        if ($registration->user_id != auth()->id()) {
            abort(403, 'You are not authorized to view this registration.');
        }

        // Load the event and ticket relations
        $registration->load(['event', 'ticket']);

        return view('events\registation-details', compact('registration'));
    }

    public function cancelRegistration(EventRegistration $registration)
    {
        // Security check - only allow users to cancel their own registrations
        if ($registration->user_id != auth()->id()) {
            abort(403, 'You are not authorized to cancel this registration.');
        }

        // Check if the event date is in the future
        if (! \Carbon\Carbon::parse($registration->event->date)->isFuture()) {
            return back()->withErrors(['message' => 'You cannot cancel a registration for a past event.']);
        }

        // Update registration status to cancelled
        $registration->status = 'cancelled';
        $registration->save();

        return redirect()->route('user.events.my-bookings')
            ->with('success', 'Your booking has been cancelled successfully.');
    }

    public function verifyTicket($id)
    {
        $registration = EventRegistration::with(['event', 'ticket'])
            ->findOrFail($id);

        // Check if the ticket is valid
        $isValid = $registration->status === 'approved';

        // Additional checks can be added here
        // For example, check if the event date is in the future
        $eventInFuture = \Carbon\Carbon::parse($registration->event->date)->isFuture();

        return response()->json([
            'valid'        => $isValid,
            'registration' => [
                'id'     => $registration->id,
                'status' => $registration->status,
                'name'   => $registration->name,
                'event'  => [
                    'name'     => $registration->event->name,
                    'date'     => \Carbon\Carbon::parse($registration->event->date)->format('d M Y, h:i A'),
                    'location' => $registration->event->location,
                ],
                'ticket' => [
                    'type'    => $registration->ticket->type,
                    'section' => $registration->ticket->section,
                    'row'     => $registration->ticket->row,
                    'seat'    => $registration->ticket->seat,
                ],
            ],
        ]);
    }

    public function generateTicket(EventRegistration $registration)
    {
        if ($registration->user_id != auth()->id() || $registration->status !== 'approved') {
            abort(403);
        }

        // Create or get attendance record
        $attendance = Attendance::firstOrCreate(
            ['event_registration_id' => $registration->id],
            ['status' => Attendance::STATUS_REGISTERED]
        );

        // Generate QR code data
        $qrData = [
            'type'            => 'attendance',
            'registration_id' => $registration->id,
            'attendance_id'   => $attendance->id,
            'timestamp'       => now()->timestamp,
        ];

        return response()->json([
            'success' => true,
            'qrData'  => base64_encode(json_encode($qrData)),
            'ticket'  => [
                'event_name'    => $registration->event->name,
                'date'          => $registration->event->date,
                'location'      => $registration->event->location,
                'attendee_name' => $registration->name,
                'section'       => $registration->ticket->section,
                'row'           => $registration->ticket->row,
                'seat'          => $registration->ticket->seat,
            ],
        ]);
    }

    public function myAttendances()
    {
        $user = auth()->user();

        $attendances = Attendance::whereHas('eventRegistration', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('status', 'attended') // Only get attended records
            ->with(['eventRegistration.event', 'eventRegistration.ticket'])
            ->latest('attended_at') // Sort by attendance date
            ->get();

        return view('user.attendances.index', compact('attendances'));
    }

}
