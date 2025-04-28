<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnswerSeeder extends Seeder
{
   /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On commence par créer un faux Survey
        $survey = Survey::create([
            'email' => 'test@example.com',
            'token' => Str::uuid(),
        ]);

        // On récupère toutes les questions
        $questions = Question::all();

        // Pour chaque question, on crée une réponse aléatoire
        foreach ($questions as $question) {
            // Génère une valeur selon le type de question
            $value = $this->generateRandomAnswer($question);

            Answer::create([
                'survey_id' => $survey->id,
                'question_id' => $question->id,
                'value' => $value,
            ]);
        }
    }

    private function generateRandomAnswer($question)
    {
        if ($question->type === 'A' && is_array($question->options)) {
            // Choisir une option aléatoire
            return $question->options[array_rand($question->options)];
        } elseif ($question->type === 'B') {
            // Saisir une réponse texte factice
            return 'Texte exemple';
        } elseif ($question->type === 'C') {
            // Donner un chiffre aléatoire entre 1 et 10
            return (string) rand(1, 10);
        } else {
            return 'Réponse inconnue';
        }
    }
}
