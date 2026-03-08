@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-green-500/20 border border-green-500/40 text-green-200 px-4 py-3 rounded-lg text-sm mb-4']) }}>
        {{ $status }}
    </div>
@endif
