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
        // 1) Charger le fichier JSON (data.json placé dans database/seeders/)
        $jsonPath = database_path('seeders/data.json');
        if (! File::exists($jsonPath)) {
            $this->command->error("Le fichier data.json est introuvable dans database/seeders/");
            return;
        }

        // 2) Lire et décoder le JSON
        $jsonString = File::get($jsonPath);
        $payload = json_decode($jsonString, true);

        if (! isset($payload['quiz_data']) || ! is_array($payload['quiz_data'])) {
            $this->command->error("Le JSON doit contenir une clé 'quiz_data' qui est un tableau.");
            return;
        }

        // 3) Boucler sur chaque objet dans quiz_data
        $rows = $payload['quiz_data'];
        $countQuestions = 0;

        foreach ($rows as $item) {
            // Vérifier les clés attendues dans chaque question
            if (
                ! isset($item['question_code']) ||
                ! isset($item['question_text']) ||
                ! isset($item['choices']) ||
                ! is_array($item['choices'])
            ) {
                $this->command->error("Objet JSON invalide (il manque 'question_code', 'question_text' ou 'choices') : " . json_encode($item));
                continue;
            }

            // 4) Créer ou mettre à jour la Question
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

            // 5) Pour chaque choix dans 'choices'
            $order = 1;
            foreach ($item['choices'] as $c) {
                if (
                    ! isset($c['choice_code']) ||
                    ! isset($c['choice_text']) ||
                    ! isset($c['is_correct'])
                ) {
                    $this->command->error("Choice JSON invalide (il manque 'choice_code', 'choice_text' ou 'is_correct') : " . json_encode($c));
                    continue;
                }

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

        $this->command->info("Import JSON terminé : {$countQuestions} questions traitées.");
    }
}