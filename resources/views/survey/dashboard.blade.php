@extends('layouts.app')

@section('title', 'การติดตามงาน')

@section('content')
@php
use App\Enums\UserRole;
@endphp

<div class="min-h-screen pt-24 pb-12 bg-slate-50 font-sans" x-data>

    {{-- Toast Notification --}}
    <div x-data="{ show: false, message: '' }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        @notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        class="fixed bottom-6 right-6 z-50"
        style="display:none;" x-cloak>

        <div class="flex items-center gap-3 rounded-2xl px-4 py-3 shadow-lg border border-slate-200 bg-white/90 backdrop-blur">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 border border-emerald-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-slate-800 leading-tight">สำเร็จ</p>
                <p x-text="message" class="text-xs text-slate-600 font-medium break-words"></p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header / Hero --}}
        <div class="mb-8 rounded-3xl overflow-hidden border border-indigo-100 shadow-sm bg-gradient-to-br from-indigo-50 via-white to-slate-50">
            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="min-w-0">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3v18h18" />
                                <path d="M7 14l3-3 4 4 6-6" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900">การติดตามงาน</h1>
                            <p class="text-sm text-slate-600 font-medium">
                                ภาพรวมการดำเนินงานของจังหวัด
                                <span class="font-extrabold text-indigo-700">
                                    {{ $provinces[auth()->user()->province_code] ?? 'ไม่ระบุจังหวัด' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('survey.search') }}"
                        class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl font-extrabold shadow-md shadow-indigo-200 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        ค้นหาแบบสอบถาม
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 px-5 py-3 rounded-2xl font-extrabold border border-slate-200 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-3-6.7" />
                            <path d="M21 3v6h-6" />
                        </svg>
                        รีเฟรช
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-indigo-100 hover:shadow-md transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-extrabold text-indigo-700 tracking-wider uppercase">ทั้งหมด</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($total) }}</div>
                        <div class="text-xs font-bold text-indigo-600 mt-2">แบบสอบถามทั้งหมด</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1-2-2h11" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-md transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-extrabold text-slate-700 tracking-wider uppercase">ยังไม่ได้บันทึก</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($notSaved) }}</div>
                        <div class="text-xs font-bold text-slate-500 mt-2">รอการดำเนินการ</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8v4l3 3" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-200 hover:shadow-md transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-extrabold text-amber-700 tracking-wider uppercase">บันทึกแล้ว</div>
                        <div id="stat-saved" class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($saved) }}</div>
                        <div class="text-xs font-bold text-amber-700 mt-2">รอการตรวจสอบ</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M16 13H8" />
                            <path d="M16 17H8" />
                            <path d="M10 9H8" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-200 hover:shadow-md transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-extrabold text-emerald-700 tracking-wider uppercase">อนุมัติแล้ว</div>
                        <div id="stat-approved" class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($approved) }}</div>
                        <div class="text-xs font-bold text-emerald-700 mt-2">ตรวจสอบเสร็จสิ้น</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <path d="M22 4 12 14l-3-3" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- Filters --}}
        <div class="bg-white/90 backdrop-blur p-5 rounded-3xl shadow-sm border border-slate-200 mb-6 relative z-20 overflow-visible">

            <form action="{{ route('dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <x-input-box
                        name="search"
                        label="ค้นหาสถานประกอบการณ์"
                        :value="request()->query('search')"
                        placeholder="พิมพ์รหัสสถานประกอบการ..."
                        class="text-left text-sm font-medium text-slate-700"
                        @input="inputVal = $event.target.value" />
                </div>

                <div class="md:col-span-4 relative z-20">
                    <x-select
                        name="filter_status"
                        label="สถานะการดำเนินงาน"
                        :options="$filterOptions"
                        :value="request()->query('filter_status', 'all')"
                        placeholder-value="all" />
                </div>

                <div class="md:col-span-3 flex gap-2">
                    <x-button type="submit" class="flex-1 justify-center py-3 font-extrabold rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        ค้นหา
                    </x-button>

                    @if(request()->has('search') || (request()->has('filter_status') && request('filter_status') !== 'all'))
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-extrabold transition-colors flex items-center justify-center">
                        ล้าง
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden relative isolate z-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs text-slate-600 uppercase bg-slate-50 border-b border-slate-200 font-extrabold tracking-wider sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4">ลำดับ</th>
                            <th class="px-6 py-4">สถานประกอบการณ์</th>
                            <th class="px-6 py-4">เจ้าหน้าที่บันทึกข้อมูล</th>
                            <th class="px-6 py-4">ผู้ตรวจ</th>
                            <th class="px-6 py-4 text-center">สถานะ</th>
                            <th class="px-6 py-4 text-center">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-sm font-semibold">
                        @forelse($items as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            id="row-{{ $item->ID }}"
                            x-data="{
                                    approved: {{ $item->isApprove == '1' ? 'true' : 'false' }},
                                    canApprove: {{ $item->isSend == '1' ? 'true' : 'false' }},
                                    hasWarning: {{ ( ($item->isWrong ?? '0') == '1' || !empty($item->messages) ) ? 'true' : 'false' }}
                                }">

                            {{-- Col 1 --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->isWrong == '1')
                                    <div class="w-9 h-9 rounded-2xl bg-red-50 border border-red-200 flex items-center justify-center text-red-600 shrink-0 animate-pulse"
                                        title="ข้อมูลมีความผิดปกติ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 9v4" />
                                            <path d="M12 17h.01" />
                                        </svg>
                                    </div>
                                    @endif
                                    <span class="font-mono text-slate-800 font-extrabold">{{ (int)$item->NO }}</span>
                                </div>
                            </td>

                            {{-- Col 2 --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-start gap-1">
                                    <span class="font-mono font-extrabold text-indigo-800 text-base tracking-wider">
                                        {{ $item->ID }}
                                    </span>

                                    @if(!empty($item->messages))
                                    <div id="error-msg-{{ $item->ID }}" class="mt-1 px-3 py-2 bg-red-50 border border-red-100 rounded-lg w-full max-w-[16rem]">
                                        <div class="flex items-start gap-2">
                                            {{-- ไอคอน --}}
                                            <div id="error-icon-{{ $item->ID }}"> {{-- เพิ่ม ID ให้ส่วนไอคอนด้วย --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <line x1="12" y1="8" x2="12" y2="12" />
                                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                                </svg>
                                            </div>

                                            <p class="text-xs text-red-700 font-bold leading-relaxed break-words min-w-0">
                                                {{ $item->messages }}
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Col 3 --}}
                            <td class="px-6 py-4 text-slate-700">
                                @if($item->rec_fname)
                                <span class="font-bold text-slate-800">{{ $item->rec_fname }} {{ $item->rec_lname }}</span>
                                @else
                                <span class="text-slate-400 font-bold">-</span>
                                @endif
                            </td>

                            {{-- Col 4 --}}
                            <td class="px-6 py-4 text-slate-700 inspector-cell">
                                @if($item->insp_fname)
                                <span class="font-bold text-slate-800">{{ $item->insp_fname }} {{ $item->insp_lname }}</span>
                                @else
                                <span class="text-slate-400 font-bold">-</span>
                                @endif
                            </td>

                            {{-- Col 5 --}}
                            <td class="px-6 py-4 text-center status-cell">
                                @if($item->isSend == '1' && $item->isApprove == '1')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    อนุมัติแล้ว
                                </span>
                                @elseif($item->isSend == '1')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                    บันทึกแล้ว
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    ไม่ได้บันทึก
                                </span>
                                @endif
                            </td>

                            {{-- Col 6 --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('survey.form', ['id' => $item->ID]) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-2xl text-indigo-600 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-colors"
                                        title="แก้ไขข้อมูล">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role->value === App\Enums\UserRole::SUPERVISOR->value)
                                    <!-- <template x-if="canApprove && !approved">
                                        <button @click="approveSurvey('{{ $item->ID }}', () => approved = true, $el)"
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-2xl text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition-colors"
                                            title="อนุมัติงาน">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                <polyline points="22 4 12 14.01 9 11.01" />
                                            </svg>
                                        </button>
                                    </template> -->
                                    <template x-if="canApprove && !approved">
                                        <button
                                            :disabled="hasWarning"
                                            @click="if (hasWarning) return; approveSurvey('{{ $item->ID }}', () => approved = true, $el)"
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-2xl border transition-colors"
                                            :class="hasWarning
                                                ? 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed opacity-60'
                                                : 'text-emerald-600 hover:bg-emerald-50 border-transparent hover:border-emerald-100'"
                                            :title="hasWarning ? 'มีแจ้งเตือน/ข้อมูลผิดปกติ ยังไม่สามารถอนุมัติได้' : 'อนุมัติงาน'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                <polyline points="22 4 12 14.01 9 11.01" />
                                            </svg>
                                        </button>
                                    </template>

                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center bg-slate-50/60">
                                <div class="max-w-md mx-auto">
                                    <div class="w-14 h-14 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-center justify-center mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8" />
                                            <path d="m21 21-4.3-4.3" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-slate-700 font-extrabold">ไม่พบข้อมูล</p>
                                    <p class="text-sm text-slate-500 font-medium mt-1">ลองเปลี่ยนคำค้นหาหรือสถานะการกรอง</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-white">
                <x-pagination.indigo :paginator="$items" :query="request()->query()" :on-each-side="1" />
            </div>
        </div>
    </div>
</div>

<script>
    function parseNumber(text) {
        // รองรับ number_format ที่มี comma เช่น "1,234"
        const cleaned = String(text || '').replace(/,/g, '').trim();
        const n = parseInt(cleaned, 10);
        return Number.isNaN(n) ? 0 : n;
    }

    function formatNumber(n) {
        return new Intl.NumberFormat('en-US').format(n ?? 0);
    }

    function updateStatsAfterApprove() {
        const savedEl = document.getElementById('stat-saved');
        const approvedEl = document.getElementById('stat-approved');
        if (!savedEl || !approvedEl) return;

        const saved = parseNumber(savedEl.textContent);
        const approved = parseNumber(approvedEl.textContent);

        savedEl.textContent = formatNumber(Math.max(0, saved - 1));
        approvedEl.textContent = formatNumber(approved + 1);
    }

    function approveSurvey(id, onSuccess, btnElement) {
        btnElement.disabled = true;
        btnElement.classList.add('opacity-50', 'cursor-not-allowed');

        fetch(`/survey/approve/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    onSuccess();

                    const row = document.getElementById('row-' + id);
                    if (row) {
                        const statusCell = row.querySelector('.status-cell');
                        if (statusCell) {
                            statusCell.innerHTML = `
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    อนุมัติแล้ว
                                </span>
                            `;
                        }

                        const inspectorCell = row.querySelector('.inspector-cell');
                        if (inspectorCell && data.inspector_name) {
                            inspectorCell.innerHTML = `<span class="font-bold text-slate-800">${data.inspector_name}</span>`;
                        }

                        const errorIcon = row.querySelector('.bg-red-50.text-red-600.animate-pulse'); // คลาสเฉพาะของไอคอนตกใจ
                        if (errorIcon) {
                            errorIcon.remove();
                        }

                        const errorBox = document.getElementById('error-msg-' + id);
                        if (errorBox) {
                            errorBox.remove(); // ลบกล่องข้อความทิ้งทันที
                        }
                    }

                    updateStatsAfterApprove();

                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: 'อนุมัติ ID ' + id + ' เรียบร้อยแล้ว'
                    }));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btnElement.disabled = false;
                btnElement.classList.remove('opacity-50', 'cursor-not-allowed');
                alert('เกิดข้อผิดพลาด: ' + error.message);
            });
    }
</script>
@endsection