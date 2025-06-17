<?php
namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->whereDate('date', '>=', now())
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
        $this->authorize('update', $questionnaire);

        // Similar validation as store method
        $validated = $request->validate([
            'title'                     => 'required|string|max:255',
            'description'               => 'nullable|string',
            'event_id'                  => 'required|exists:events,id',
            'questions'                 => 'required|array|min:1',
            'questions.*.id'            => 'nullable|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:multiple_choice,checkbox,text,rating',
            'questions.*.is_required'   => 'boolean',
            'questions.*.options'       => 'required_if:questions.*.question_type,multiple_choice,checkbox|array',
            'questions.*.options.*'     => 'required_if:questions.*.question_type,multiple_choice,checkbox|string',
        ]);

        $questionnaire->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'event_id'    => $validated['event_id'],
        ]);

        // Delete questions not present in the update
        $questionIds = collect($validated['questions'])->pluck('id')->filter();
        $questionnaire->questions()->whereNotIn('id', $questionIds)->delete();

        foreach ($validated['questions'] as $index => $questionData) {
            $question = isset($questionData['id'])
            ? Question::find($questionData['id'])
            : new Question();

            $question->fill([
                'questionnaire_id' => $questionnaire->id,
                'question_text'    => $questionData['question_text'],
                'question_type'    => $questionData['question_type'],
                'is_required'      => $questionData['is_required'] ?? false,
                'order'            => $index + 1,
            ])->save();

            if (in_array($questionData['question_type'], ['multiple_choice', 'checkbox'])) {
                $question->options()->delete();
                foreach ($questionData['options'] as $optionIndex => $optionText) {
                    $question->options()->create([
                        'option_text' => $optionText,
                        'order'       => $optionIndex + 1,
                    ]);
                }
            }
        }

        return redirect()->route('organizer.questionnaires.index')
            ->with('success', 'Questionnaire updated successfully');
    }

    public function destroy(Questionnaire $questionnaire)
    {
        $this->authorize('delete', $questionnaire);
        $questionnaire->delete();

        return redirect()->route('organizer.questionnaires.index')
            ->with('success', 'Questionnaire deleted successfully');
    }
}
