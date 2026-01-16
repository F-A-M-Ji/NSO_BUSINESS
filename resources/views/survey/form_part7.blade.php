@extends('layouts.app')

@section('title', 'แบบสอบถามตอนที่ 7')

@section('content')
<div class="min-h-screen pt-24 pb-12 bg-slate-50 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            {{-- ปุ่มย้อนกลับ (กลับไปหน้า Part 1) --}}
            <a href="{{ route('survey.part6', ['id' => $control->ID]) }}"
                class="group flex items-center gap-2 text-slate-500 hover:text-indigo-900 transition-colors decoration-0">
                <div class="p-2 rounded-full bg-white border border-slate-200 group-hover:border-indigo-200 shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </div>
                <span class="font-medium text-sm">กลับ</span>
            </a>

            {{-- ชื่อตอน --}}
            <h1 class="text-xl md:text-2xl font-bold text-indigo-900">
                ตอนที่ 7 ความคิดเห็น...
            </h1>
        </div>

        <form id="confirm-form"
            action="{{ route('survey.storePart7') }}"
            method="POST"
            @submit-confirm-form.window="$el.submit()">
            @csrf
            <input type="hidden" name="id" value="{{ $control->ID }}">

            <div class="space-y-6">
                <x-card title="ข้อ 14" class="!overflow-visible">

                </x-card>
            </div>

            @auth
            @php
            $user = auth()->user();
            $role = $user->role;

            // เช็คว่าเป็น Role ที่ต้องแสดงหรือไม่
            $isInterviewer = $role === App\Enums\UserRole::INTERVIEWER;
            $isSupervisorOrSubject = in_array($role, [App\Enums\UserRole::SUPERVISOR, App\Enums\UserRole::SUBJECT]);
            $shouldShow = $isInterviewer || $isSupervisorOrSubject;
            @endphp

            @if($shouldShow)
            <x-card title="ส่วนบันทึกเจ้าหน้าที่" class="!overflow-visible">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                </x-slot>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- 1. เจ้าหน้าที่ปฏิบัติงานเก็บรวบรวมข้อมูล --}}
                    <x-input-box
                        name="staff_collector"
                        label="เจ้าหน้าที่ปฏิบัติงานเก็บรวบรวมข้อมูล"
                        :value="old('staff_collector', $control->H01 ?? ($isInterviewer ? $user->username : ''))"
                        class="bg-slate-100 text-slate-500 cursor-not-allowed text-center font-mono"
                        readonly />

                    {{-- 2. เจ้าหน้าที่บรรณาธิกรและลงรหัส --}}
                    <x-input-box
                        name="staff_editor"
                        label="เจ้าหน้าที่บรรณาธิกรและลงรหัส"
                        :value="old('staff_editor', $control->H02 ?? ($isInterviewer ? $user->username : ''))"
                        class="bg-slate-100 text-slate-500 cursor-not-allowed text-center font-mono"
                        readonly />

                    {{-- 3. เจ้าหน้าที่บันทึกข้อมูล --}}
                    <x-input-box
                        name="staff_recorder"
                        label="เจ้าหน้าที่บันทึกข้อมูล"
                        :value="old('staff_recorder', $control->H03 ?? ($isInterviewer ? $user->username : ''))"
                        class="bg-slate-100 text-slate-500 cursor-not-allowed text-center font-mono"
                        readonly />

                    {{-- 4. ผู้ตรวจ (แสดงเฉพาะ Supervisor/Subject) --}}
                    @if($isSupervisorOrSubject)
                    <x-input-box
                        name="staff_inspector"
                        label="ผู้ตรวจ"
                        :value="old('staff_inspector', $control->H04 ?? $user->username)"
                        class="bg-slate-100 text-slate-500 cursor-not-allowed text-center font-mono"
                        readonly />
                    @endif

                </div>
            </x-card>
            @endif
            @endauth

            <div class="flex flex-col sm:flex-row gap-4 pt-8 pb-12">
                <x-button type="button"
                    color="emerald"
                    @click="$dispatch('open-confirm-modal')" {{-- เมื่อคลิก ให้ส่ง event ไปเปิด Modal --}}
                    class="w-full justify-center py-4 text-lg bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 shadow-lg shadow-emerald-200 transition-all">
                    {{-- ไอคอน Save --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    บันทึกข้อมูล
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection