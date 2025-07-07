<?php
namespace App\Http\Controllers;

use App\Mail\ForumReplyNotification;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\ForumReply;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ForumController extends Controller
{
    /**
     * Display forum topics for a specific event.
     *
     * @param  int  $eventId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);
        $user  = Auth::user();

        // Authorization checks
        if ($user->role === 'organizer') {
            abort_unless($event->organizer_id === $user->id, 403, 'Unauthorized access');
        } elseif ($user->role === 'user') {
            $user                     = auth()->user();
            $hasConfirmedRegistration = EventRegistration::where('event_id', $eventId)
                ->where('status', 'approved')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhere('email', $user->email);
                })
                ->exists();

            abort_unless($hasConfirmedRegistration, 403, 'You need a confirmed registration');
        }
        // Admin requires no checks

        $topics = ForumTopic::where('event_id', $event->id)
            ->with(['user', 'replies'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('forum.index', compact('event', 'topics'));
    }

    /**
     * Show the form for creating a new topic.
     *
     * @param  int  $eventId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createTopic($eventId)
    {
        $event = Event::findOrFail($eventId);

        return view('forum.create-topic', compact('event'));
    }

    /**
     * Store a newly created topic in storage.
     *
     * @param  int  $eventId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTopic(Request $request, $eventId)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $event = Event::findOrFail($eventId);

        $topic           = new ForumTopic;
        $topic->title    = $request->title;
        $topic->content  = $request->content;
        $topic->event_id = $eventId;
        $topic->user_id  = Auth::id();
        $topic->save();

        return redirect()->route('forum.show', ['eventId' => $eventId, 'topicId' => $topic->id])
            ->with('success', 'Question posted successfully!');
    }

    /**
     * Display the specified topic.
     *
     * @param  int  $eventId
     * @param  int  $topicId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($eventId, $topicId)
    {
        $event = Event::findOrFail($eventId);
        $topic = ForumTopic::with(['user', 'replies.user'])->findOrFail($topicId);

        return view('forum.show', compact('event', 'topic'));
    }

    /**
     * Store a newly created reply in storage.
     *
     * @param  int  $eventId
     * @param  int  $topicId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReply(Request $request, $eventId, $topicId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $topic = ForumTopic::findOrFail($topicId);

        $reply           = new ForumReply;
        $reply->content  = $request->content;
        $reply->topic_id = $topicId;
        $reply->user_id  = Auth::id();
        $reply->save();

        // Send email notification to topic creator (if not the same person)
        if ($topic->user_id !== Auth::id()) {
            try {
                $topicCreator = $topic->user;
                if ($topicCreator && $topicCreator->email) {
                    Mail::to($topicCreator->email)->send(new ForumReplyNotification($reply, $topic));
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send forum reply email: ' . $e->getMessage());
            }
        }

        return redirect()->route('forum.show', ['eventId' => $eventId, 'topicId' => $topicId])
            ->with('success', 'Reply posted successfully!');
    }

    /**
     * Mark a reply as the answer.
     *
     * @param  int  $eventId
     * @param  int  $topicId
     * @param  int  $replyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsAnswer($eventId, $topicId, $replyId)
    {
        $topic = ForumTopic::findOrFail($topicId);
        $event = Event::findOrFail($eventId);

        // Check if user is the topic creator or the event organizer
        if (Auth::id() == $topic->user_id || Auth::id() == $event->organizer_id) {
            // Reset all other replies to not be answers
            ForumReply::where('topic_id', $topicId)->update(['is_answer' => false]);

            // Mark this reply as the answer
            $reply            = ForumReply::findOrFail($replyId);
            $reply->is_answer = true;
            $reply->save();

            // Mark the topic as resolved
            $topic->is_resolved = true;
            $topic->save();

            return redirect()->route('forum.show', ['eventId' => $eventId, 'topicId' => $topicId])
                ->with('success', 'Reply marked as the solution!');
        }

        return redirect()->route('forum.show', ['eventId' => $eventId, 'topicId' => $topicId])
            ->with('error', 'You do not have permission to mark a solution.');
    }
}
