@props(['id', 'name', 'label', 'options', 'placeholder' => 'เลือกข้อมูล', 'required' => false])

@php
    // สร้าง Unique ID เพื่อไม่ให้ตีกันถ้าใช้หลายตัวในหน้าเดียว
    $componentId = $id ?? 'select-' . uniqid();
    $error = $errors->first($name);
@endphp

<div class="space-y-2 relative" id="{{ $componentId }}-container">
    <label class="text-sm font-bold text-slate-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>

    <input type="hidden" name="{{ $name }}" id="{{ $componentId }}-hidden" value="{{ old($name) }}">

    <div class="relative">
        <input type="text" id="{{ $componentId }}-search"
            class="w-full px-4 py-2.5 rounded-xl border {{ $error ? 'border-red-500' : 'border-slate-200' }} focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            {{-- ดึงชื่อมาแสดงถ้ามีค่าเก่า --}}
            value="{{ old($name) && isset($options[old($name)]) ? $options[old($name)] : '' }}">

        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
        </div>
    </div>

    <div id="{{ $componentId }}-dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
        @foreach($options as $key => $value)
            <div class="{{ $componentId }}-option px-4 py-2.5 text-sm hover:bg-indigo-50 cursor-pointer text-slate-700 transition-colors"
                data-code="{{ $key }}"
                data-name="{{ $value }}">
                {{ $value }}
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
            
            if(hasResult) noResult.classList.add('hidden');
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
                if (hiddenInput.value === '') searchInput.value = '';
            }
        });
    });
</script>