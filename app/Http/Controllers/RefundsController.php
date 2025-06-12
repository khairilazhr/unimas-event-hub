<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Models\Refunds;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RefundsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ticketId = $request->get('ticket_id');
        
        // If no ticket_id provided, show user's refund history
        if (!$ticketId) {
            $refunds = Refunds::where('user_id', Auth::id())
                ->with(['ticket', 'eventRegistration.event'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('user.refunds.index', compact('refunds'));
        }
        
        // Get the registration details for the specific ticket
        $registration = EventRegistration::where('ticket_id', $ticketId)
            ->where('user_id', Auth::id())
            ->with(['event', 'ticket', 'payment'])
            ->first();
            
        if (!$registration) {
            return redirect()->back()->with('error', 'Registration not found or you do not have permission to refund this ticket.');
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
            'ticket_id' => 'required|exists:tickets,id',
            'refund_reason' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ]);

        // Get the registration to calculate refund amount
        $registration = EventRegistration::where('ticket_id', $request->ticket_id)
            ->where('user_id', Auth::id())
            ->with(['ticket', 'payment'])
            ->first();

        if (!$registration) {
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
        Refunds::create([
            'ticket_id' => $request->ticket_id,
            'event_registration_id' => $registration->id, 
            'user_id' => Auth::id(),
            'refund_amount' => $refundAmount,
            'refund_reason' => $request->refund_reason,
            'status' => 'pending', 
            'notes' => $request->notes,
        ]);

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
        'status' => 'required|in:approved,rejected',
        'notes' => 'nullable|string|max:500',
        'refund_proof' => 'required_if:status,approved|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Verify organizer owns the event
    $organizerId = Auth::id();
    $eventOrganizerId = $refund->eventRegistration->event->organizer_id;

    if ($organizerId !== $eventOrganizerId) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $data = [
        'status' => $request->status,
        'notes' => $request->notes,
    ];

    // Handle refund_proof upload if approved
    if ($request->status === 'approved' && $request->hasFile('refund_proof') && $request->file('refund_proof')->isValid()) {
        $refundProofPath = $request->file('refund_proof')->store('refund_proofs', 'public');
        $data['refund_proof'] = $refundProofPath;
    }

    $refund->update($data);

    return redirect()->back()->with('success', 'Refund status updated successfully.');
}

}
