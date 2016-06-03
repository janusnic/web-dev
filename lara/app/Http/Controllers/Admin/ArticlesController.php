<?php namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Category;
use App\User;
use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::with('tags', 'category')->latest()->paginate(15);

        return view('admin.content.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tags = Tag::lists('name', 'id');

        $categories = Category::all();

        $article = new Article;



        return view('admin.content.articles.create', compact('article', 'tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $this->createArticle($request);

        
        flash()->success('Your article has been created!');

        return redirect('admin/articles');
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
        $article = Article::findBySlug($slug);

        return view('articles.show', compact('article'));
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
        $article = Article::where('id', $id)->firstOrFail();

        $tags = Tag::lists('name', 'id');

        $categories = Category::all();

        return view('admin.content.articles.edit', compact('article', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response=='checked'
     */
    public function update(ArticleRequest $request, $id)
    {
                
        $article = Article::where('id', $id)->firstOrFail();
       
        $article->update($request->all());

       // $article->syncTags($request->get('tags', []));

        $this->syncTags($article, $request->input('tag_list'));

        return redirect('admin/articles');
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
        Article::find($id)->delete();

        return redirect('admin/articles');
    }

    public function trash()
    {
        $articles = Article::with('tags', 'category')->onlyTrashed()->latest('deleted_at')->paginate(15);

        return view('admin.content.articles.trash', compact('articles'));
    }

    public function restore($id)
    {
        Article::onlyTrashed()->find($id)->restore();

        return redirect('admin/articles/index');
    }

    public function forceDelete($id)
    {
        Article::onlyTrashed()->find($id)->forceDelete();

        return redirect('admin/articles/trash');
    }

    public function syncTags(Article $article, array $tags)
    {
        foreach ($tags as $key => $tag) {
            if (!is_numeric($tag)) {
                $newTag = Tag::create(['name' => $tag]);
                $tags[$key] = $newTag->id;
            }
        }

        $article->tags()->sync($tags);
    }

    public function createArticle(ArticleRequest $request)
    {
        
        $article = Article::create($request->all());
        
        $this->syncTags($article, $request->input('tag_list'));
    }

    public function uploadImage()
    {
        if ($file = \Request::file('file')) {
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return ['error' => 'You may only upload png, jpg or gif.'];
            }

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/images/'.date('Y', time()).'/';
            $destinationPath = public_path().$folderName;
            $safeName        = uniqid().'.'.$extension;
            $file->move($destinationPath, $safeName);

            $filePath = $folderName.$safeName;
            $cdnPath = cdn($filePath);

            return ['filename'  => $cdnPath];
        } else {
            return ['error' => 'Error while uploading file'];
        }
    }
}
