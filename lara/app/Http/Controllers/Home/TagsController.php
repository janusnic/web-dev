<?php namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Tag;
use App\Article;
class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($slug)
    {
              
        $tag = Tag::findBySlug($slug);

        $articles = Article::with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return view('home.tags.show', compact('articles', 'tag'));
    }
}
