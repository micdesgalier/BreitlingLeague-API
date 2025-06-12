<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Question;
use App\Models\Choice;

class JsonQuestionSeeder extends Seeder
{
    public function run()
    {
        // Chemin vers le fichier JSON à importer
        $jsonPath = database_path('seeders/data.json');

        // Vérification de l'existence du fichier JSON
        if (! File::exists($jsonPath)) {
            $this->command->error("Le fichier data.json est introuvable dans database/seeders/");
            return;
        }

        // Lecture et décodage du contenu JSON en tableau associatif
        $jsonString = File::get($jsonPath);
        $payload = json_decode($jsonString, true);

        // Vérification que la clé 'quiz_data' existe et contient un tableau
        if (! isset($payload['quiz_data']) || ! is_array($payload['quiz_data'])) {
            $this->command->error("Le JSON doit contenir une clé 'quiz_data' qui est un tableau.");
            return;
        }

        $rows = $payload['quiz_data'];
        $countQuestions = 0;

        // Parcours de chaque question dans le tableau quiz_data
        foreach ($rows as $item) {
            // Validation des clés nécessaires dans chaque question
            if (
                ! isset($item['question_code']) ||
                ! isset($item['question_text']) ||
                ! isset($item['choices']) ||
                ! is_array($item['choices'])
            ) {
                $this->command->error("Objet JSON invalide (il manque 'question_code', 'question_text' ou 'choices') : " . json_encode($item));
                continue;
            }

            // Création ou mise à jour de la question en base selon son code unique
            $questionCode = (string) $item['question_code'];
            $question = Question::updateOrCreate(
                ['code_id' => $questionCode],
                [
                    'label'             => $item['question_text'],
                    'is_active'         => true,
                    'media_id'          => null,
                    'type'              => 'select',
                    'is_choice_shuffle' => false,
                    'correct_value'     => '',
                ]
            );

            // Parcours des choix associés à la question
            $order = 1;
            foreach ($item['choices'] as $c) {
                // Validation des clés nécessaires dans chaque choix
                if (
                    ! isset($c['choice_code']) ||
                    ! isset($c['choice_text']) ||
                    ! isset($c['is_correct'])
                ) {
                    $this->command->error("Choice JSON invalide (il manque 'choice_code', 'choice_text' ou 'is_correct') : " . json_encode($c));
                    continue;
                }

                // Création ou mise à jour du choix en base selon son code unique
                Choice::updateOrCreate(
                    ['code_id' => (string) $c['choice_code']],
                    [
                        'media_id'          => null,
                        'order'             => $order++,
                        'is_correct'        => (bool) $c['is_correct'],
                        'question_code_id'  => $question->code_id,
                        'label'             => $c['choice_text'],
                    ]
                );
            }

            $countQuestions++;
        }

        // Affichage du nombre de questions importées avec succès
        $this->command->info("Import JSON terminé : {$countQuestions} questions traitées.");
    }
}