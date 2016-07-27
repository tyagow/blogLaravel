<?php

namespace App\Http\Controllers;

use App\Post;

class PagesController extends Controller {

	public function getIndex() {
		$posts = Post::orderBy('id', 'desc')->limit(3)->get();

	    return view('pages/welcome')->with('posts',$posts);

	}
	public function getAbout() {

	    return view('pages/about');

	}
	public function getContact() {

	    return view('pages/contact');

	}


}