<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\File;

//Models
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('back.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('back.pages.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:10000'
        ]);

        $lastPage = Page::orderBy('order', 'desc')->first(); 

        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);
        $page->order = $lastPage->order + 1;

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $page->image = 'uploads/'.$imageName;
        }

        $page->save();
        toastr()->success('Sayfa Başarılı Bir Şekilde Oluşturuldu');
        return redirect()->route('admin.pages.index');
    }

    public function edit($id)
    {   
        $page = Page::findOrFail($id);
        return view('back.pages.update', compact('page'));
    }

    public function update(Request $request, $id)
    {   
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:10000'
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);

            $page->image = 'uploads/'.$imageName;
        }

        $page->save();
        toastr()->success('Sayfa Başarılı Bir Şekilde Güncellendi');
        return redirect()->route('admin.pages.index');
    }

    public function delete($id)
    {
        $page = Page::find($id);
        if (File::exists($page->image)) {
            File::delete(public_path($page->image));
            toastr()->success('Sayfa başarılı bir şekilde yok edildi.');
        }
        $page->delete();
        return redirect()->route('admin.pages.trashed');
    }


    public function statusSwitch(Request $request)
    {
        $page = Page::findOrFail($request->id);
        if($request->statu == 'false' ) $status = 0;
        else $status = 1;
        $page->status = $status;
        $page->save();
    }

    public function orders(Request $request)
    {
        print_r($request->get('page'));
        foreach ($request->get('page') as $key => $order) {
            Page::where('id', $order)->update(['order' => $key]);
        }
    }
}
