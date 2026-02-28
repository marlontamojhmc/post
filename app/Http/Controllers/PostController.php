<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(8);
        return Inertia::render('Post/Index',[
             'posts' =>$posts,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return Inertia::render('Post/Create',[
           'status' => null,
          ]);
    }
    public function send( $id)
{     $post = Post::with('verifier')->findOrFail($id);
        $post->verified_at?->diffForHumans();
    return Inertia::render('Post/Create', [
        'post' => $post,
        ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    { $post = Post::with('verifier')->findOrFail($id);
      $post->verified_at_human = $post->verified_at?->diffForHumans();
        return Inertia::render('Post/Create', [
        'post' => $post,
        ]);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function verify(Post $post){

    $post->verify();
    return redirect()->route('posts.show',$post->id);
    }
    public function unverify(Post $post){
        $post->unverify();

        return redirect()->route('posts.show',$post->id);

    }
}
