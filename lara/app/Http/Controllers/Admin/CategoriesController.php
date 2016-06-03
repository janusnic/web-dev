<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(15);

        return view('admin.content.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::lists('title', 'id');

        //$categories = ['0' => '/'] + $categories;

        return view('admin.content.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->all());

        flash()->success('Your category has been created!');

      //  \Cache::tags('categories')->flush();

        return redirect('admin/categories');
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

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //$category = Category::findOrFail($id);

        $category = Category::where('id', $id)->firstOrFail();

        //$categories = Category::getTopLevel()->lists('name', 'id');

        //$categories = ['0' => '/'] + $categories;

        return view('admin.content.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        $category->update($request->all());

        // $category = Category::findOrFail($id);

        // $category->update($request->all());

       // \Cache::tags('categories')->flush();

        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();

        return redirect('admin/categories');
    }
}
