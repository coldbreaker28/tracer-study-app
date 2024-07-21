<?php

namespace App\Http\Controllers\components;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Response;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    // Fungsi kuesioner / Questionnaire functions
    public function index()
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $questionnaires = Questionnaire::all();
        return view('questionnaires.index', compact('questionnaires', 'user'));
    }

    public function create()
    {
        $user = auth()->user();
        return view('questionnaires.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $questionnaire = Questionnaire::create($request->all());
        return redirect()->route('questionnaires.show', $questionnaire);
    }

    public function show(Questionnaire $questionnaire)
    {
        $user = auth()->user();
        return view('questionnaires.show', compact('questionnaire', 'user'));
    }

    public function edit(Questionnaire $questionnaire)
    {
        $user = auth()->user();
        return view('questionnaires.edit', compact('questionnaire', 'user'));
    }

    public function update(Request $request, Questionnaire $questionnaire)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $questionnaire->update($request->all());
        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire updated successfully');
    }

    public function destroy(Questionnaire $questionnaire)
    {
        $questionnaire->delete();
        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire deleted successfully');
    }

    // Fungsi pertanyaan / Question functions
    public function createQuestion(Questionnaire $questionnaire)
    {
        $user = auth()->user();
        return view('questionnaires.buat-kuis', compact('questionnaire', 'user'));
    }

    public function storeQuestion(Request $request, Questionnaire $questionnaire)
    {
        
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string',
            'options' => 'nullable|string',
        ]);

        $questionnaire->questions()->create($request->all());
        return redirect()->route('questionnaires.show', $questionnaire)->with('success', 'Question added successfully');
    }

    public function editQuestion(Question $question)
    {
        $user = auth()->user();
        return view('questionnaires.edit-kuis', compact('question', 'user'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string',
            'options' => 'nullable|string',
        ]);

        $question->update($request->all());
        return redirect()->route('questionnaires.show', $question->questionnaire)->with('success', 'Question updated successfully');
    }

    public function showQuestions(Questionnaire $questionnaire)
    {
        $user = auth()->user();
        return view('questionnaires.show-kuis', compact('questionnaire', 'user'));
    }
    
    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return redirect()->route('questionnaires.show', $question->questionnaire)->with('success', 'Question deleted successfully');
    }

    public function answer(Questionnaire $questionnaire)
    {
        return view('questionnaires.answer', compact('questionnaire'));
    }

    public function submitAnswer(Request $request, Questionnaire $questionnaire)
    {
        $responses = $request->except('_token');
        foreach ($responses as $question_id => $response) {
            Response::create([
                'user_id' => auth()->id(),
                'question_id' => $question_id,
                'response_text' => is_array($response) ? implode(',', $response) : $response
            ]);
        }
        return redirect()->route('questionnaires.index')->with('success', 'Answers submitted successfully');
    }
    
    public function showAnswers(Questionnaire $questionnaire)
    {
        $user = auth()->user();
        $answers = $questionnaire->responses()->with('question')->get();
        return view('questionnaires.show-answer', compact('questionnaire', 'answers', 'user'));
    }
}
