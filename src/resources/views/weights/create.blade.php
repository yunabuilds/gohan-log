<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">体重を記録する</h1>

            <form method="POST" action="{{ route('weights.store') }}"
                  class="bg-white rounded-lg shadow p-6 space-y-4">

                                {{-- 確認用：全部のエラーを表示（原因が分かったら、この @if 〜 @endif を消す） --}}
                @if ($errors->any())
                    <ul class="text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @csrf

                <div>
                    <label class="block font-medium mb-1">体重（kg） <span class="text-red-600">*</span></label>
                    {{-- 修正①：小数第1位まで入れられるように step="0.1" を追加 --}}
                    <input type="number" name="weight" value="{{ old('weight') }}" step="0.1" min="20" max="300"
                           class="w-full rounded border-gray-300">
                    @error('weight') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">記録した日 <span class="text-red-600">*</span></label>
                    {{-- 初期値は今日 --}}
                    <input type="date" name="recorded_on" value="{{ old('recorded_on', now()->toDateString()) }}"
                           class="w-full rounded border-gray-300">
                    @error('recorded_on') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">記録する</button>
                    <a href="{{ route('mypage') }}" class="text-gray-600">マイページに戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>