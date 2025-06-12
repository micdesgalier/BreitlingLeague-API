<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Retourne la liste de tous les challenges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Challenge::all();
    }

    /**
     * Crée un nouveau challenge après validation des données.
     *
     * @param  Request  $request
     * @return \App\Models\Challenge
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'   => 'required|string',
            'contenu' => 'required|string',
        ]);

        return Challenge::create($validated);
    }

    /**
     * Affiche un challenge spécifique.
     *
     * @param  Challenge  $challenge
     * @return \App\Models\Challenge
     */
    public function show(Challenge $challenge)
    {
        return $challenge;
    }

    /**
     * Met à jour les données d’un challenge existant.
     * Les champs sont facultatifs mais doivent être valides s'ils sont présents.
     *
     * @param  Request    $request
     * @param  Challenge  $challenge
     * @return \App\Models\Challenge
     */
    public function update(Request $request, Challenge $challenge)
    {
        $validated = $request->validate([
            'titre'   => 'sometimes|required|string',
            'contenu' => 'sometimes|required|string',
        ]);

        $challenge->update($validated);

        return $challenge;
    }

    /**
     * Supprime un challenge.
     *
     * @param  Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return response()->noContent();
    }
}