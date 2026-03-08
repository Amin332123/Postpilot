<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-gradient-to-r from-violet-600 to-pink-500 text-white font-bold py-3 px-4 rounded-2xl hover:opacity-90 hover:shadow-lg hover:shadow-violet-500/50 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:ring-offset-2 focus:ring-offset-black']) }}>
    {{ $slot }}
</button>
