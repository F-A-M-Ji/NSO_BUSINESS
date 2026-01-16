@props([
'name',
'label',
'options',
'placeholder' => '',
'placeholderValue' => '',
'required' => false,
'value' => null,
])

@php
$componentId = 'select-' . uniqid();
$error = $errors->first($name);

$selectedValue = old($name, $value ?? request()->query($name, $placeholderValue));

$selectedLabel = $placeholder;

if ($selectedValue !== null && $selectedValue !== '') {
foreach ($options as $key => $option) {

// รองรับทั้ง Enum/Object และ Array ปกติ
if (is_object($option)) {
$val = $option->value ?? $key;
$text = isset($option->name, $option->value)
? ($option->name . " ({$option->value})")
: ($option->name ?? (string)$val);
} else {
// กรณี associative array: key => label
$val = is_array($options) && !is_numeric(array_key_first($options)) ? $key : $option;
$text = is_array($options) && !is_numeric(array_key_first($options)) ? $option : $option;
}

if ((string)$val === (string)$selectedValue) {
$selectedLabel = $text;
break;
}
}
}
@endphp

<div class="space-y-2 relative" id="{{ $componentId }}-container">
    <label class="text-sm font-bold text-slate-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>

    <input type="hidden" name="{{ $name }}" id="{{ $componentId }}-hidden" value="{{ $selectedValue }}">

    <div id="{{ $componentId }}-trigger"
        class="w-full px-4 py-2.5 rounded-xl border {{ $error ? 'border-red-500' : 'border-slate-200' }} bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm cursor-pointer flex items-center justify-between group select-none"
        tabindex="0">

        <span id="{{ $componentId }}-text" class="{{ ($selectedValue !== null && $selectedValue !== '') ? 'text-slate-800' : 'text-slate-400' }}">
            {{ $selectedLabel }}
        </span>

        <div class="text-slate-400 group-hover:text-indigo-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6" />
            </svg>
        </div>
    </div>

    <div id="{{ $componentId }}-dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto animate-fade-in">

        <div class="{{ $componentId }}-option px-4 py-2.5 text-sm text-slate-400 hover:bg-slate-50 cursor-pointer transition-colors"
            data-value="{{ $placeholderValue }}"
            data-label="{{ $placeholder }}">
            {{ $placeholder }}
        </div>

        @foreach($options as $option)
        @php
        // รองรับทั้ง Enum Object และ Array ธรรมดา
        $val = is_object($option) ? $option->value : $option;
        $text = is_object($option) ? ($option->name . " ($option->value)") : $option;

        if(is_array($options) && !is_numeric(array_key_first($options))) {
        $val = array_search($option, $options);
        $text = $option;
        }
        @endphp

        <div class="{{ $componentId }}-option px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 cursor-pointer transition-colors flex justify-between items-center"
            data-value="{{ $val }}"
            data-label="{{ $text }}">
            <span>{{ $text }}</span>

            @if((string)$selectedValue === (string)$val)

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12" />
            </svg>
            @endif
        </div>
        @endforeach
    </div>

    @if($error) <p class="text-xs text-red-500 mt-1">{{ $error }}</p> @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('{{ $componentId }}-container');
        const trigger = document.getElementById('{{ $componentId }}-trigger');
        const dropdown = document.getElementById('{{ $componentId }}-dropdown');
        const hiddenInput = document.getElementById('{{ $componentId }}-hidden');
        const displayText = document.getElementById('{{ $componentId }}-text');
        const options = document.querySelectorAll('.{{ $componentId }}-option');

        // ฟังก์ชันเปิด/ปิด Dropdown
        function toggleDropdown() {
            dropdown.classList.toggle('hidden');
            // เพิ่ม Effect Focus ให้ Trigger เหมือน Input
            if (!dropdown.classList.contains('hidden')) {
                trigger.classList.add('ring-4', 'ring-indigo-500/10', 'border-indigo-500');
            } else {
                trigger.classList.remove('ring-4', 'ring-indigo-500/10', 'border-indigo-500');
            }
        }

        // คลิกที่กล่อง -> เปิด/ปิด
        trigger.addEventListener('click', toggleDropdown);

        // คลิกที่รายการ -> เลือก
        options.forEach(option => {
            option.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const label = this.getAttribute('data-label');

                // อัปเดตค่า
                hiddenInput.value = value;
                displayText.innerText = label;

                // เปลี่ยนสี Text
                if (value) {
                    displayText.classList.remove('text-slate-400');
                    displayText.classList.add('text-slate-800');
                } else {
                    displayText.classList.add('text-slate-400');
                    displayText.classList.remove('text-slate-800');
                }

                // ปิด Dropdown
                dropdown.classList.add('hidden');
                trigger.classList.remove('ring-4', 'ring-indigo-500/10', 'border-indigo-500');
            });
        });

        // คลิกข้างนอก -> ปิด
        document.addEventListener('click', function(e) {
            if (!container.contains(e.target)) {
                dropdown.classList.add('hidden');
                trigger.classList.remove('ring-4', 'ring-indigo-500/10', 'border-indigo-500');
            }
        });
    });
</script>