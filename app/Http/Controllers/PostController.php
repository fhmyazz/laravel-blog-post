<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect('login_page');
        }
        // karena sudah menggunakan Model, maka cukup panggil nama Modelnya saja 
        // (di dalam model sudah terdapat query builder)
        // untuk yang active(), itu sudah dibuatkan di model, jadi cukup panggil nama methodnya saja
        $posts = Post::active()->get();

        $view_data = [
            'posts' => $posts
        ];

        return view('posts.index', $view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()){
            return redirect('login_page');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::check()){
            return redirect('login_page');
        }
        // parameter dari input(), itu ngebaca dari name si formnya, bukan id
        $title = $request->input('title');
        $content = $request->input('content');

        // bisa menggunakan static function insert() atau create()
        // kalau menggunakan create, harus whitelist column terlebih dahulu
        Post::create([
            'title' => $title,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // $posts = Storage::get('posts.txt');
        // $posts = explode("\n", $posts);

        // $new_posts = [
        //     count($posts)+1,
        //     $title,
        //     $content,
        //     date('Y-m-d H:i:s')
        // ];
        // $new_posts = implode(",", $new_posts);

        // array_push($posts, $new_posts);
        // $posts = implode("\n", $posts);

        // Storage::write('posts.txt', $posts);

        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::check()){
            return redirect('login_page');
        }
        // meng inisiasi variable yang menampung data blog, dan juga blog yang akan diakses berdasarkan id
        // $posts = Storage::get('posts.txt');
        // $posts = explode("\n", $posts);
        // $selected_data = Array();

        // melakukan loop untuk mencari data blog yang diakses menggunakan id
        // foreach($posts as $post){
        //     $post = explode(",", $post);
        //     if($post[0] == $id){
        //         $selected_data = $post;
        //         break;
        //     };
        // };
        
        // mencari data yang id di db = id diparam
        $post = Post::where('id', '=', $id)
                    // laravel akan return data array, butuh first() untuk return 1 data
                    ->first();
        $comments = $post->comments()->get();
        $total_comments = $post->totalComments();
        
        $view_data = [
            'post'     => $post,
            'comments' => $comments,
            'total_comments' => $total_comments
        ];
        return view('posts.show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::check()){
            return redirect('login_page');
        }
        // mencari data yang id di db = id diparam
        // ->where('id', $id) //bisa juga seperti ini
        $post = Post::where('id', '=', $id)
                    // laravel akan return data array, butuh first() untuk return 1 data
                    ->first();

        $view_data = [
        'post' => $post
        ];
        return view('posts.edit', $view_data);
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
        if(!Auth::check()){
            return redirect('login_page');
        }
        $title = $request->input('title');
        $content = $request->input('content');

        Post::where('id', '=', $id)
            ->update([
                'title' => $title,
                'content' => $content,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        
        return redirect("/posts/{$id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::check()){
            return redirect('login_page');
        }
        Post::where('id', '=', $id)
            ->delete();
        
        return redirect("/posts");
    }
}
