@extends('layouts.app') 

@section('title', 'แบบสอบถามตอนที่ 2')

@section('content')
<div class="min-h-screen pt-24 pb-12 bg-slate-50 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            {{-- ปุ่มย้อนกลับ (กลับไปหน้า Part 1) --}}
            <a href="{{ route('survey.part1', ['id' => $control->ID]) }}" 
               class="group flex items-center gap-2 text-slate-500 hover:text-indigo-900 transition-colors decoration-0">
                <div class="p-2 rounded-full bg-white border border-slate-200 group-hover:border-indigo-200 shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </div>
                <span class="font-medium text-sm">กลับ</span>
            </a>

            {{-- ชื่อตอน --}}
            <h1 class="text-xl md:text-2xl font-bold text-indigo-900">
                ตอนที่ 2 ข้อมูลคนทำงานและค่าตอบแทน
            </h1>
        </div>

        <form action="{{ route('survey.storePart2') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $control->ID }}">

            <div class="space-y-6">
                <x-card title="ข้อ 6: จำนวน..." class="!overflow-visible">
                </x-card>
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