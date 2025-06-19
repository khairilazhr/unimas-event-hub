<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaires = Questionnaire::where('organizer_id', Auth::id())
            ->with(['event'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organizer.questionnaires.index', compact('questionnaires'));
    }

    public function create()
    {
        $events = Auth::user()->events()
            ->select('id', 'name', 'date', 'location', 'status')
            ->where('status', 'approved')
            ->orderBy('date', 'asc')
            ->get();

        if ($events->isEmpty()) {
            return redirect()->route('organizer.events.create')
                ->with('warning', 'You need to create and get approval for an event before creating a questionnaire.');
        }

        return view('organizer.questionnaires.create', compact('events'));
    }
    public function store(Request $request)
    {
        // Add this at the beginning of the store method for debugging
        try {
            $validated = $request->validate([
                'title'                     => 'required|string|max:255',
                'description'               => 'nullable|string',
                'event_id'                  => 'required|exists:events,id',
                'questions'                 => 'required|array|min:1',
                'questions.*.question_text' => 'required|string',
                'questions.*.question_type' => 'required|in:text,multiple_choice,checkbox,rating',
                'questions.*.is_required'   => 'boolean',
                // Modified these validation rules:
                'questions.*.options'       => 'required_if:questions.*.question_type,multiple_choice,checkbox',
                'questions.*.options.*'     => 'required_if:questions.*.question_type,multiple_choice,checkbox|string|max:255',
            ]);

            $questionnaire = Questionnaire::create([
                'title'        => $validated['title'],
                'description'  => $validated['description'],
                'event_id'     => $validated['event_id'],
                'organizer_id' => Auth::id(),
                'status'       => 'draft',
            ]);

            foreach ($validated['questions'] as $index => $questionData) {
                $question = $questionnaire->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'is_required'   => $questionData['is_required'] ?? false,
                    'order'         => $index + 1,
                ]);

                if (in_array($questionData['question_type'], ['multiple_choice', 'checkbox']) && isset($questionData['options'])) {
                    foreach ($questionData['options'] as $optionIndex => $optionText) {
                        $question->options()->create([
                            'option_text' => $optionText,
                            'order'       => $optionIndex + 1,
                        ]);
                        Log::info('Option created:', ['question_id' => $question->id, 'option_text' => $optionText]);
                    }
                }
            }

            return redirect()->route('organizer.questionnaires.index')
                ->with('success', 'Questionnaire created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function publish(Questionnaire $questionnaire)
    {
        $questionnaire->update([
            'status'       => 'published',
            'published_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Questionnaire published successfully');
    }

    public function show(Questionnaire $questionnaire)
    {
        $this->authorize('view', $questionnaire);
        $questionnaire->load(['questions.options', 'event']);

        return view('organizer.questionnaires.show', compact('questionnaire'));
    }

    public function edit(Questionnaire $questionnaire)
    {
        $this->authorize('update', $questionnaire);
        $questionnaire->load(['questions.options', 'event']);
        $events = Auth::user()->events;

        return view('organizer.questionnaires.edit', compact('questionnaire', 'events'));
    }

    public function update(Request $request, Questionnaire $questionnaire)
    {
        try {
            Log::info('=== QUESTIONNAIRE UPDATE START ===');
            Log::info('Questionnaire ID: ' . $questionnaire->id);
            Log::info('User ID: ' . Auth::id());

            $this->authorize('update', $questionnaire);
            Log::info('Authorization passed');

            // Add request debugging
            Log::info('Questionnaire update request received for ID: ' . $questionnaire->id);
            Log::info('Request method: ' . $request->method());
            Log::info('Request URL: ' . $request->url());
            Log::info('Request data:', $request->all());

            $validated = $request->validate([
                'title'                     => 'required|string|max:255',
                'description'               => 'nullable|string',
                'event_id'                  => 'required|exists:events,id',
                'questions'                 => 'required|array|min:1',
                'questions.*.id'            => 'nullable|exists:questions,id',
                'questions.*.question_text' => 'required|string',
                'questions.*.question_type' => 'required|in:multiple_choice,checkbox,text,rating',
                'questions.*.is_required'   => 'boolean',
                'questions.*.options'       => 'nullable|array',
                'questions.*.options.*'     => 'nullable|string|max:255',
            ]);

            // Add validation debugging
            Log::info('Validation passed successfully');
            Log::info('Validated data:', $validated);

            // Update questionnaire basic info
            $updateData = [
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'event_id'    => $validated['event_id'],
            ];

            Log::info('Updating questionnaire with data:', $updateData);
            $result = $questionnaire->update($updateData);
            Log::info('Questionnaire update result: ' . ($result ? 'success' : 'failed'));

            // Delete questions not present in the update
            $questionIds = collect($validated['questions'])->pluck('id')->filter();
            Log::info('Question IDs to keep: ' . $questionIds->implode(', '));
            $deletedCount = $questionnaire->questions()->whereNotIn('id', $questionIds)->delete();
            Log::info('Deleted ' . $deletedCount . ' questions');

            Log::info('Processing ' . count($validated['questions']) . ' questions');

            foreach ($validated['questions'] as $index => $questionData) {
                Log::info('Processing question ' . ($index + 1) . ':', $questionData);

                $question = isset($questionData['id'])
                ? Question::find($questionData['id'])
                : new Question();

                $questionData = [
                    'questionnaire_id' => $questionnaire->id,
                    'question_text'    => $questionData['question_text'],
                    'question_type'    => $questionData['question_type'],
                    'is_required'      => $questionData['is_required'] ?? false,
                    'order'            => $index + 1,
                ];

                Log::info('Saving question with data:', $questionData);
                $question->fill($questionData);
                $saved = $question->save();
                Log::info('Question ' . ($index + 1) . ' saved: ' . ($saved ? 'success' : 'failed') . ' with ID: ' . $question->id);

                if (in_array($questionData['question_type'], ['multiple_choice', 'checkbox']) && isset($questionData['options'])) {
                    Log::info('Saving options for question', [
                        'question_id' => $question->id,
                        'options'     => $questionData['options'] ?? null,
                    ]);
                    $question->options()->delete();
                    foreach ($questionData['options'] as $optionIndex => $optionText) {
                        if (! empty(trim($optionText))) {
                            $option = $question->options()->create([
                                'option_text' => $optionText,
                                'order'       => $optionIndex + 1,
                            ]);
                            Log::info('Option ' . ($optionIndex + 1) . ' created with ID: ' . $option->id);
                            Log::info('Option created:', ['question_id' => $question->id, 'option_text' => $optionText]);
                        }
                    }
                    Log::info('Options created for question', [
                        'question_id'  => $question->id,
                        'option_count' => isset($questionData['options']) ? count($questionData['options']) : 0,
                    ]);
                }
            }

            Log::info('Questionnaire update completed successfully');
            Log::info('=== QUESTIONNAIRE UPDATE END ===');

            return redirect()->route('organizer.questionnaires.index')
                ->with('success', 'Questionnaire updated successfully');
        } catch (\Exception $e) {
            Log::error('=== QUESTIONNAIRE UPDATE ERROR ===');
            Log::error('Questionnaire update error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('=== END ERROR ===');

            return back()
                ->withErrors(['error' => 'Failed to update questionnaire: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Questionnaire $questionnaire)
    {
        $this->authorize('delete', $questionnaire);
        $questionnaire->delete();

        return redirect()->route('organizer.questionnaires.index')
            ->with('success', 'Questionnaire deleted successfully');
    }

    public function userQuestionnaires($eventId)
    {
        $event = Event::findOrFail($eventId);

        // Check if user is registered for this event
        $isRegistered = EventRegistration::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->exists();

        if (! $isRegistered) {
            return redirect()->route('user.events')->with('error', 'You must be registered for this event to view questionnaires.');
        }

        $questionnaires = Questionnaire::where('event_id', $eventId)
            ->where('status', 'published')
            ->whereNull('expires_at')
            ->orWhere('expires_at', '>', now())
            ->get();

        return view('user.questionnaires.index', compact('questionnaires', 'event'));
    }

    public function showResponseForm(Questionnaire $questionnaire)
    {
        // Check if user is registered for this event
        $isRegistered = EventRegistration::where('event_id', $questionnaire->event_id)
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->exists();

        if (! $isRegistered) {
            return redirect()->route('user.events')->with('error', 'You must be registered for this event to respond to questionnaires.');
        }

        // Check if user has already responded
        $hasResponded = QuestionResponse::whereIn('question_id', $questionnaire->questions->pluck('id'))
            ->where('user_id', Auth::id())
            ->exists();

        if ($hasResponded) {
            return back()->with('warning', 'You have already submitted your response for this questionnaire.');
        }

        return view('user.questionnaires.respond', compact('questionnaire'));
    }

    public function storeResponse(Request $request, Questionnaire $questionnaire)
    {
        $validated = $request->validate([
            'responses'   => 'required|array',
            'responses.*' => 'required',
        ]);

        foreach ($validated['responses'] as $questionId => $response) {
            QuestionResponse::create([
                'question_id'    => $questionId,
                'user_id'        => Auth::id(),
                'response_value' => is_array($response) ? json_encode($response) : $response,
            ]);
        }

        return redirect()->route('user.questionnaires.index', $questionnaire->event_id)
            ->with('success', 'Thank you for your response!');
    }

    public function showResponses(Questionnaire $questionnaire)
    {
        $this->authorize('view', $questionnaire);

        $questionnaire->load(['questions.options', 'event.registrations']);
        $responses = QuestionResponse::with('user')
            ->whereIn('question_id', $questionnaire->questions->pluck('id'))
            ->get();

        return view('organizer.questionnaires.responses', compact('questionnaire', 'responses'));
    }

}
