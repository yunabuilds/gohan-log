<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">マイページ</h1>

            {{-- 体重を記録したあとなどに出るメッセージ --}}
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            {{-- 日付で絞り込むフォーム（GET で送る） --}}
            <form method="GET" action="{{ route('mypage') }}" class="flex items-center gap-2 mb-6">
                <input type="date" name="date" value="{{ $date }}" class="rounded border-gray-300">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">表示</button>
            </form>
            @error('date') <p class="text-red-600 text-sm mb-4">日付を正しく入力してください。</p> @enderror

            {{-- その日の合計カロリー（US-9） --}}
            <p class="text-lg font-bold mb-4">合計：{{ $totalCalories }} kcal</p>

            <h2 class="font-bold mb-4">{{ $date }} の記録（{{ $posts->count() }}件）</h2>

            @if ($posts->isEmpty())
                <p class="text-gray-500">この日の記録はありません。</p>
            @else
                <div class="grid grid-cols-3 gap-2 md:gap-6">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            @endif

            {{-- 体重の記録（US-11）：日付の絞り込みとは関係なく、全部の日を新しい順に出す --}}
            <div class="mt-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold">体重の記録</h2>
                    <a href="{{ route('weights.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">＋ 体重を記録する</a>
                </div>

                @if ($weights->isEmpty())
                    <p class="text-gray-500">まだ体重の記録はありません。</p>
                @else
                    <ul class="bg-white rounded-lg shadow divide-y">
                        @foreach ($weights as $weight)
                            <li class="flex justify-between px-4 py-2">
                                <span>{{ $weight->recorded_on }}</span>
                                <span>{{ $weight->weight }} kg</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>