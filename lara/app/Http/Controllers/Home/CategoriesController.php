<?php namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Category;
use App\Article;
class CategoriesController extends Controller
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
        $category = Category::findBySlug($slug);

        $articles = Article::with('tags', 'category')->whereHas('category', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return view('home.categories.show', compact('articles', 'category'));
    }
}
