<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieBroadcast;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }

        $movies = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($movies);
    }

    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        $broadcasts = MovieBroadcast::where('movie_id', $id)
            ->where('broadcasts_at', '>=', now())
            ->orderBy('broadcasts_at')
            ->paginate(10);

        return response()->json([
            'movie' => $movie->toArray(),
            'broadcasts' => $broadcasts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'rating' => 'required|numeric|between:0.0,10.0',
            'age_restriction' => 'nullable|string|max:2',
            'description' => 'required|string|max:500',
            'premieres_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $movie = Movie::create($validated);

        return response()->json($movie, 201);
    }

    public function addBroadcast(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'channel_nr' => 'required|integer',
            'broadcasts_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $validated['movie_id'] = $movie->id;

        $broadcast = MovieBroadcast::create($validated);

        return response()->json($broadcast, 201);
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return response()->json(null, 204);
    }
}
