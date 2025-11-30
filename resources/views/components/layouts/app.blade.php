<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Vehicle System')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex">

  {{-- Sidebar --}}
  <aside class="w-64 bg-black border-r border-red-700 hidden md:block">
    <div class="p-4 flex items-center gap-3 border-b border-red-700">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaMUOE9t4Zm2TR-zwNE23OFaLhyt1Dm4zk-A&s" alt="Autonova Logo" class="h-10 w-10 object-contain">
      <div>
        <div class="font-bold text-red-500 text-lg">AUTONOVA</div>
      </div>
    </div>

    <nav class="p-4">
      <a href="{{ route('dashboard') }}"
         class="border border-red-500 block p-2 rounded mb-1 {{ request()->routeIs('dashboard') ? 'bg-red-500 text-white font-semibold' : 'text-red-500 hover:bg-white' }}">
        Dashboard
      </a>

      <a href="{{ route('brands.index') }}"
         class="border border-red-500 block p-2 rounded mb-1 {{ request()->routeIs('brands.index') ? 'bg-red-500 text-white font-semibold' : 'text-red-500 hover:bg-white' }}">
        Brands
      </a>
    </nav>

    <div class="p-4 border-t border-red-700 mt-auto">
      @auth
      <div class="text-sm text-red-500">Signed in as</div>
      <div class="font-medium text-white">{{ auth()->user()->name }}</div>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="mt-3 w-full text-left px-2 py-1 bg-red-500 text-white rounded hover:bg-red-800">
          Logout
        </button>
      </form>
      @endauth
    </div>
  </aside>

  {{-- Main content --}}
  <main class="flex-1 p-6">
    @yield('content')
  </main>

  {{-- lightweight global scripts --}}
  @stack('scripts')
</body>
</html>
