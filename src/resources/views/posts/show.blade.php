<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- 投稿・更新したあとに出るメッセージ --}}
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->dish_name }}"
                 class="w-full aspect-square object-cover rounded-lg bg-gray-200 mb-4">

            {{-- 料理名と ♡ ボタンを横並びに --}}
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-2xl font-bold">{{ $post->dish_name }}</h1>

                {{-- ♡ ボタン（Ajax：ページを再読み込みしない） --}}
                <div x-data="{
                    favorited: {{ $isFavorited ? 'true' : 'false' }},
                    count: {{ $favoritesCount }},
                    toggleFavorite() {
                        fetch('{{ route('posts.favorite', $post) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json',
                            },
                        })
                        .then(res => {
                            // ログインしていない（401）ときはログイン画面へ
                            if (res.status === 401) {
                                window.location.href = '{{ route('login') }}';
                                return null;
                            }
                            // それ以外のエラー（419 ページの期限切れ、500 など）のときは、画面を変えずに知らせる
                            if (!res.ok) {
                                alert('お気に入りに失敗しました。ページを再読み込みしてください');
                                return null;
                            }
                            return res.json();
                        })
                        .then(data => {
                            // 成功したときだけ ♡ と件数を変える
                            if (!data) return;
                            this.favorited = data.favorited;
                            this.count = data.count;
                        })
                        .catch(() => {
                            // 通信そのものが失敗したとき（ネットが切れているなど）
                            alert('通信に失敗しました。時間をおいてもう一度お試しください');
                        });
                    }
                }">
                    <button type="button" @click="toggleFavorite()"
                            :class="favorited ? 'text-red-500' : 'text-gray-400'"
                            class="flex items-center gap-1 text-lg"
                            aria-label="お気に入り">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span x-text="count"></span>
                    </button>
                </div>
            </div>

            <div class="text-gray-600 mb-4 space-y-1">
                <p>{{ $post->calories }} kcal</p>
                <p>食べた日：{{ $post->eaten_on }}</p>
                <p>投稿者：{{ $post->user->name }}</p>
            </div>

            {{-- メモは任意なので、あるときだけ表示 --}}
            @if ($post->memo)
                <p class="whitespace-pre-line mb-4">{{ $post->memo }}</p>
            @endif

            <div class="flex items-center gap-4">
                <a href="{{ route('posts.index') }}" class="text-blue-600">一覧に戻る</a>

                {{-- 自分の投稿のときだけ表示（Policy の update を使う） --}}
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="bg-gray-200 px-4 py-2 rounded">編集</a>
                @endcan

                {{-- 自分の投稿のときだけ表示（Policy の delete を使う） --}}
                @can('delete', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                          onsubmit="return confirm('この投稿を削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">削除</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>