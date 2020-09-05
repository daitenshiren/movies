<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use DB;
use App\Http\Requests;
use App\Http\Model\Movies as MoviesModel;
use App\Http\Resources\Movie as MoviesResource;

class MovieController extends BaseController
{
    public function index()
    {
        // Get movies
        $movies = MoviesModel::orderBy('title', 'asc')->paginate(5);

        return MoviesResource::collection($movies);
    }

    public function destroy($id)
    {
        // Get article
        $movie = MoviesModel::findOrFail($id);

        if($movie->delete()) {
            return new MoviesResource($movie);
        }
    }

    public function store(Request $request)
    {
        if($request->isMethod('put')) {

            $movie = MoviesModel::findOrFail($request->id);

            $movie->id = $request->id;

        } else {
            $movie = new MoviesModel;

            $last_id = DB::table('movies')->latest('id')->first();

            $movie->id = $last_id->id + 1;
        }

        $movie->title = $request->title;
        $movie->release_date = $request->release_date;
        $movie->duration = $request->duration;
        $movie->genre = $request->genre;

        if($movie->save()) {
            return new moviesResource($movie);
        }

    }

    public function show($id)
    {
        // Get movie
        $movie = MoviesModel::findOrFail($id);

        // Return single article as a resource
        return new MoviesResource($movie);
    }
}
