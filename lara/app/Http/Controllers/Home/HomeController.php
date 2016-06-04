<?php namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Article;

class HomeController extends Controller
{

    public function index()
    {
        
        $articles = Article::with('tags', 'category')->latest()->get();

        //print_r($articles);

        return view('home.index', compact('articles'));
    }
}
