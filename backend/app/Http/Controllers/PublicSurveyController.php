<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicSurveyController extends Controller
{
    public function questions()
    {
        // Retourner toutes les questions avec leur ID
        return Question::all();
    }

    public function submit(Request $request)
{
    // Validation du formulaire
    $request->validate([
        'email' => 'required|email',
        'answers' => 'required|array|min:1',
        'answers.*.question_id' => 'required|exists:questions,id',
        'answers.*.value' => 'required|string', // Assurez-vous que la valeur est bien une chaîne
    ]);

    // Générer un token unique pour l'enquête
    $token = Str::uuid();

    // Créer une entrée dans la table Survey
    $survey = Survey::create([
        'email' => $request->email,
        'token' => $token,
    ]);

    // Sauvegarder les réponses pour chaque question
    foreach ($request->answers as $answer) {
        Answer::create([
            'survey_id' => $survey->id,
            'question_id' => $answer['question_id'],
            'value' => $answer['value'],
        ]);
    }

    // Réponse de succès avec un lien vers les résultats
    return response()->json([
        'message' => "Merci pour vos réponses !",
        'url' => url("/api/survey/result/{$token}")
    ]);
}

public function result($token)
{
    // Récupérer l'enquête et ses réponses avec la relation 'answers' et 'question'
    $survey = Survey::where('token', $token)
        ->with('answers.question') // Assurer la relation avec 'answers' et 'question'
        ->firstOrFail(); // En cas de non-trouvaille, renvoyer une erreur 404

    // Renvoi des données au frontend sous forme JSON
    return response()->json([
        'title' => $survey->title,
        'description' => $survey->description,
        'submitted_at' => $survey->created_at->toDateTimeString(), // Formater la date correctement
        'answers' => $survey->answers->map(function ($answer) {
            return [
                'question_title' => $answer->question->title,
                'value' => $answer->value,
            ];
        }),
    ]);
}


}
