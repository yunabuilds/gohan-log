<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- 削除したあとなどに出るメッセージ --}}
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <h1 class="text-2xl font-bold mb-6">投稿一覧</h1>

            {{-- 3列で並べる（Figma の 01 投稿一覧と同じ） --}}
            <div class="grid grid-cols-3 gap-2 md:gap-6">
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            {{-- ページの切り替え（1ページ12件） --}}
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    {{-- 投稿ボタン：画面の右下に固定（ログイン中だけ表示） --}}
    @auth
        <a href="{{ route('posts.create') }}"
           class="fixed bottom-6 right-6 w-14 h-14 rounded-full bg-blue-600 text-white text-3xl shadow-lg flex items-center justify-center"
           aria-label="投稿する">
            +
        </a>
    @endauth
</x-app-layout>