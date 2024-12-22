<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Subscription;
use App\Models\TVShow;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        // Get the subscription plans, featured TV shows, and movies
        $subscriptions = Subscription::all();  // Fetch all subscription plans
        $featuredShows = TVShow::where('featured', true)->take(5)->get();  // Get 5 featured TV shows from 'tvshows' table
        $featuredMovies = Movie::where('featured', true)->take(5)->get();  // Get 5 featured movies

        return view('store.index', compact('subscriptions', 'featuredShows', 'featuredMovies'));
    }
}
