<x-app-layout>
    <main class="p-6 max-w-6xl mx-auto space-y-6">

        <div class="card p-8 flex flex-col sm:flex-row items-center sm:items-end gap-6">
            <div
                class="w-24 h-24 rounded-full bg-gradient-to-br from-violet-600 to-pink-500 flex items-center justify-center text-4xl font-black border-4 border-[#0f0d1e]">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h2 class="text-2xl font-extrabold">{{ auth()->user()->name }}</h2>
                <p class="text-white/50 text-sm">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="card p-6 md:p-8 space-y-6">
            <h3 class="font-bold text-lg">Account Information</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-white/50 uppercase">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="field @error('name') border-red-500 @enderror" required />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-white/50 uppercase">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="field @error('email') border-red-500 @enderror" required/>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="grad-btn mt-6 px-8 py-3 rounded-2xl text-white font-bold text-sm">💾 Save
                    Changes</button>
            </form>
        </div>

        <div class="card p-6 md:p-8 space-y-6">
            <h3 class="font-bold text-lg">🔑 Change Password</h3>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-2 sm:col-span-2">
                        <label class="block text-xs font-semibold text-white/50 uppercase">Current Password</label>
                        <input type="password" name="current_password"
                            class="field @error('current_password', 'updatePassword') border-red-500 @enderror" />
                        @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}
                        </p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-white/50 uppercase">New Password</label>
                        <input type="password" name="password"
                            class="field @error('password', 'updatePassword') border-red-500 @enderror" />
                        @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-white/50 uppercase">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="field @error('password_confirmation', 'updatePassword') border-red-500 @enderror" />
                    </div>
                </div>

                <button type="submit" class="grad-btn mt-6 px-8 py-3 rounded-2xl text-white font-bold text-sm">Update
                    Password</button>
            </form>
        </div>

    </main>@if (session('status'))
        <div id="status-toast"
            class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl text-sm font-bold text-white grad-btn shadow-lg animate-bounce-in">
            <span>✅</span>
            <span>{{ 
                session('status') === 'profile-updated' ? 'Profile updated!' :
            (session('status') === 'password-updated' ? 'Password changed!' : session('status')) 
            }}</span>
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('status-toast');
                if (toast) {
                    toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(20px)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    @endif
</x-app-layout>