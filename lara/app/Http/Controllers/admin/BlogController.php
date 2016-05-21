<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $posts = Post::orderBy('id', 'DESC')->paginate(config('blog.admin_posts_per_page'));
        

        return view('admin.blog.index', compact('posts')); 

    }

        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('admin.blog.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(BlogRequest $requestData)
    {
        //
        $post = new Post;
        $post->title= $requestData['title'];
        $post->content= $requestData['content'];
        
        $post->save();

        //Send control to index() method where it'll redirect to bookList.blade.php
        return redirect()->route('admin.blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get Result by targeting id
        $post = Post::find($id);

        //Redirecting to edit.blade.php with $post variable
        return view('admin.blog.edit')->with('post',$post);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
