<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- 投稿・更新したあとに出るメッセージ --}}
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->dish_name }}"
                 class="w-full aspect-square object-cover rounded-lg bg-gray-200 mb-4">

            <h1 class="text-2xl font-bold mb-2">{{ $post->dish_name }}</h1>

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