<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('only_trashed')) {
            return Genre::onlyTrashed();
        }
        return Genre::all();
    }

    public function store(GenreRequest $request)
    {
        return Genre::create($request->all());
    }

    public function show(Genre $genre)
    {
        return $genre;
    }

    public function update(GenreRequest $request, Genre $genre)
    {
        $genre->update($request->all());
        return $genre;
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->noContent();
    }
}
