<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    
    {
        $questions = [
            ['Votre adresse mail', 'B'],
            ['Votre âge', 'B'],
            ['Votre sexe', 'A', ['Homme', 'Femme', 'Préfère ne pas répondre']],
            ['Nombre de personne dans votre foyer (adulte & enfants)', 'C'],
            ['Votre profession', 'B'],
            ['Quel marque de casque VR utilisez-vous ?', 'A', ['Oculus Quest', 'Oculus Rift/s', 'HTC Vive', 'Windows Mixed Reality', 'Valve index']],
            ['Sur quel magasin d’application achetez vous des contenus VR ?', 'A', ['SteamVR', 'Occulus store', 'Viveport', 'Windows store']],
            ['Quel casque envisagez-vous d’acheter dans un futur proche ?', 'A', ['Occulus Quest', 'Occulus Go', 'HTC Vive Pro', 'PSVR', 'Autre', 'Aucun']],
            ['Combien de personnes utilisent votre casque VR pour Bigscreen ?', 'C'],
            ['Vous utilisez principalement Bigscreen pour :', 'A', ['regarder la TV en direct', 'regarder des films', 'travailler', 'jouer en solo', 'jouer en équipe']],
            ['Notez la qualité de l’image sur Bigscreen', 'C'],
            ['Notez le confort d’utilisation de l’interface', 'C'],
            ['Notez la connexion réseau de Bigscreen', 'C'],
            ['Notez la qualité des graphismes 3D', 'C'],
            ['Notez la qualité audio', 'C'],
            ['Souhaitez-vous des notifications plus précises ?', 'A', ['Oui', 'Non']],
            ['Souhaitez-vous inviter un ami via smartphone ?', 'A', ['Oui', 'Non']],
            ['Souhaitez-vous enregistrer des émissions TV ?', 'A', ['Oui', 'Non']],
            ['Souhaitez-vous jouer à des jeux exclusifs ?', 'A', ['Oui', 'Non']],
            ['Quelle nouvelle fonctionnalité pour Bigscreen ?', 'B'],
        ];

        foreach ($questions as $index => $q) {
            Question::create([
                'title' => $q[0],
                'type' => $q[1],
                'options' => $q[1] === 'A' ? $q[2] : null,
            ]);
        }
    }
}
