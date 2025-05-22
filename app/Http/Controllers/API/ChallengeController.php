<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index()
    {
        return Challenge::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'   => 'required|string',
            'contenu' => 'required|string',
        ]);

        return Challenge::create($validated);
    }

    public function show(Challenge $challenge)
    {
        return $challenge;
    }

    public function update(Request $request, Challenge $challenge)
    {
        $validated = $request->validate([
            'titre'   => 'sometimes|required|string',
            'contenu' => 'sometimes|required|string',
        ]);

        $challenge->update($validated);

        return $challenge;
    }

    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return response()->noContent();
    }
}
