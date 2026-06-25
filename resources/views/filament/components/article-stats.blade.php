<div class="grid grid-cols-2 gap-3 mt-2">
    <div class="p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-800 text-center">
        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Word Count</span>
        <span class="block text-lg font-bold text-gray-900 dark:text-white mt-1">{{ number_format($word_count) }} words</span>
    </div>
    
    <div class="p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-800 text-center">
        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Character Count</span>
        <span class="block text-lg font-bold text-gray-900 dark:text-white mt-1">{{ number_format($char_count) }} chars</span>
    </div>
    
    <div class="col-span-2 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-800 text-center">
        <span class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Estimated Reading Time</span>
        <span class="block text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $read_time }} {{ $read_time > 1 ? 'mins' : 'min' }}</span>
    </div>
</div>
