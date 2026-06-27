<div class="relative hidden xl:block w-full xl:w-[430px]" x-data="{ open: false }" @click.away="open = false">
    <div class="relative">
        <span class="absolute -translate-y-1/2 pointer-events-none left-4 top-1/2">
            <!-- Search Icon -->
            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20"
                viewBox="0 0 20 20" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                    fill="" />
            </svg>
        </span>
        <input type="text" 
            wire:model.live.debounce.300ms="search" 
            @focus="open = true"
            placeholder="Search articles, users..."
            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pl-12 pr-14 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:bg-white/3 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
        
        <div wire:loading wire:target="search" class="absolute right-3 top-1/2 -translate-y-1/2">
            <svg class="w-4 h-4 animate-spin text-brand-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
    </div>

    <!-- Dropdown Results -->
    <div x-show="open && $wire.search.length >= 2" 
         x-transition
         class="absolute left-0 mt-2 w-full rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900 overflow-hidden z-[9999]"
         style="display: none;">
         
        @if(strlen($search) >= 2)
            @if(count($results['articles']) > 0 || count($results['categories']) > 0 || count($results['users']) > 0)
                <div class="max-h-[400px] overflow-y-auto custom-scrollbar p-2">
                    
                    @if(count($results['articles']) > 0)
                        <div class="mb-3 last:mb-0">
                            <h6 class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Articles</h6>
                            <ul class="flex flex-col gap-1">
                                @foreach($results['articles'] as $article)
                                    <li>
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 transition-colors">
                                            <div class="w-8 h-8 shrink-0 overflow-hidden rounded bg-gray-100 dark:bg-gray-800">
                                                @if($article->image_url)
                                                    <img src="{{ $article->image_url }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div class="flex-1 truncate">
                                                <p class="truncate font-medium">{{ $article->title }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(count($results['categories']) > 0)
                        <div class="mb-3 last:mb-0">
                            <h6 class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Categories</h6>
                            <ul class="flex flex-col gap-1">
                                @foreach($results['categories'] as $category)
                                    <li>
                                        <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 transition-colors">
                                            <div class="flex-1 truncate">
                                                <p class="truncate font-medium">{{ $category->name }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(count($results['users']) > 0)
                        <div class="mb-3 last:mb-0">
                            <h6 class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Users</h6>
                            <ul class="flex flex-col gap-1">
                                @foreach($results['users'] as $user)
                                    <li>
                                        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 transition-colors">
                                            <div class="w-8 h-8 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                                                <img src="{{ $user->profile_photo_url }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1 truncate">
                                                <p class="truncate font-medium">{{ $user->name }}</p>
                                                <p class="truncate text-xs text-gray-500">{{ $user->email }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            @else
                <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    No results found for "{{ $search }}"
                </div>
            @endif
        @endif
    </div>
</div>
