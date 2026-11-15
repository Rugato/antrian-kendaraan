<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrian Kendaraan</title>
    <!-- Menggunakan Tailwind CSS CDN untuk tampilan responsif dan rapi -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar Utama -->
    @auth
    <nav class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center space-x-6">
                <span class="font-bold text-lg tracking-wide">AntrianKendaraan</span>
                <div class="space-x-4 text-sm font-medium">
                    <a href="{{ route('antrian.index') }}" class="hover:text-indigo-200 {{ request()->routeIs('antrian.*') ? 'underline underline-offset-4 font-bold' : '' }}">
                        Data Antrian
                    </a>
                    <a href="{{ route('kendaraan.index') }}" class="hover:text-indigo-200 {{ request()->routeIs('kendaraan.*') ? 'underline underline-offset-4 font-bold' : '' }}">
                        Data Kendaraan
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                <span class="text-indigo-200">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-white font-medium transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Konten Utama -->
    <main class="max-w-6xl w-full mx-auto px-4 py-8 grow">
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-100 border border-emerald-400 text-emerald-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error Validasi -->
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>