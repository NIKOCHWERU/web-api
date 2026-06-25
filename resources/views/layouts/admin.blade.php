<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Narasumber Hukum</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        /* ── Sidebar ─── */
        #sidebar { transition: width 0.25s cubic-bezier(.4,0,.2,1); width: 260px; }
        #sidebar.collapsed { width: 64px; }
        #sidebar .nav-label { transition: opacity 0.15s, width 0.15s; opacity: 1; white-space: nowrap; overflow: hidden; }
        #sidebar.collapsed .nav-label { opacity: 0; width: 0; }
        #sidebar .brand-text { transition: opacity 0.15s; }
        #sidebar.collapsed .brand-text { opacity: 0; pointer-events: none; }
        #main-content { transition: margin-left 0.25s cubic-bezier(.4,0,.2,1); }

        /* ── Quill ─── */
        .ql-toolbar.ql-snow { border-color: #374151; background: #1f2937; border-radius: 0.5rem 0.5rem 0 0; }
        .ql-toolbar.ql-snow .ql-stroke { stroke: #9ca3af; }
        .ql-toolbar.ql-snow .ql-fill { fill: #9ca3af; }
        .ql-toolbar.ql-snow .ql-picker { color: #9ca3af; }
        .ql-toolbar.ql-snow button:hover .ql-stroke, .ql-toolbar.ql-snow button.ql-active .ql-stroke { stroke: #f59e0b; }
        .ql-container.ql-snow { border-color: #374151; background: #111827; border-radius: 0 0 0.5rem 0.5rem; min-height: 320px; }
        .ql-editor { color: #e5e7eb; font-size: 15px; line-height: 1.7; min-height: 300px; }
        .ql-editor.ql-blank::before { color: #6b7280; }

        /* ── Scrollbar ─── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 3px; }

        .win-window {
            position: fixed;
            z-index: 9999;
            background: #1e2130;
            border: 1px solid #374151;
            border-radius: 6px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            display: flex;
            flex-direction: column;
            min-width: 320px;
            min-height: 200px;
            resize: both;
            overflow: hidden;
        }
        .win-window.maximized {
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            border-radius: 0;
            resize: none;
        }
        .win-titlebar {
            display: flex;
            align-items: center;
            height: 36px;
            background: #161b2e;
            border-bottom: 1px solid #2d3748;
            cursor: move;
            user-select: none;
            flex-shrink: 0;
            padding: 0 0 0 12px;
            border-radius: 6px 6px 0 0;
        }
        .win-window.maximized .win-titlebar { border-radius: 0; cursor: default; }
        .win-titlebar-icon { font-size: 12px; margin-right: 6px; }
        .win-titlebar-title { font-size: 12px; color: #d1d5db; flex: 1; font-weight: 500; }
        .win-controls { display: flex; height: 100%; margin-left: auto; }
        .win-btn {
            width: 46px; height: 100%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background 0.15s;
        }
        .win-btn svg { width: 10px; height: 10px; }
        .win-btn-min:hover { background: rgba(255,255,255,0.1); }
        .win-btn-max:hover { background: rgba(255,255,255,0.1); }
        .win-btn-close:hover { background: #e74c3c; }
        .win-btn-close:hover svg path { stroke: #fff; }
        .win-body { flex: 1; overflow: auto; }

        /* tag chip */
        .tag-chip { display: inline-flex; align-items: center; gap: 4px; background: rgba(245,158,11,0.2); color: #fbbf24; font-size: 11px; padding: 2px 8px; border-radius: 9999px; }

        /* Tooltip for collapsed sidebar */
        #sidebar.collapsed .nav-item { position: relative; }
        #sidebar.collapsed .nav-item:hover::after {
            content: attr(data-label);
            position: absolute;
            left: 60px;
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            border: 1px solid #374151;
            color: #fff;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 100;
            pointer-events: none;
        }

        /* Badge for contacts */
        .badge-dot { width: 7px; height: 7px; border-radius: 50%; background: #ef4444; display: inline-block; }

        /* ── LIGHT MODE OVERRIDES ── */
        html:not(.dark) body { background: #f8fafc; color: #1e293b; }
        html:not(.dark) #sidebar { background: #ffffff; border-color: #e2e8f0; }
        html:not(.dark) #sidebar .brand-text p { color: #0f172a; }
        html:not(.dark) #sidebar a { color: #475569; }
        html:not(.dark) #sidebar a:hover { background: #f1f5f9; color: #0f172a; }
        html:not(.dark) #sidebar .nav-item.active { background: rgba(245,158,11,0.1); color: #d97706; border-right-color: #f59e0b; }
        html:not(.dark) header { background: #ffffff; border-color: #e2e8f0; }
        html:not(.dark) header h1 { color: #0f172a; }
        html:not(.dark) header a, html:not(.dark) header button { color: #475569; }
        html:not(.dark) header a:hover, html:not(.dark) header button:hover { color: #0f172a; }
        html:not(.dark) .bg-gray-900 { background: #ffffff; border-color: #e2e8f0; }
        html:not(.dark) .bg-gray-950 { background: #f1f5f9; border-color: #e2e8f0; }
        html:not(.dark) .text-white { color: #0f172a; }
        html:not(.dark) .text-gray-300 { color: #334155; }
        html:not(.dark) .text-gray-400 { color: #475569; }
        html:not(.dark) .text-gray-500 { color: #64748b; }
        html:not(.dark) .border-gray-800 { border-color: #e2e8f0; }
        html:not(.dark) .border-gray-700 { border-color: #cbd5e1; }
        html:not(.dark) .bg-gray-950\/30 { background: rgba(241,245,249,0.5); }
        html:not(.dark) .bg-gray-950\/50 { background: rgba(241,245,249,0.8); }
        html:not(.dark) .bg-gray-950\/60 { background: rgba(241,245,249,0.9); }
        html:not(.dark) .win-window { background: #f1f5f9; border-color: #cbd5e1; color: #1e293b; }
        html:not(.dark) .win-titlebar { background: #e2e8f0; border-color: #cbd5e1; }
        html:not(.dark) .win-titlebar-title { color: #0f172a; }
        html:not(.dark) .win-body { background: #ffffff; }
        html:not(.dark) .ql-toolbar.ql-snow { background: #f1f5f9; border-color: #cbd5e1; }
        html:not(.dark) .ql-container.ql-snow { background: #ffffff; border-color: #cbd5e1; }
        html:not(.dark) .ql-editor { color: #0f172a; }
        html:not(.dark) input, html:not(.dark) select, html:not(.dark) textarea { background-color: #ffffff !important; border-color: #cbd5e1 !important; color: #0f172a !important; }
        html:not(.dark) input::placeholder, html:not(.dark) textarea::placeholder { color: #94a3b8 !important; }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-950 text-gray-100 flex overflow-hidden h-screen transition-colors duration-200"
      x-data="{
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        darkMode: localStorage.getItem('theme') !== 'light',
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main-content');
            if (this.sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                main.style.marginLeft = '64px';
            } else {
                sidebar.classList.remove('collapsed');
                main.style.marginLeft = '260px';
            }
        },
        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
      }"
      x-init="
        if (sidebarCollapsed) {
            document.getElementById('sidebar').classList.add('collapsed');
            document.getElementById('main-content').style.marginLeft = '64px';
        } else {
            document.getElementById('main-content').style.marginLeft = '260px';
        }
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
      ">

    <!-- ══ SIDEBAR ══════════════════════════════════════════════════════════ -->
    <aside id="sidebar" class="bg-gray-900 border-r border-gray-800 flex flex-col fixed top-0 left-0 h-full z-30 overflow-hidden">

        <!-- Brand -->
        <div class="flex items-center h-14 px-4 border-b border-gray-800 shrink-0">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
            </div>
            <div class="ml-3 brand-text">
                <p class="text-sm font-bold text-white leading-none">Narasumber</p>
                <p class="text-xs text-amber-400 font-medium">Hukum Admin</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden">
            <p class="nav-label text-[10px] font-semibold text-gray-500 uppercase tracking-widest px-4 mb-2">Menu</p>

            @php
                $unreadContacts = \App\Models\Contact::whereNull('read_at')->count();
            @endphp

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" data-label="Dashboard"
               class="nav-item flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-all
                      {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/10 text-amber-400 border-r-2 border-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="nav-label">Dashboard</span>
            </a>

            {{-- Articles --}}
            <a href="{{ route('admin.articles.index') }}" data-label="Articles"
               class="nav-item flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-all
                      {{ request()->routeIs('admin.articles*') ? 'bg-amber-500/10 text-amber-400 border-r-2 border-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="nav-label">Articles</span>
            </a>

            {{-- Categories --}}
            <a href="{{ route('admin.categories.index') }}" data-label="Categories"
               class="nav-item flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-all
                      {{ request()->routeIs('admin.categories*') ? 'bg-amber-500/10 text-amber-400 border-r-2 border-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="nav-label">Categories</span>
            </a>

            {{-- Contacts --}}
            <a href="{{ route('admin.contacts.index') }}" data-label="Contacts"
               class="nav-item flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-all relative
                      {{ request()->routeIs('admin.contacts*') ? 'bg-amber-500/10 text-amber-400 border-r-2 border-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <span class="relative shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    @if($unreadContacts > 0)
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </span>
                <span class="nav-label flex-1">Contacts</span>
                @if($unreadContacts > 0)
                    <span class="nav-label ml-auto bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shrink-0">{{ $unreadContacts }}</span>
                @endif
            </a>

            <div class="my-3 mx-4 border-t border-gray-800"></div>
            <p class="nav-label text-[10px] font-semibold text-gray-500 uppercase tracking-widest px-4 mb-2">System</p>

            {{-- Users --}}
            <a href="{{ route('admin.users.index') }}" data-label="Users"
               class="nav-item flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-all
                      {{ request()->routeIs('admin.users*') ? 'bg-amber-500/10 text-amber-400 border-r-2 border-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="nav-label">Users</span>
            </a>
        </nav>

        <!-- User card at bottom -->
        <div class="border-t border-gray-800 shrink-0">
            @if(auth()->check())
            <div class="flex items-center gap-3 px-4 py-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white text-xs font-bold uppercase shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0 nav-label">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="nav-label shrink-0">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-400 transition p-1" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
            @endif
        </div>
    </aside>

    <!-- ══ MAIN CONTENT ══════════════════════════════════════════════════════ -->
    <div id="main-content" class="flex flex-col min-h-screen flex-1 overflow-auto">

        <!-- Header -->
        <header class="bg-gray-900 border-b border-gray-800 px-5 py-3 flex items-center justify-between sticky top-0 z-20 h-14 shrink-0">
            <div class="flex items-center gap-4">
                <!-- Sidebar Toggle -->
                <button @click="toggleSidebar()" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <nav class="text-xs text-gray-500 flex items-center gap-1.5">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400">Admin</a>
                        @yield('breadcrumb')
                    </nav>
                    <h1 class="text-base font-bold text-white leading-tight">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Theme Toggle Button -->
                <button @click="toggleTheme()" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition" title="Toggle Theme">
                    <!-- Sun icon for light mode (visible in dark mode) -->
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                    <!-- Moon icon for dark mode (visible in light mode) -->
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                @yield('header-actions')
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-6 overflow-auto">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- ══ Windows 10 Window Engine ══════════════════════════════════════════ -->
    <script>
    (function() {
        let activeWindow = null, isDragging = false, isResizing = false;
        let dragOffsetX = 0, dragOffsetY = 0;
        let prevRect = null;

        window.WinManager = {
            init(id) {
                const win = document.getElementById(id);
                return win;
            },

            minimize(id) {
                const win = document.getElementById(id);
                if (!win) return;
                const body = win.querySelector('.win-body');
                if (body) {
                    const isMin = body.style.display === 'none';
                    body.style.display = isMin ? '' : 'none';
                    win.style.resize = isMin ? 'both' : 'none';
                }
            },

            toggleMax(win) {
                if (win.classList.contains('maximized')) {
                    // Restore
                    win.classList.remove('maximized');
                    if (prevRect) {
                        win.style.top    = prevRect.top + 'px';
                        win.style.left   = prevRect.left + 'px';
                        win.style.width  = prevRect.width + 'px';
                        win.style.height = prevRect.height + 'px';
                    }
                    win.style.resize = 'both';
                } else {
                    // Maximize
                    const rect = win.getBoundingClientRect();
                    prevRect = { top: rect.top, left: rect.left, width: rect.width, height: rect.height };
                    win.classList.add('maximized');
                    win.style.resize = 'none';
                }
            },

            maximize(id) {
                const win = document.getElementById(id);
                if (win) WinManager.toggleMax(win);
            },

            close(id) {
                const win = document.getElementById(id);
                if (win) win.style.display = 'none';
            },

            open(id) {
                const win = document.getElementById(id);
                if (!win) return;
                win.style.display = 'flex';
                // Center if not placed
                if (!win.style.top || win.style.top === '80px') {
                    win.style.top = '100px';
                    win.style.left = Math.max(0, (window.innerWidth - 420) / 2) + 'px';
                }
            }
        };

        // Event delegation for dragging
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

        // Event delegation for double click title = maximize
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
                activeWindow.style.top  = (e.clientY - dragOffsetY) + 'px';
                activeWindow.style.left = (e.clientX - dragOffsetX) + 'px';
            }
        });

        document.addEventListener('mouseup', function() {
            if (isDragging && activeWindow) {
                activeWindow.style.transition = '';
            }
            isDragging = false;
            activeWindow = null;
        });

        // Setup initial position of windows
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.win-window').forEach(function(win) {
                if (!win.style.top) {
                    win.style.top  = '100px';
                    win.style.left = (window.innerWidth - 420) + 'px';
                    if (win.style.left < 0) win.style.left = '20px';
                }
            });
        });
    })();
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
