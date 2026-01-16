@extends('layouts.app')

@section('title', 'แบบสอบถามออนไลน์')

@section('content')
<div class="min-h-screen pt-24 pb-12 bg-slate-50 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('survey.search') }}"
                class="group flex items-center gap-2 text-slate-500 hover:text-indigo-900 transition-colors decoration-0">
                <div class="p-2 rounded-full bg-white border border-slate-200 group-hover:border-indigo-200 shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </div>
                <span class="font-medium text-sm">กลับ</span>
            </a>
            <div class="text-right">
                <h1 class="text-lg md:text-xl font-bold text-indigo-900">แบบสอบถามออนไลน์</h1>
                <p class="text-xs text-slate-500">ประจำปี พ.ศ. 2569</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 p-4 mb-6 flex items-center justify-between relative overflow-visible">
            <div class="flex items-center gap-3 w-full">

                @php
                $allowedRoles = [
                App\Enums\UserRole::INTERVIEWER->value,
                App\Enums\UserRole::SUPERVISOR->value,
                App\Enums\UserRole::SUBJECT->value,
                ];
                $showDetails = auth()->check() && in_array(auth()->user()->role->value, $allowedRoles);
                @endphp

                @if($showDetails)
                {{-- แสดงรายละเอียด ID สำหรับเจ้าหน้าที่ --}}
                <div class="w-full space-y-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-sm font-bold text-slate-500">สถานประกอบการณ์ :</span>
                        <span class="text-lg font-mono font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-lg border border-indigo-100 tracking-wider">
                            {{ $control->ID }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2 items-end">
                        @foreach([
                        ['label'=>'REG', 'name'=>'reg', 'width'=>'w-10', 'value'=>$control->REG, 'max'=>1, 'readonly'=>true],
                        ['label'=>'CWT', 'name'=>'cwt', 'width'=>'w-14', 'value'=>$control->CWT, 'max'=>2, 'readonly'=>true],
                        ['label'=>'AMP', 'name'=>'amp', 'width'=>'w-14', 'value'=>$control->AMP, 'max'=>2],
                        ['label'=>'TAM', 'name'=>'tam', 'width'=>'w-14', 'value'=>$control->TAM, 'max'=>2],
                        ['label'=>'MUN', 'name'=>'mun', 'width'=>'w-10', 'value'=>$control->MUN, 'max'=>1],
                        ['label'=>'EA', 'name'=>'ea', 'width'=>'w-20', 'value'=>$control->EA, 'max'=>4],
                        ['label'=>'VIL', 'name'=>'vil', 'width'=>'w-14', 'value'=>$control->VIL, 'max'=>2],
                        ['label'=>'TSIC_R', 'name'=>'tsic_r', 'width'=>'w-24', 'value'=>($control->TSIC_R ?? $control->TSIC_CODE), 'max'=>5],
                        ['label'=>'TSIC_L', 'name'=>'tsic_l', 'width'=>'w-24', 'value'=>$control->TSIC_L ?? '', 'max'=>5],
                        ['label'=>'SIZE_R', 'name'=>'size_r', 'width'=>'w-14', 'value'=>($control->SIZE_R ?? $control->SIZE12), 'max'=>2],
                        ['label'=>'SIZE_L', 'name'=>'size_l', 'width'=>'w-14', 'value'=>$control->SIZE_L ?? '', 'max'=>2],
                        ['label'=>'NO', 'name'=>'no', 'width'=>'w-24', 'value'=>$control->NO, 'max'=>5],
                        ['label'=>'YR', 'name'=>'yr', 'width'=>'w-14', 'value'=>$control->YR, 'max'=>2],
                        ['label'=>'ENU', 'name'=>'enu', 'width'=>'w-14', 'value'=>$control->ENU, 'max'=>2],
                        ] as $field)
                        <div class="flex flex-col items-center">
                            <label class="text-[10px] text-indigo-900 font-bold mb-1">{{ $field['label'] }}</label>
                            <input type="text"
                                name="{{ $field['name'] }}"
                                form="surveyPart0Form"
                                value="{{ $field['value'] }}"
                                maxlength="{{ $field['max'] }}"
                                @if(isset($field['readonly']) && $field['readonly']) readonly @endif
                                class="{{ $field['width'] }} h-10 border text-center font-mono font-bold rounded-none focus:outline-none transition-all
                                        {{ isset($field['readonly']) && $field['readonly'] 
                                            ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-default'
                                            : 'bg-white text-indigo-900 border-indigo-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 shadow-sm'
                                        }}"
                                autocomplete="off">
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                {{-- แสดงแบบย่อสำหรับบุคคลทั่วไป --}}
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm font-bold text-slate-500">สถานประกอบการณ์ :</span>
                    <span class="text-lg font-mono font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-lg border border-indigo-100 tracking-wider">
                        {{ $control->ID }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        <form id="surveyPart0Form" class="space-y-6" action="{{ route('survey.storePart0') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $control->ID }}">

            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
                <div class="bg-indigo-50/50 p-4 border-b border-indigo-100 flex items-center gap-2">
                    <h3 class="text-lg font-bold text-slate-800">ข้อมูลสถานประกอบการ</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="space-y-1.5">
                        <x-input-box
                            name="est_name"
                            label="ชื่อสถานประกอบการ"
                            value="{{ $control->EST_NAME }}"
                            placeholder="ระบุชื่อบริษัท/ห้างหุ้นส่วน/ร้านค้า"
                            class="text-left text-sm tracking-normal font-semibold"
                            @input="inputVal = $event.target.value" />
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-slate-700 border-b border-slate-100 pb-2 mb-2">สถานที่ตั้ง</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                            $inputs = [
                            ['name'=>'add_no', 'label'=>'เลขที่', 'val'=>$control->ADD_NO, 'ph'=>''],
                            ['name'=>'street', 'label'=>'ถนน', 'val'=>$control->STREET, 'ph'=>''],
                            ['name'=>'soi', 'label'=>'ตรอก/ซอย', 'val'=>$control->SOI, 'ph'=>''],
                            ['name'=>'sub_dist', 'label'=>'ตำบล/แขวง', 'val'=>$control->SUB_DIST, 'ph'=>''],
                            ['name'=>'district', 'label'=>'อำเภอ/เขต', 'val'=>$control->DISTRICT, 'ph'=>''],
                            ['name'=>'province', 'label'=>'จังหวัด', 'val'=>$control->PROVINCE, 'ph'=>''],
                            ['name'=>'post_code', 'label'=>'รหัสไปรษณีย์', 'val'=>'', 'ph'=>''],
                            ['name'=>'tel_no', 'label'=>'โทรศัพท์', 'val'=>$control->TEL_NO, 'ph'=>''],
                            ['name'=>'fax', 'label'=>'โทรสาร', 'val'=>$control->FAX_NO, 'ph'=>''],
                            ['name'=>'e_mail', 'label'=>'E-mail', 'val'=>$control->E_MAIL, 'ph'=>''],
                            ['name'=>'web_site', 'label'=>'Website', 'val'=>$control->WEB_SITE, 'ph'=>'', 'full'=>true],
                            ['name'=>'social', 'label'=>'Social Network', 'val'=>'', 'ph'=>'', 'full'=>true],
                            ];
                            @endphp

                            @foreach($inputs as $inp)
                            <div class="{{ isset($inp['full']) ? 'md:col-span-2' : '' }}">
                                <x-input-box
                                    name="{{ $inp['name'] }}"
                                    label="{{ $inp['label'] }}"
                                    value="{{ $inp['val'] }}"
                                    placeholder="{{ $inp['ph'] }}"
                                    class="text-left text-sm tracking-normal"
                                    @input="inputVal = $event.target.value" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <label class="text-sm font-bold text-slate-700 block mb-3">เขตการปกครอง</label>
                        <div class="flex flex-col sm:flex-row gap-4" x-data="{ area: '{{ $control->MUN == '1' ? 'in' : 'out' }}' }">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="est_area" value="in" x-model="area" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-700">ในเขตเทศบาล</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="est_area" value="out" x-model="area" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-700">นอกเขตเทศบาล</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden" x-data="{ sameAddress: false }">
                <div class="bg-emerald-50/50 p-4 border-b border-emerald-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">สถานที่ติดต่อ</h3>
                    <label class="flex items-center gap-2 cursor-pointer bg-white px-3 py-1.5 rounded-lg border border-emerald-200 shadow-sm hover:bg-emerald-50 transition-all">
                        <input type="checkbox" x-model="sameAddress" class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                        <span class="text-xs font-bold text-emerald-700">สถานที่เดียวกัน</span>
                    </label>
                </div>
                <div class="p-6 space-y-6 transition-all" :class="sameAddress ? 'opacity-50 pointer-events-none' : ''">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full md:col-span-2" x-show="!sameAddress">
                            <x-input-box name="add_no_1" label="เลขที่" class="text-left text-sm tracking-normal" @input="inputVal = $event.target.value" />
                            <x-input-box name="street_1" label="ถนน" class="text-left text-sm tracking-normal" @input="inputVal = $event.target.value" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
                <div class="bg-amber-50/50 p-4 border-b border-amber-100 flex items-center gap-2">
                    <h3 class="text-lg font-bold text-slate-800">ชนิดของสินค้าและ/หรือบริการ</h3>
                </div>
                <div class="p-6 space-y-4">
                    <label class="text-sm font-bold text-slate-700 block leading-relaxed">
                        โปรดระบุชนิดของสินค้า และ/หรือ บริการ
                        <span class="font-normal text-slate-500">(เรียงลำดับจากรายรับมากไปน้อย)</span>
                    </label>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs text-slate-500 leading-relaxed mb-2">
                        (บันทึกชนิดของสินค้า... เช่น ขายรถยนต์...)
                        <span class="text-amber-600 font-medium block mt-1">ถ้าประกอบธุรกิจมากกว่า 1 ประเภท โปรดระบุประเภทที่มีรายรับสูงสุด</span>
                    </div>
                    <textarea name="business_desc" rows="5" class="w-full p-4 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm leading-relaxed" placeholder="ระบุรายละเอียดที่นี่..."></textarea>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4 pb-12">
                <x-button type="submit" class="w-full justify-center py-4 text-lg">
                    หน้าถัดไป
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </x-button>
            </div>

        </form>
    </div>
</div>
@endsection