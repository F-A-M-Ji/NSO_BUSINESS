@props([
    'color' => 'indigo', 
    'type' => 'submit'
])

@php
    // map สีปุ่ม
    $colors = [
        'indigo' => 'from-indigo-900 to-indigo-800 hover:from-indigo-800 hover:to-indigo-700 shadow-indigo-200',
        'emerald' => 'from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 shadow-emerald-200',
        'rose' => 'from-rose-600 to-rose-500 hover:from-rose-500 hover:to-rose-400 shadow-rose-200',
        'slate' => 'from-slate-600 to-slate-500 hover:from-slate-500 hover:to-slate-400 shadow-slate-200', // ปุ่มยกเลิก
    ];
    
    $theme = $colors[$color] ?? $colors['indigo'];
@endphp

<button type="{{ $type }}" 
    {{ $attributes->merge(['class' => "px-6 py-2.5 rounded-xl bg-gradient-to-r $theme text-white font-bold shadow-lg hover:-translate-y-0.5 transition-all text-sm flex items-center justify-center gap-2"]) }}>
    {{ $slot }}
</button>