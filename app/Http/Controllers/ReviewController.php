<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // duas situações
    // 1. O usuário vai fazer a revisão das questões pela primeira vez, então vai associar as questões a propria conta enquanto estiver respondendo as questões
    // query question where lesson id = lesson id


    // 2. as questões serão listadas de acordo com a tabela de revisões
    // query question where has question revision table where next_lesson > today
}
