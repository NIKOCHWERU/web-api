<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — Narasumber Hukum</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <!-- Quill Editor (Required for Article Editor) -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Theme Store (TailAdmin) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                        'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-gray-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-gray-900');
                    }
                }
            });

            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Apply dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- WinManager for Preview Window (Migrated from old layout) -->
    <script>
        const WinManager = (function() {
            let isDragging = false;
            let activeWindow = null;
            let dragOffsetX = 0;
            let dragOffsetY = 0;
            const TITLEBAR_HEIGHT = 36;
            const MARGIN = 8;

            document.addEventListener('mousedown', function(e) {
                const titlebar = e.target.closest('.win-titlebar');
                if (!titlebar) return;
                const win = titlebar.closest('.win-window');
                if (!win) return;
                if (win.classList.contains('maximized')) return;
                if (e.target.closest('.win-controls')) return;

                isDragging = true;
                activeWindow = win;
                const rect = win.getBoundingClientRect();
                dragOffsetX = e.clientX - rect.left;
                dragOffsetY = e.clientY - rect.top;
                win.style.transition = 'none';
                e.preventDefault();
            });

            document.addEventListener('dblclick', function(e) {
                const titlebar = e.target.closest('.win-titlebar');
                if (!titlebar) return;
                const win = titlebar.closest('.win-window');
                if (!win) return;
                if (e.target.closest('.win-controls')) return;
                WinManager.toggleMax(win);
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging && activeWindow) {
                    var winW = activeWindow.offsetWidth;
                    var newTop  = Math.max(0, Math.min(e.clientY - dragOffsetY, window.innerHeight - TITLEBAR_HEIGHT));
                    var newLeft = Math.max(-(winW - MARGIN * 2 - 46 * 3), Math.min(e.clientX - dragOffsetX, window.innerWidth - MARGIN));
                    activeWindow.style.top  = newTop + 'px';
                    activeWindow.style.left = newLeft + 'px';
                }
            });

            document.addEventListener('mouseup', function() {
                if (isDragging && activeWindow) {
                    activeWindow.style.transition = '';
                }
                isDragging = false;
                activeWindow = null;
            });

            return {
                open: function(id) {
                    const win = document.getElementById(id);
                    if (win) {
                        win.style.display = 'flex';
                        if (!win.style.top || win.style.top === '0px') {
                            win.style.top = '80px';
                            win.style.left = Math.max(20, (window.innerWidth - 420) / 2) + 'px';
                        }
                    }
                },
                close: function(id) {
                    const win = document.getElementById(id);
                    if (win) win.style.display = 'none';
                },
                minimize: function(id) {
                    const win = document.getElementById(id);
                    if (win) {
                        win.classList.toggle('minimized');
                        win.classList.remove('maximized');
                    }
                },
                maximize: function(id) {
                    const win = document.getElementById(id);
                    if (win) this.toggleMax(win);
                },
                toggleMax: function(win) {
                    win.classList.toggle('maximized');
                    win.classList.remove('minimized');
                }
            };
        })();
    </script>
</head>

<body
    x-data="{ 'loaded': true}"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);"
    class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            
            <div class="p-4 mx-auto max-w-7xl md:p-6">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <h2 class="text-title-md2 font-bold text-black dark:text-white">
                            @yield('page-title', 'Dashboard')
                        </h2>
                        @yield('header-actions')
                    </div>

                    <nav>
                        <ol class="flex items-center gap-2">
                            <li>
                                <a class="font-medium text-gray-500 hover:text-amber-500" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                
                @yield('content')

                <!-- Livewire Component Injection -->
                @if(isset($slot))
                    {{ $slot }}
                @endif
            </div>
        </div>

    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
