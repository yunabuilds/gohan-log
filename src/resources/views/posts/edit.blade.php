<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">食事の記録を編集する</h1>

            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data"
                  class="bg-white rounded-lg shadow p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium mb-1">写真（差し替えるときだけ選ぶ）</label>
                    {{-- 今の写真を見せる --}}
                    <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->dish_name }}"
                         class="w-32 h-32 object-cover rounded bg-gray-200 mb-2">
                    <input type="file" name="image" accept="image/*" class="w-full">
                    @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">料理名 <span class="text-red-600">*</span></label>
                    <input type="text" name="dish_name" value="{{ old('dish_name', $post->dish_name) }}" maxlength="100"
                           class="w-full rounded border-gray-300">
                    @error('dish_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">カロリー（kcal） <span class="text-red-600">*</span></label>
                    <input type="number" name="calories" value="{{ old('calories', $post->calories) }}" min="0"
                           class="w-full rounded border-gray-300">
                    @error('calories') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">食べた日 <span class="text-red-600">*</span></label>
                    <input type="date" name="eaten_on" value="{{ old('eaten_on', $post->eaten_on) }}"
                           class="w-full rounded border-gray-300">
                    @error('eaten_on') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">メモ（任意）</label>
                    <textarea name="memo" rows="3" class="w-full rounded border-gray-300">{{ old('memo', $post->memo) }}</textarea>
                    @error('memo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">更新する</button>
                    <a href="{{ route('posts.show', $post) }}" class="text-gray-600">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>