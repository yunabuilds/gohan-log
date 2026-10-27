<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // 投稿者の情報も一緒に取り出し（N+1対策）、新しい順に1ページ12件
    $posts = Post::with('user')
        ->latest()
        ->paginate(12);

    return view('posts.index', compact('posts'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('posts.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
{
    // チェックを通った値だけを取り出す
    $data = $request->validated();

    // 写真を storage/app/public/posts に保存し、保存先のパスを image_path に入れる
    $data['image_path'] = $request->file('image')->store('posts', 'public');
    unset($data['image']);

    // ログイン中のユーザーの投稿として保存する（user_id は自動で入る）
    $post = auth()->user()->posts()->create($data);

    return redirect()->route('posts.show', $post)
        ->with('success', '投稿しました！');
}
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
{
    $post->load('user');

    return view('posts.show', compact('post'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
