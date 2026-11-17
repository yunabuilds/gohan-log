<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">体重を記録する</h1>

            {{-- 送信したら sending を true にして、ボタンを押せなくする（2回押し対策） --}}
            <form method="POST" action="{{ route('weights.store') }}"
                  x-data="{ sending: false }" @submit="sending = true"
                  class="bg-white rounded-lg shadow p-6 space-y-4">
                @csrf

                <div>
                    <label class="block font-medium mb-1">体重（kg） <span class="text-red-600">*</span></label>
                    {{-- 小数第1位まで入れられるように step="0.1" --}}
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
                    <button type="submit" :disabled="sending"
                            class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
                            x-text="sending ? '記録中…' : '記録する'">記録する</button>
                    <a href="{{ route('mypage') }}" class="text-gray-600">マイページに戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>