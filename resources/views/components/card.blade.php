@props([
    'title', 
    'icon' => null, 
    'color' => 'indigo' // ค่าสีเริ่มต้นคือสีม่วงคราม
])

@php
    // map สี เพื่อให้เปลี่ยน Theme ได้ง่ายๆ (พื้นหลังหัวการ์ด / สีไอคอน / เส้นขอบ)
    $themes = [
        'indigo' => [
            'header_bg' => 'bg-indigo-50/50',
            'header_border' => 'border-indigo-100',
            'icon_bg' => 'bg-indigo-100',
            'icon_text' => 'text-indigo-700',
        ],
        'emerald' => [ // สีเขียว (สำหรับ Success)
            'header_bg' => 'bg-emerald-50/50',
            'header_border' => 'border-emerald-100',
            'icon_bg' => 'bg-emerald-100',
            'icon_text' => 'text-emerald-700',
        ],
        'rose' => [ // สีแดง (สำหรับ Danger / Error)
            'header_bg' => 'bg-rose-50/50',
            'header_border' => 'border-rose-100',
            'icon_bg' => 'bg-rose-100',
            'icon_text' => 'text-rose-700',
        ],
        'amber' => [ // สีส้ม (สำหรับ Warning)
            'header_bg' => 'bg-amber-50/50',
            'header_border' => 'border-amber-100',
            'icon_bg' => 'bg-amber-100',
            'icon_text' => 'text-amber-700',
        ],
    ];

    $theme = $themes[$color] ?? $themes['indigo'];
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 relative h-full">
    
    <div class="{{ $theme['header_bg'] }} p-4 border-b {{ $theme['header_border'] }} flex items-center gap-2 rounded-t-2xl">
        
        @if($icon)
            <div class="p-2 {{ $theme['icon_bg'] }} rounded-lg {{ $theme['icon_text'] }}">
                {!! $icon !!}
            </div>
        @endif

        <h3 class="font-bold text-slate-800">{{ $title }}</h3>
    </div>

    <div class="p-8">
        {{ $slot }}
    </div>
</div>