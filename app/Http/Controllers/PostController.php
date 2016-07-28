<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;

use App\Category;

use Session;

class PostController extends Controller
{


    public function __construct() {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store all the blog post in it from the DB
        $posts = Post::orderBy('id', 'desc')->paginate(5);
        // return a view and pass in the above variable
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        $categories = Category::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request,array(
            'title'         => 'required|max:255',
            'body'          =>  'required',
            'slug'          =>  'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id'   => 'required|integer'           
            ));

        //store in the DB
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->category_id = $request->category_id;

        $post->save();
        $post->tags()->sync($request->tags,false);

        Session::flash('success','The Post was successfully save!');
        //redirect to another view
        return redirect()->route('posts.show',$post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $cats = [];

        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();

        $tags2 = [];

        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }

        $post = Post::find($id);
        return view('posts.edit')->with('post',$post)->withCategories($cats)->withTags($tags2);
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

        $post = Post::find($id);
        if  ($request->input('slug') == $post->slug ) {
            $this->validate($request,array(
                'title' => 'required|max:255',
                'body'  =>  'required',
                'category_id' => 'required|integer'
            ));
        }else {
             $this->validate($request,array(
                'title' => 'required|max:255',
                'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                'body'  =>  'required',
                'category_id' => 'required|integer'
             ));

        }

        
       

        //store in the DB
       

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->category_id = $request->input('category_id') ;
        $post->slug = $request->input('slug');


        $post->save();
        if (isset($request->tags)) {
            $post->tags()->sync($request->tags,true); // true == reset all relationships
        }else {
            $post->tags()->sync(array(),true); 
        }

        Session::flash('success','The Post was successfully edited!');

        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $post = Post::find($id);

        $post->tags()->detach();

        $post->delete();

        Session::flash('success','The post was successfully deleted!');
        return redirect()->route('posts.index');

    }
}
