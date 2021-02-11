<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\File;

//Controllers
use App\Http\Controllers\Controller;

//Models
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles= Article::orderBy('created_at', 'desc')->get();
        return view('back.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:10000'
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->categoryId = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $article->image = 'uploads/'.$imageName;
        }

        $article->save();
        toastr()->success('Makale Başarılı Bir Şekilde Oluşturuldu');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('back.articles.update', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:10000'
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->categoryId = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $article->image = 'uploads/'.$imageName;
        }

        $article->save();
        toastr()->success('Makale Başarılı Bir Şekilde Güncellendi');
        return redirect()->route('admin.makaleler.index');
    }

    public function switch(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->status = $request->status ? 1 : 0;
        $article->save();
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id)->delete();
        toastr()->success('Makale başarılı bir şekilde silindi.');
        return redirect()->route('admin.makaleler.index');
    }

    public function hardDelete($id)
    {
        $article = Article::onlyTrashed($id);
        if (File::exists($article->image)) {
            File::delete(public_path($article->image));
            $article->forceDelete();
            toastr()->success('Makale başarılı bir şekilde yok edildi.');
        }
        return redirect()->route('admin.makaleler.trashed');
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('back.articles.trashed', compact('articles'));
    }

    public function recover($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale başarılı bir şekilde kurtarıldı.');
        return redirect()->back();
    }
}
