@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 px-4 py-3 w-full focus:border-violet-500 focus:outline-none focus:ring-0 focus:bg-white/10 transition-all']) }}>
