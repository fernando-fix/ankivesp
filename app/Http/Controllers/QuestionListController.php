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
use Illuminate\Support\Facades\DB;

class QuestionListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->_deleteNotFinishedQuestionLists();
        $questionLists = QuestionList::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(15);

        return view('question_lists.index', compact('questionLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [];
        $data = $request->except('_token', 'modal_trigger');
        DB::beginTransaction();

        if (!$data['type'] == 'review') {
            toastr()->error('Tipo de lista inválido');
            DB::rollBack();
            return redirect()->back();
        }

        $questionListExistsInProgress = QuestionList::where('user_id', Auth::user()->id)
            ->where('finished', false)
            ->where('datetime_limit', '>', now())
            ->first();

        if ($questionListExistsInProgress) {
            LogAndFlash::warning('Voce ja possui uma lista de revisão pendente');
            DB::rollBack();
            return redirect()->route('reviews.first-question', $questionListExistsInProgress);
        }

        try {
            $this->_deleteNotFinishedQuestionLists();
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (isset($data['questions_number']) && $data['questions_number'] == 0) {
            $questionUsers = QuestionUser::where('user_id', Auth::user()->id)->where('next_view', '<', now())->get();
        } else {
            $questionUsers = QuestionUser::where('user_id', Auth::user()->id)->where('next_view', '<', now())->take($data['questions_number'] ?? 0)->get();
        }

        $duration = (float) ($data['duration'] ?? 30);

        if ($questionUsers->count() == 0) {
            DB::rollBack();
            LogAndFlash::success('Nenhuma questão para revisão');
            return redirect()->back();
        }

        try {
            $newQuestionList = QuestionList::create([
                'user_id' => Auth::user()->id,
                'type' => $data['type'],
                'count_correct' => 0,
                'count_total' => $questionUsers->count(),
                'datetime_limit' => now()->addMinutes($duration),
                'finished' => false,
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        foreach ($questionUsers as $question) {
            // verificar se question existe
            $question = Question::where('id', $question->question_id)->first();
            if ($question) {
                try {
                    $newQuestionListItem = QuestionListItem::create([
                        'question_list_id' => $newQuestionList->id,
                        'question_id' => $question->id,
                        'answer_id' => null,
                    ]);
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
        }

        try {
            $newQuestionList->count_total = $questionUsers->count();
            $newQuestionList->save();
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (count($errors) == 0) {
            DB::commit();
            LogAndFlash::success('Lista de revisão criada com sucesso', $newQuestionList);
            return redirect()->route('reviews.first-question', $newQuestionList);
        } else {
            DB::rollBack();
            LogAndFlash::error('Erro ao criar lista de revisão', $errors);
            return redirect()->back();
        }
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
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionList $questionList)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionList $questionList)
    {
        return redirect()->back();
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
        return redirect()->back();
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
                    'score' => 0.25,
                    'factor' => 1.8,
                    'interval' => 1,
                ]);
            }
        } else {
            QuestionUser::where('user_id', Auth::user()->id)->where('question_id', $questionListItem->id)->delete();
        }

        $questionListItem->update(['answer_id' => $request->answer_id]);
        $questionListItem->save();

        $questionList = $questionListItem->questionList;

        $notAnsweredQuestions = $questionList->questionListItems()->where('answer_id', null)->get();

        if ($notAnsweredQuestions->count() == 0) {
            LogAndFlash::success('Resposta registrada, já pode finalizar', $questionListItem);
            return redirect()->back();
        } else {
            LogAndFlash::success('Resposta registrada', $questionListItem);
            $nextQuestion = $notAnsweredQuestions->first();

            return redirect()->route('reviews.answer-questions', [$questionList, $nextQuestion->question]);
        }

        return redirect()->back();
    }

    public function checkAllAnswers(Request $request, QuestionList $questionList)
    {
        // se tiver um item sem resposta já retorna sem responder
        foreach ($questionList->questionListItems as $questionListItem) {

            if (!$questionListItem->answer_id) {
                LogAndFlash::warning('Responda todas as questões antes de finalizar');
                return redirect()->back();
            }
        }

        foreach ($questionList->questionListItems as $questionListItem) {
            if ($questionListItem->answer_id == $questionListItem->question->correctAnswer()->id) {
                $questionListItem->update(['correct' => true]);
            }

            $questionUser = QuestionUser::where('user_id', Auth::user()->id)->where('question_id', $questionListItem->question_id)->first();
            if (!$questionUser) {

                QuestionUser::create([
                    'user_id' => Auth::user()->id,
                    'question_id' => $questionListItem->question_id,
                    'last_view' => now(),
                    'next_view' => now()->addDay(1),
                    'score' => 0.25,
                    'factor' => 1.8,
                    'interval' => 1,
                ]);
            }

            $newScore = $questionListItem->answer_id == $questionListItem->question->correctAnswer()->id ? 0.15 : -0.35; //acertou 0.15 errado -0.35
            $newFactor = min(max($questionUser->factor + $newScore, 0.75), 2.50); // 0.75 a 2.50
            $newInterval = $newFactor * $questionUser->interval;
            $newView = now()->addDay($newInterval);

            $questionUser->update([
                'last_view' => now(),
                'next_view' => $newView,
                'score' => $newScore,
                'factor' => $newFactor,
                'interval' => $newInterval,
            ]);
        }

        $questionList->update([
            'finished' => true,
            'count_correct' => $questionList->questionListItems()->where('correct', true)->count(),
            'count_total' => $questionList->questionListItems()->count(),
        ]);

        LogAndFlash::success('Respostas registradas com sucesso', $questionList);
        return redirect()->route('reviews.index');
    }

    public function giveUp(Request $request, QuestionList $questionList)
    {
        $questionList->delete();

        LogAndFlash::success('Lista de questões excluída com sucesso', $questionList);
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
