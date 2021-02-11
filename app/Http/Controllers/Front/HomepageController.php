<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

use Validator;

// Models
use App\Models\Article;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Config;
use App\Models\Page;

class HomepageController extends Controller
{

    public function __construct()
    {   //bütün fonksiyonlarda kullanılan değişkenleri kod tekrarını azaltmak için 
        //construct metodunda aşağıda ki gibi tanımlanabilir.

        if(Config::find(1)->active == 0){
            return redirect()->to('aktif-degil')->send();
        }

        view()->share('pages', Page::orderBy('order', 'ASC')->get());
        view()->share('categories', Category::inRandomOrder()->get());
    }

    public function index()
    {
        $data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(2);
        $data['articles']->withPath(url('sayfa'));
        return view('front.homepage', $data);
    }

    public function single($category, $slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403, 'Böyle bir kategori bulunamadı.');
        $article = Article::whereSlug($slug)->where('categoryId', $category->id)->first() ?? abort(403, 'Böyle bir yazı bulunamadı.');
        $article->increment('hit');
        $data['article'] = $article;
        return view('front.single', $data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle bir kategori bulunamadı.');
        $data['category'] = $category;

        $data['articles'] = Article::where('categoryId', $category->id)->orderBy('created_at', 'DESC')->paginate(1);
        return view('front.category', $data);
    }

    public function page($slug)
    {
        $page = Page::whereSlug($slug)->first() ?? abort(403, 'Böyle bir sayfa bulunamadı.');
        $data['page'] = $page;
        return view('front.page', $data);
    }

    public function contact()
    {
        return view('front.contact');;
    }

    public function contactPost(Request $request)
    {

        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10',
        ];
        $validate = Validator::make($request->post(), $rules);

        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save();

        Mail::raw('Mesajınız alındı. Teşekkürler.
                   Mesaj Gönderen: '.$request->name.'<br/>
                   Mesaj Gönderen Mail: '.$request->email.'<br/>
                   Mesaj Konusu: '.$request->topic.'<br/>
                   Mesaj: '.$request->message.'<br/>
                   Mesaj Gönderilme Tarihi: '.$request->created_at.'
        ', function($message) use($request){
            $message->from('iletisim@blogsitesi.com', 'Blog Sitesi');
            $message->to('allstarg4m3@gmail.com');
            $message->subject($request->name.' kişisi iletişimden mesaj gönderdi.');
        });

        return redirect()->route('contact')->with('success', 'İletiniz başarılı bir şekilde alındı. Teşekkürler.');
    }
}
