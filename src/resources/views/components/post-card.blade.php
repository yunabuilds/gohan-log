@props(['post'])

<a href="{{ route('posts.show', $post) }}"
   class="block bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
    <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->dish_name }}"
         class="w-full aspect-square object-cover bg-gray-200">
    <div class="p-2">
        <p class="text-sm font-bold truncate">{{ $post->dish_name }}</p>
        <div class="flex items-center justify-between text-xs text-gray-600">
            <span>{{ $post->calories }} kcal</span>
            {{-- ♡ の数（withCount で取り出したときだけ表示） --}}
            @isset($post->favorites_count)
                <span class="flex items-center gap-0.5 text-gray-400">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    {{ $post->favorites_count }}
                </span>
            @endisset
        </div>
        <p class="text-xs text-gray-400 truncate">{{ $post->user->name }}</p>
    </div>
</a>