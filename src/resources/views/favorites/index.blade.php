<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">お気に入り</h1>

            @if ($posts->isEmpty())
                <p class="text-gray-500">お気に入りした投稿はまだありません。投稿の ♡ を押すと、ここに並びます。</p>
            @else
                <div class="grid grid-cols-3 gap-2 md:gap-6">
                    @foreach ($posts as $post)
                        <a href="{{ route('posts.show', $post) }}" class="block bg-white rounded-lg shadow overflow-hidden">
                            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->dish_name }}"
                                 class="w-full aspect-square object-cover bg-gray-200">
                            <div class="p-2">
                                <p class="text-sm font-bold truncate">{{ $post->dish_name }}</p>
                                <p class="text-xs text-gray-600">{{ $post->calories }} kcal</p>
                                <p class="text-xs text-gray-400 truncate">{{ $post->user->name }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>