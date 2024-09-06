<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Models\Lesson;
use App\Models\Watched;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WatchedController extends Controller
{
    public $loggedUser;

    public function __construct()
    {
        $this->loggedUser = Auth::user();
    }


    public function markWatched(Lesson $lesson)
    {
        DB::beginTransaction();
        $errors = [];

        try {
            $watched = Watched::firstOrCreate([
                'user_id' => $this->loggedUser->id,
                'lesson_id' => $lesson->id,
                'date' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (count($errors) == 0) {
            DB::commit();
            LogAndFlash::success('Marcado como assistido!', $watched);
            return redirect()->back();
        } else {
            DB::rollBack();
            LogAndFlash::error('Erro ao tentar marcar como assistido!', $errors);
            return redirect()->back();
        }
    }

    public function markUnWatched(Lesson $lesson)
    {
        DB::beginTransaction();
        $errors = [];

        try {
            Watched::where('user_id', $this->loggedUser->id)
                ->where('lesson_id', $lesson->id)
                ->delete();
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (count($errors) == 0) {
            DB::commit();
            LogAndFlash::success('Marcado como não assistido!', $lesson);
            return redirect()->back();
        } else {
            DB::rollBack();
            LogAndFlash::error('Erro ao tentar marcar como não assistido!', $errors);
            return redirect()->back();
        }
    }
}
