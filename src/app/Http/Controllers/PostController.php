<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

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

    // ログインしているときだけ「自分がお気に入りしているか」を調べる（予想32の対策）
    $isFavorited = auth()->check()
        ? $post->favorites()->where('user_id', auth()->id())->exists()
        : false;

    $favoritesCount = $post->favorites()->count();

    return view('posts.show', compact('post', 'isFavorited', 'favoritesCount'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
{
    $this->authorize('update', $post);   // 自分の投稿か確認（Policy）

    return view('posts.edit', compact('post'));
}

public function update(UpdatePostRequest $request, Post $post)
{
    $this->authorize('update', $post);

    $data = $request->validated();

    // 写真を差し替えたときだけ：新しい写真を保存して、古い写真を消す
    if ($request->hasFile('image')) {
        $oldPath = $post->image_path;
        $data['image_path'] = $request->file('image')->store('posts', 'public');
        Storage::disk('public')->delete($oldPath);
    }
    unset($data['image']);

    $post->update($data);

    return redirect()->route('posts.show', $post)
        ->with('success', '更新しました！');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
{
    $this->authorize('delete', $post);   // 自分の投稿か確認（Policy）

    $imagePath = $post->image_path;

    // 投稿を消してから、写真のファイルも消す
    $post->delete();
    Storage::disk('public')->delete($imagePath);

    return redirect()->route('posts.index')
        ->with('success', '削除しました');
}
}
