@props([
    'name', 
    'label' => null, 
    'value' => '',
    'type' => 'text', // เพิ่ม type เพื่อให้รองรับ password, email ได้ด้วย
])

<div x-data="{ inputVal: '{{ old($name, $value) }}' }" class="w-full">
    
    @if($label)
        <label class="block text-sm font-bold text-slate-700 mb-1.5">
            {{ $label }}
            {{-- เช็คว่า input นี้ required หรือไม่ เพื่อใส่ดอกจันสีแดง (Optional) --}}
            @if($attributes->has('required')) 
                <span class="text-red-500">*</span> 
            @endif
        </label>
    @endif

    <div class="relative">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}"
            x-model="inputVal"
            {{-- ลบ @input ที่บังคับตัวเลขออกแล้ว --}}
            {{ $attributes->merge([
                'class' => 'w-full p-3 rounded-xl border border-slate-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm text-slate-900 placeholder:text-slate-400'
            ]) }}
        >
        
        {{-- ถ้ามีการกำหนด maxlength ให้แสดงตัวนับจำนวน (Optional) --}}
        @if($attributes->has('maxlength'))
            <div class="absolute bottom-3 right-3 text-xs text-slate-400 pointer-events-none">
                <span x-text="inputVal.length"></span>/{{ $attributes->get('maxlength') }}
            </div>
        @endif
    </div>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>