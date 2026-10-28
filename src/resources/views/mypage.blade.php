<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">マイページ</h1>

            {{-- 日付で絞り込むフォーム（GET で送る） --}}
            <form method="GET" action="{{ route('mypage') }}" class="flex items-center gap-2 mb-6">
                <input type="date" name="date" value="{{ $date }}" class="rounded border-gray-300">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">表示</button>
            </form>
            @error('date') <p class="text-red-600 text-sm mb-4">日付を正しく入力してください。</p> @enderror

            <h2 class="font-bold mb-4">{{ $date }} の記録（{{ $posts->count() }}件）</h2>

            @if ($posts->isEmpty())
                <p class="text-gray-500">この日の記録はありません。</p>
            @else
                <div class="grid grid-cols-3 gap-2 md:gap-6">
                    @foreach ($posts as $post)
                        <a href="{{ route('posts.show', $post) }}" class="block bg-white rounded-lg shadow overflow-hidden">
                            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->dish_name }}"
                                 class="w-full aspect-square object-cover bg-gray-200">
                            <div class="p-2">
                                <p class="text-sm font-bold truncate">{{ $post->dish_name }}</p>
                                <p class="text-xs text-gray-600">{{ $post->calories }} kcal</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>