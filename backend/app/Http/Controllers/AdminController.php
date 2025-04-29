<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getDashboardData()
{
    // Répartition des réponses pour les questions 6, 7 et 10 (pie charts)
    $pieQuestions = [6, 7, 10];
    $pieData = [];

    foreach ($pieQuestions as $id) {
        $question = Question::find($id);
        $data = Answer::where('question_id', $id)
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->get();
        $pieData[] = [
            'question' => $question->title,
            'data' => $data
        ];
    }

    // Radar chart : Moyenne des notes pour les questions 11 à 15
    $radarQuestions = range(11, 15);
    $radarData = [];

    foreach ($radarQuestions as $id) {
        $question = Question::find($id);
        $average = Answer::where('question_id', $id)->avg(DB::raw('CAST(value AS DECIMAL)'));
        $radarData[] = [
            'question' => $question->title,
            'average' => round($average, 2)
        ];
    }

    return response()->json([
        'pieCharts' => $pieData,
        'radarChart' => $radarData
    ]);
}
public function getAllQuestions()
{
    return Question::select('id', 'title', 'type')->get();
}
public function getAllResponses()
{
    $surveys = Survey::with('answers.question')->get();

    return $surveys->map(function ($survey) {
        return [
            'email' => $survey->email,
            'submitted_at' => $survey->created_at->toDateTimeString(),
            'answers' => $survey->answers->map(function ($answer) {
                return [
                    'question_number' => $answer->question->id,
                    'question_title' => $answer->question->title,
                    'value' => $answer->value,
                ];
            }),
        ];
    });
}

}
