<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Narasumber Hukum</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-950 text-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-xl shadow-2xl p-8">
        <div class="flex flex-col items-center mb-8">
            <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center mb-4 shadow-lg shadow-amber-500/20">
                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Narasumber Hukum</h1>
            <p class="text-gray-400 text-sm mt-1">Sign in to Admin Panel</p>
        </div>

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-colors">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password" required
                    class="w-full bg-gray-950 border border-gray-800 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-colors">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded bg-gray-950 border-gray-800 text-amber-500 focus:ring-amber-500/50 focus:ring-offset-gray-900">
                <label for="remember" class="ml-2 block text-sm text-gray-400">Remember me</label>
            </div>

            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 rounded-lg shadow-lg shadow-amber-500/20 transition-all">
                Sign in
            </button>
        </form>
    </div>
</body>
</html>
