@php
    $scoreColor = $score >= 80 ? 'bg-green-500' : ($score >= 50 ? 'bg-yellow-500' : 'bg-red-500');
    $readColor = $readability === 'Good' ? 'bg-green-500' : ($readability === 'Ok' ? 'bg-yellow-500' : 'bg-red-500');
@endphp

<div class="mt-4 space-y-3 p-4 bg-gray-50 rounded-lg dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
    <div class="flex items-center justify-between text-sm">
        <span class="font-medium text-gray-700 dark:text-gray-300">Visual SEO Score</span>
        <div class="flex items-center gap-1.5 font-bold text-gray-900 dark:text-white">
            <span class="h-2 w-2 rounded-full {{ $scoreColor }} animate-pulse"></span>
            <span>{{ $score }}/100</span>
        </div>
    </div>
    
    <!-- Dynamic Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
        <div class="h-1.5 rounded-full {{ $score >= 80 ? 'bg-green-500' : ($score >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $score }}%"></div>
    </div>

    <div class="flex items-center justify-between text-sm pt-1">
        <span class="font-medium text-gray-700 dark:text-gray-300">Readability Score</span>
        <div class="flex items-center gap-1.5 font-bold text-gray-900 dark:text-white">
            <span class="h-2 w-2 rounded-full {{ $readColor }}"></span>
            <span>{{ $readability }}</span>
        </div>
    </div>
</div>
