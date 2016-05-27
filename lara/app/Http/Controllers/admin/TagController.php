<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index()
    {
     
    $tags = Tag::orderBy('id', 'DESC')->paginate(config('blog.admin_posts_per_page'));
        return view('admin.content.tag.index', compact('tags')); 

    }

    public function create()
    {
        $tag = new Tag;
        return view('admin.content.tag.create', compact('tag'));
    }
    
    public function store(Request $request)
    {
        Tag::create($request->all());
        return redirect('/admin/tag');
    }
    
    public function show($id)
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        return view('admin.content.tag.show', compact('tag'));
    }
    public function edit($id)
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        return view('admin.content.tag.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        $tag->update($request->all());
        return redirect('/admin/tag');

    }
    public function destroy($id)
    {
        Tag::where('id', $id)->delete();
        return redirect('/admin/tag');
    }

}
