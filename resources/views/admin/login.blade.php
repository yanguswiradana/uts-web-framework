<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Secure Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-neutral-950 text-white h-screen flex items-center justify-center overflow-hidden relative">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-purple-700/30 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-blue-900/20 rounded-full blur-[100px] -z-10"></div>

    <div class="w-full max-w-md p-8 relative z-10">
        
        <div class="bg-neutral-900/60 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-white">Admin<span class="text-purple-500">Panel</span></h1>
                <p class="text-neutral-400 text-sm mt-2">Masuk untuk mengelola dashboard</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/50 text-red-400 text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-neutral-300">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" 
                            class="w-full bg-neutral-800/50 border border-neutral-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-neutral-500" 
                            placeholder="admin@example.com" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-neutral-300">Password</label>
                    <div class="relative">
                        <input type="password" name="password" 
                            class="w-full bg-neutral-800/50 border border-neutral-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-neutral-500" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-semibold py-3 rounded-xl shadow-lg shadow-purple-500/30 transition-all transform hover:scale-[1.02] active:scale-95">
                    Sign In Dashboard
                </button>
            </form>
            
            <div class="mt-6 text-center text-xs text-neutral-500">
                &copy; {{ date('Y') }} Admin System. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>