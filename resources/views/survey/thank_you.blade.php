@extends('layouts.app')

@section('title', 'ขอบคุณสำหรับข้อมูล')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 font-sans p-4">
    {{-- การ์ดสีขาวตรงกลางหน้าจอ --}}
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 text-center">

        {{-- Icon (วงกลมสีเขียว พร้อมเครื่องหมายถูก) --}}
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12" />
            </svg>
        </div>

        {{-- Title & Description --}}
        <h2 class="text-2xl font-bold text-slate-900 mb-4">
            ขอบคุณสำหรับข้อมูล
        </h2>
        <p class="text-slate-600 leading-relaxed mb-8">
            ข้อมูลของท่านได้รับการบันทึกเรียบร้อยแล้ว<br>
            สำนักงานสถิติแห่งชาติขอขอบคุณในความร่วมมือของท่าน<br>
            ข้อมูลนี้จะเป็นประโยชน์อย่างยิ่งต่อการวางแผนพัฒนาประเทศ
        </p>

        {{-- Button (กลับสู่หน้าหลัก) --}}
        <a href="{{ url('/') }}"
            class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-indigo-600 px-6 py-4 text-lg font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl transition-all">
            {{-- ไอคอน Home --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            กลับสู่หน้าหลัก
        </a>
    </div>
</div>
@endsection