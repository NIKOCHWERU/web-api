@php
    $categoryName = 'Kategori';
    if ($category_id) {
        $cat = \App\Models\Category::find($category_id);
        if ($cat) {
            $categoryName = $cat->name;
        }
    }
    
    $tagsArray = [];
    if (is_array($tags)) {
        $tagsArray = $tags;
    } elseif (is_string($tags)) {
        $decoded = json_decode($tags, true);
        if (is_array($decoded)) {
            $tagsArray = $decoded;
        } else {
            $tagsArray = array_filter(explode(',', $tags));
        }
    }

    $publishDate = $published_at ? \Carbon\Carbon::parse($published_at)->format('M d, Y') : now()->format('M d, Y');
    
    $snippet = $summary ?: (strip_tags($content) ?: 'Tulis ringkasan atau isi konten artikel Anda di kolom sebelah kiri untuk memperbarui cuplikan preview ini...');
    $snippet = \Illuminate\Support\Str::limit($snippet, 160);
    
    $imageUrl = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=800&q=80'; // default placeholder
    if ($image) {
        if (str_starts_with($image, 'http')) {
            $imageUrl = $image;
        } else {
            // If it's a temporary upload path or local storage path
            if (is_array($image)) {
                $firstImage = reset($image);
                if ($firstImage) {
                    $imageUrl = asset('storage/' . $firstImage);
                }
            } else {
                $imageUrl = asset('storage/' . $image);
            }
        }
    }
@endphp

<div class="rounded-xl border border-gray-200 bg-white shadow-sm transition dark:border-gray-800 dark:bg-gray-900 overflow-hidden max-w-full">
    <!-- Header/Hero Image -->
    <div class="relative h-44 w-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
        <img src="{{ $imageUrl }}" alt="Preview" class="h-full w-full object-cover object-center transition-all duration-300">
        
        <!-- Category Badge -->
        <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-semibold px-2.5 py-1 rounded shadow-sm">
            {{ $categoryName }}
        </span>
    </div>

    <!-- Content Area -->
    <div class="p-5">
        <!-- Title -->
        <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-snug line-clamp-2">
            {{ $title ?: 'Judul Artikel Anda Akan Muncul di Sini...' }}
        </h3>

        <!-- Author and Date -->
        <div class="mt-3 flex items-center gap-3">
            <!-- Author Avatar -->
            <div class="h-8 w-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs uppercase dark:bg-amber-950 dark:text-amber-300">
                A
            </div>
            
            <div class="text-xs">
                <p class="font-semibold text-gray-700 dark:text-gray-300">Admin</p>
                <p class="text-gray-500 dark:text-gray-400">{{ $publishDate }}</p>
            </div>
        </div>

        <!-- Snippet -->
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
            {!! $snippet !!}
        </p>

        <!-- Tags -->
        @if(count($tagsArray) > 0)
            <div class="mt-4 flex flex-wrap gap-1.5">
                @foreach($tagsArray as $tag)
                    <span class="bg-gray-100 text-gray-600 text-[10px] font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-400">
                        #{{ $tag }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Footer -->
        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold cursor-pointer">
                Baca selengkapnya &rarr;
            </span>
        </div>
    </div>
</div>
