{{-- ✅ 1. เพิ่ม 'value' => null ใน props --}}
@props(['id', 'name', 'label', 'options', 'placeholder' => 'เลือกข้อมูล', 'required' => false, 'value' => null])

@php
$componentId = $id ?? 'select-' . uniqid();
$error = $errors->first($name);

// ✅ 2. ปรับปรุง Logic การหาค่าเริ่มต้น:
// ให้เช็ค old() ก่อน -> ถ้าไม่มีให้ใช้ value ที่ส่งมา (request('cwt'))
$currentValue = old($name, $value);

// ✅ 3. หาชื่อที่จะแสดงในช่อง Input (เช่น 'อ่างทอง') จากค่ารหัส (เช่น '15')
$displayValue = '';
if ($currentValue && isset($options[$currentValue])) {
$displayValue = $options[$currentValue];
}
@endphp

<div class="space-y-2 relative" id="{{ $componentId }}-container">
    <label class="text-sm font-bold text-slate-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>

    {{-- ✅ 4. ใส่ value ลงใน hidden input --}}
    <input type="hidden" name="{{ $name }}" id="{{ $componentId }}-hidden" value="{{ $currentValue }}">

    <div class="relative">
        <input type="text" id="{{ $componentId }}-search"
            class="w-full px-4 py-2.5 rounded-xl border {{ $error ? 'border-red-500' : 'border-slate-200' }} focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            value="{{ $displayValue }}"> {{-- ✅ 5. แสดงชื่อจังหวัดที่หาได้ --}}

        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6" />
            </svg>
        </div>
    </div>

    <div id="{{ $componentId }}-dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
        @foreach($options as $key => $val)
        <div class="{{ $componentId }}-option px-4 py-2.5 text-sm hover:bg-indigo-50 cursor-pointer text-slate-700 transition-colors"
            data-code="{{ $key }}"
            data-name="{{ $val }}">
            {{ $val }}
        </div>
        @endforeach
        <div id="{{ $componentId }}-no-result" class="hidden px-4 py-2.5 text-sm text-slate-400 text-center">
            ไม่พบข้อมูล
        </div>
    </div>

    @if($error) <p class="text-xs text-red-500 mt-1">{{ $error }}</p> @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('{{ $componentId }}-container');
        const searchInput = document.getElementById('{{ $componentId }}-search');
        const hiddenInput = document.getElementById('{{ $componentId }}-hidden');
        const dropdown = document.getElementById('{{ $componentId }}-dropdown');
        const options = document.querySelectorAll('.{{ $componentId }}-option');
        const noResult = document.getElementById('{{ $componentId }}-no-result');

        // เปิด Dropdown
        searchInput.addEventListener('focus', () => dropdown.classList.remove('hidden'));

        // พิมพ์ค้นหา
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            let hasResult = false;
            dropdown.classList.remove('hidden');
            hiddenInput.value = ''; // ล้างค่า

            options.forEach(option => {
                const text = option.getAttribute('data-name').toLowerCase();
                if (text.includes(filter)) {
                    option.classList.remove('hidden');
                    hasResult = true;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (hasResult) noResult.classList.add('hidden');
            else noResult.classList.remove('hidden');
        });

        // เลือกรายการ
        options.forEach(option => {
            option.addEventListener('click', function() {
                hiddenInput.value = this.getAttribute('data-code');
                searchInput.value = this.getAttribute('data-name');
                dropdown.classList.add('hidden');
            });
        });

        // คลิกข้างนอกปิด
        document.addEventListener('click', function(e) {
            if (!container.contains(e.target)) {
                dropdown.classList.add('hidden');
                // แก้ไข Logic: ถ้าค่าว่าง ให้ล้าง text ออกด้วย
                if (hiddenInput.value === '') searchInput.value = '';
                // เพิ่ม: ถ้ามีค่าอยู่แล้ว แต่พิมพ์เล่นแล้วกดออก ให้คืนค่าเดิมกลับมา (User Experience ที่ดีขึ้น)
                // (Optional: แต่แบบปัจจุบันก็ใช้ได้ครับ คือถ้าพิมพ์ไม่ตรงแล้วกดออก ค่าจะหายไป บังคับเลือกใหม่)
            }
        });
    });
</script>