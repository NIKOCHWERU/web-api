@php
    $items = \App\Models\Article::with('category')->latest('updated_at')->take(5)->get();
@endphp

<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-2">Title</th>
                <th scope="col" class="px-4 py-2">Status</th>
                <th scope="col" class="px-4 py-2">Category</th>
                <th scope="col" class="px-4 py-2">Update</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $art)
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-800">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white line-clamp-1 max-w-[200px]">
                        {{ $art->title }}
                    </th>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $art->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300' : ($art->status === 'review' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300') }}">
                            {{ ucfirst($art->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        {{ $art->category?->name ?: '-' }}
                    </td>
                    <td class="px-4 py-3 text-xs">
                        {{ $art->updated_at->format('M d, Y') }}
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-800">
                    <td colspan="4" class="px-4 py-3 text-center text-gray-400">
                        Belum ada artikel.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
