<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

//Models 
use App\Models\Config;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::find(1);
        return view('back.config.index', compact('config'));
    }

    public function update(Request $request)
    {
        $config = Config::find(1);
        $config->title = $request->title;
        $config->active = $request->active;
        $config->facebook = $request->facebook;
        $config->twitter = $request->twitter;
        $config->linkedin = $request->linkedin;
        $config->youtube = $request->youtube;
        $config->github = $request->github;
        $config->instagram = $request->instagram;

        if($request->hasFile('logo')){
            $logoName= Str::slug($request->title).'-logo.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads'), $logoName);
            $config->logo = 'uploads/'.$logoName;
        }

        if($request->hasFile('favicon')){
            $favIconName= Str::slug($request->title).'-favIcon.'.$request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads'), $favIconName);
            $config->favicon = 'uploads/'.$favIconName;
        }

        $config->save();
        toastr()->success('Ayarlar başarılı bir şekilde güncellendi.');
        return redirect()->back();
    }
}
