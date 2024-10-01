<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\QuestionListItem;
use App\Models\QuestionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->_deleteNotFinishedQuestionLists();
        $questionLists = QuestionList::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('question_lists.index', compact('questionLists'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionList $questionList)
    {
        $this->_deleteNotFinishedQuestionLists();

        if (!isset($questionList->id)) {
            LogAndFlash::warning('Lista de perguntas inexistente');
            return redirect()->route('reviews.index');
        }
        return view('question_lists.show', compact('questionList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionList $questionList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionList $questionList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionList $questionList)
    {
        //
    }

    public function reviewByLesson(Lesson $lesson)
    {

        $questionListExistsInProgress = QuestionList::where('user_id', Auth::user()->id)
            ->where('finished', false)
            ->where('datetime_limit', '>', now())
            ->first();

        if ($questionListExistsInProgress) {
            LogAndFlash::warning('Voce ja possui uma lista de revisão pendente');
            return redirect()->route('reviews.first-question', $questionListExistsInProgress);
        }

        $this->_deleteNotFinishedQuestionLists();

        $newQuestionList = QuestionList::create([
            'user_id' => Auth::user()->id,
            'type' => 'review',
            'count_correct' => 0,
            'count_total' => 0,
            'datetime_limit' => now()->addMinutes(30),
            'finished' => false,
        ]);

        $questions = $lesson->questions()->get();
        foreach ($questions as $question) {
            $newQuestionListItem = QuestionListItem::create([
                'question_list_id' => $newQuestionList->id,
                'question_id' => $question->id,
                'answer_id' => null,
            ]);
        }

        $newQuestionList->count_total = $questions->count();
        $newQuestionList->save();

        LogAndFlash::success('Lista de revisão criada com sucesso', $newQuestionList);

        // Redirecionar para uma lista de perguntas
        return redirect()->route('reviews.first-question', $newQuestionList);
    }

    public function reviewQuestions(QuestionList $questionList)
    {
        //
    }

    public function answerQuestions(QuestionList $questionList, Question $question)
    {
        $this->_deleteNotFinishedQuestionLists();

        $questionListItens = $questionList->questionListItems()->where('question_id', $question->id)->first();
        if (!$questionListItens) {
            LogAndFlash::warning('Questão não pertence a lista de revisão');
            return redirect()->route('reviews.index');
        }

        $questionListItemActive = QuestionListItem::where('question_id', $question->id)->orderBy('id', 'desc')->first();
        return view('question_list_item.show', compact('questionList', 'questionListItemActive', 'question'));
    }

    public function showFirstQuestion(QuestionList $questionList)
    {
        $firstQuestion = $questionList->questionListItems()->first();
        return redirect()->route('reviews.answer-questions', [$questionList, $firstQuestion->question]);
    }

    public function checkAnswer(Request $request, QuestionListItem $questionListItem)
    {
        if ($request->myacc == '1') {

            $questionUser = QuestionUser::where('user_id', Auth::user()->id)->where('question_id', $questionListItem->question_id)->first();

            if (!$questionUser) {

                QuestionUser::create([
                    'user_id' => Auth::user()->id,
                    'question_id' => $questionListItem->question_id,
                    'last_view' => now(),
                    'next_view' => now()->addDay(1),
                    'score' => 1,
                    'factor' => 1,
                    'interval' => 1,
                ]);
            }
        } else {
            QuestionUser::where('user_id', Auth::user()->id)->where('question_id', $questionListItem->id)->delete();
        }

        $questionListItem->update(['answer_id' => $request->answer_id]);
        $questionListItem->save();

        LogAndFlash::success('Resposta registrada', $questionListItem);

        return redirect()->back();
    }

    public function checkAllAnswers(Request $request, QuestionList $questionList)
    {
        // se tiver um item sem resposta já retorna sem responder
        foreach ($questionList->questionListItems as $questionListItem) {

            if (!$questionListItem->answer_id) {
                dd($questionListItem);
                LogAndFlash::warning('Responda todas as questões antes de finalizar');
                return redirect()->back();
            }
        }

        foreach ($questionList->questionListItems as $questionListItem) {
            if ($questionListItem->answer_id == $questionListItem->question->correctAnswer()->id) {
                $questionListItem->update(['correct' => true]);
            }
        }

        $questionList->update([
            'finished' => true,
            'count_correct' => $questionList->questionListItems()->where('correct', true)->count(),
            'count_total' => $questionList->questionListItems()->count(),
        ]);

        LogAndFlash::success('Respostas registradas com sucesso', $questionList);
        return redirect()->route('reviews.index');
    }

    public function _deleteNotFinishedQuestionLists()
    {
        $questionListExistsNotFinished = QuestionList::with('questionListItems')->where('user_id', Auth::user()->id)
            ->where('finished', false)
            ->where('datetime_limit', '<', now())
            ->get();
        if ($questionListExistsNotFinished->count() > 0) {
            foreach ($questionListExistsNotFinished as $questionList) {
                $questionList->delete();
            }
            LogAndFlash::warning('Suas listas não concluídas foram excluídas');
        }
    }
}
