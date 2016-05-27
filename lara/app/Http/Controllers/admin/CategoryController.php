<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Category;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
     
    $categories = Category::orderBy('id', 'DESC')->paginate(config('blog.admin_posts_per_page'));
        return view('admin.content.category.index', compact('categories')); 

    }

    public function create()
    {
        $category = new Category;
        return view('admin.content.category.create', compact('category'));
    }
    
    public function store(Request $request)
    {
        Category::create($request->all());
        return redirect('/admin/category');
    }
    
    public function show($id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        return view('admin.content.category.show', compact('category'));
    }
    public function edit($id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        return view('admin.content.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        $category->update($request->all());
        return redirect('/admin/category');

    }
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return redirect('/admin/category');
    }

}
