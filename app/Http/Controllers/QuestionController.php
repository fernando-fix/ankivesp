<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Http\Requests\QuestionRequest;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    private $pagination = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $questions = Question::search()->with('answers', 'module', 'lesson')->paginate($this->pagination);
        $courses = Course::get();
        $modules = Module::get();
        $lessons = Lesson::get();

        return view('questions.index', compact('questions', 'courses', 'modules', 'lessons', 'filter'));
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
    public function store(QuestionRequest $request)
    {
        DB::beginTransaction();
        $data = $request->except(['_token', 'modal_trigger']);
        $errors = [];
        dd($data);

        try {
            $question = Question::create([
                'question' => $data['question'],
                'lesson_id' => $data['lesson_id'],
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        foreach ($data['answers'] as $key => $answer) {


            try {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $answer['answer'],
                    'correct' => $data['correct_answer'] == "answer_" . ($key + 1) ? true : false,
                ]);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
            $dd[] = $data['correct_answer'];
        }

        if (count($errors) == 0) {
            DB::commit();
            LogAndFlash::success('Registro criado com sucesso!', ['question' => $question]);
            return redirect()->route('questions.index');
        } else {
            DB::rollBack();
            LogAndFlash::error('Erro ao tentar criar o registro!', $errors);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        DB::beginTransaction();
        $data = $request->except(['_token', 'modal_trigger']);
        $errors = [];

        try {
            $question->update([
                'lesson_id' => $data['lesson_id'],
                'question' => $data['question'],
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $answers = $data['answers'];

        try {
            foreach ($answers as $key => $answer) {
                if (isset($answer['answer_id'])) {
                    $answerUpd = Answer::find($answer['answer_id']);
                    $answerUpd->answer = $answer['answer'];
                    $answerUpd->correct = $data['correct_answer'] == "answer_" . ($key + 1) ? true : false;
                    $answerUpd->save();
                }
            }
        } catch (\Exception $e) {
            throw $e;
            $errors[] = $e->getMessage();
        }

        if (count($errors) == 0) {
            DB::commit();
            LogAndFlash::success('Registro atualizado com sucesso!', ['question' => $question]);
            return redirect()->route('questions.index');
        } else {
            DB::rollBack();
            LogAndFlash::error('Erro ao tentar atualizar o registro!', $errors);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question) {}
}
