<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">お気に入り</h1>

            @if ($posts->isEmpty())
                <p class="text-gray-500">お気に入りした投稿はまだありません。投稿の ♡ を押すと、ここに並びます。</p>
            @else
                <div class="grid grid-cols-3 gap-2 md:gap-6">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>