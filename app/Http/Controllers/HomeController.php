<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function changeLocale($locale)
    {
        \Session::put('locale', $locale);
        // dd($locale);
        app()->setLocale($locale);
        // dd(\App::getLocale());
        return redirect()->back();
    }
    /**
     * Clear css cache.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function fileVersion($uri){
        $file = $_SERVER['DOCUMENT_ROOT'].'/'.$uri;
        if (!file_exists($file)) return $file;

        return $uri.'?v='.filemtime ( $file );
    }
}
