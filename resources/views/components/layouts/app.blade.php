<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Vehicle System')</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex">

  {{-- MOBILE TOP BAR --}}
  <div class="md:hidden fixed top-0 left-0 right-0 flex items-center justify-between p-4 border-b border-red-700 bg-black z-50">
      <div class="flex items-center gap-3">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaMUOE9t4Zm2TR-zwNE23OFaLhyt1Dm4zk-A&s" class="h-8 w-8">
          <span class="text-red-500 font-bold text-lg">AUTONOVA</span>
      </div>

      <button id="mobile-menu-btn" class="text-red-500 text-3xl">☰</button>
  </div>

  {{-- MOBILE MENU --}}
  <div id="mobile-menu"
       class="md:hidden hidden bg-black border-b border-red-700 px-4 pb-4 pt-20 fixed top-0 left-0 right-0 z-40">

      <a href="{{ route('dashboard') }}" class="block text-red-500 border border-red-500 p-2 rounded mt-3">Dashboard</a>

      <a href="{{ route('brands.index') }}" class="block text-red-500 border border-red-500 p-2 rounded mt-3">Brands</a>

      @auth
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="w-full text-left bg-red-500 text-white px-2 py-2 rounded mt-4">Logout</button>
      </form>
      @endauth
  </div>

  {{-- DESKTOP SIDEBAR --}}
  <aside class="hidden md:flex flex-col w-64 bg-black border-r border-red-700 fixed top-0 bottom-0">

      <div class="p-4 flex items-center gap-3 border-b border-red-700">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaMUOE9t4Zm2TR-zwNE23OFaLhyt1Dm4zk-A&s"
               class="h-10 w-10">
          <div class="font-bold text-red-500 text-lg">AUTONOVA</div>
      </div>

      <nav class="p-4 flex-1">
          <a href="{{ route('dashboard') }}"
             class="border border-red-500 block p-2 rounded mb-2 {{ request()->routeIs('dashboard') ? 'bg-red-500 text-white' : 'text-red-500 hover:bg-white' }}">
             Dashboard
          </a>

          <a href="{{ route('brands.index') }}"
             class="border border-red-500 block p-2 rounded mb-2 {{ request()->routeIs('brands.index') ? 'bg-red-500 text-white' : 'text-red-500 hover:bg-white' }}">
             Brands
          </a>
      </nav>

      <div class="p-4 border-t border-red-700">
          @auth
          <div class="text-sm text-red-500">Signed in as</div>
          <div class="font-medium text-white">{{ auth()->user()->name }}</div>

          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="mt-3 w-full px-2 py-1 bg-red-500 text-white rounded hover:bg-red-800">Logout</button>
          </form>
          @endauth
      </div>
  </aside>

  {{-- MAIN CONTENT --}}
  <main class="flex-1 md:ml-64 p-4 md:p-6 mt-16 md:mt-0 w-full overflow-x-auto">
      @if(session('success'))
          <div id="alert-msg"
               class="mb-4 bg-red-600 text-white p-3 rounded transition-opacity duration-700">
              {{ session('success') }}
          </div>

          <script>
              setTimeout(() => {
                  let a = document.getElementById("alert-msg");
                  if (a) a.style.opacity = "0";
              }, 2000);
          </script>
      @endif

      @yield('content')
  </main>

  {{-- MOBILE MENU SCRIPT --}}
  <script>
      document.getElementById("mobile-menu-btn").onclick = () => {
          document.getElementById("mobile-menu").classList.toggle("hidden");
      };
  </script>

  {{-- STACKED SCRIPTS --}}
  @stack('scripts')

</body>
</html>
