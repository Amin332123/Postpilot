<x-app-layout>
    <style>
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 260px;
            background: rgba(13, 11, 26, 0.98); border-right: 1px solid rgba(255, 255, 255, .07);
            backdrop-filter: blur(15px); z-index: 50; display: flex; flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px; padding: 12px 20px; border-radius: 12px;
            margin: 2px 12px; font-size: .9rem; color: rgba(255, 255, 255, .5); text-decoration: none;
        }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(125, 95, 255, .15); color: #fff; }
        
        #sidebarOverlay { 
            position: fixed; inset: 0; background: rgba(0,0,0,0.7); 
            backdrop-filter: blur(4px); display: none; z-index: 40; 
        }
        #sidebarOverlay.active { display: block; }
        
        @media (min-width: 1025px) { .main-wrap { margin-left: 260px; } }
    </style>

    <div class="lg:hidden flex items-center justify-between p-4 border-b border-white/10 sticky top-0 bg-[#0f0d1e] z-40">
        <a href="/" class="text-xl font-bold grad-text">PostPilot ✈️</a>
        <button id="openMobileMenu" class="p-2 bg-white/5 rounded-lg border border-white/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <div id="sidebarOverlay"></div>

    <aside id="sidebar" class="sidebar">
        <div class="p-6 border-b border-white/10 flex justify-between items-center">
            <div>
                <a href="/" class="text-xl font-bold grad-text">PostPilot ✈️</a>
                <p class="text-xs text-white/30 mt-1">AI Caption Generator</p>
            </div>
            <button id="closeMobileMenu" class="lg:hidden p-2 text-white/40 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="flex-1 py-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="sidebar-link">🏠 Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link active">👤 Profile</a>
            <a href="{{ route('history.show') }}" class="sidebar-link"><span>📋</span> History</a>
        </nav>
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link text-red-400 w-full justify-start">🚪 Log Out</button>
            </form>
        </div>
    </aside>

    <div class="main-wrap">
        <main class="p-4 md:p-8 max-w-4xl mx-auto space-y-6">
            <div class="card p-6 md:p-8 flex flex-col sm:flex-row items-center gap-6 bg-gradient-to-br from-white/[0.06] to-transparent">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-gradient-to-br from-violet-600 to-pink-500 flex items-center justify-center text-3xl md:text-4xl font-black border-4 border-[#0f0d1e] shadow-2xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-2xl md:text-3xl font-extrabold">{{ auth()->user()->name }}</h2>
                    <p class="text-white/50 text-sm">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="card p-6 md:p-8 space-y-6">
                <h3 class="font-bold text-lg">Account Information</h3>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-white/40 uppercase mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="field w-full" required />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-white/40 uppercase mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="field w-full" required/>
                        </div>
                    </div>
                    <button type="submit" class="grad-btn px-8 py-3 rounded-2xl text-white font-bold text-sm">Save Changes</button>
                </form>
            </div>

            <div class="card p-6 md:p-8 space-y-6">
                <h3 class="font-bold text-lg">🔑 Change Password</h3>
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <input type="password" name="current_password" placeholder="Current Password" class="field w-full" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="password" name="password" placeholder="New Password" class="field w-full" />
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="field w-full" />
                        </div>
                    </div>
                    <button type="submit" class="grad-btn px-8 py-3 rounded-2xl text-white font-bold text-sm">Update Password</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openMobileMenu');
        const closeBtn = document.getElementById('closeMobileMenu');

        function toggle() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        openBtn.onclick = toggle;
        closeBtn.onclick = toggle;
        overlay.onclick = toggle;
    </script>

    @if (session('status'))
        @endif
</x-app-layout>