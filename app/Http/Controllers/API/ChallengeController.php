<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'   => 'required|string',
            'contenu' => 'required|string',
        ]);

        return Article::create($validated);
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'titre'   => 'sometimes|required|string',
            'contenu' => 'sometimes|required|string',
        ]);

        $article->update($validated);

        return $article;
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->noContent();
    }
}
