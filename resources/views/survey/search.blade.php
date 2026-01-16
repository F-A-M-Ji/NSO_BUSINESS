@extends('layouts.app')

@section('title', 'ค้นหาข้อมูลสถานประกอบการ')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-slate-50 to-indigo-50/30 font-sans p-4">
    <div class="max-w-4xl w-full">

        <a href="{{ url('/') }}" class="group mb-8 inline-flex items-center gap-2 text-slate-500 hover:text-indigo-900 transition-colors decoration-0">
            <div class="p-2 rounded-full bg-white border border-slate-200 group-hover:border-indigo-200 shadow-sm group-hover:shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </div>
            <span class="font-medium text-sm">กลับสู่หน้าหลัก</span>
        </a>

        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] shadow-xl shadow-indigo-100 border border-white p-6 md:p-10 relative overflow-hidden">
            <div class="relative z-10 text-center">
                <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-2">ระบุรหัส</h2>
                <p class="text-slate-500 mb-8 text-sm md:text-base">กรุณากรอกรหัส ID 15 หลัก</p>
                <form action="{{ route('survey.check') }}" method="POST" class="max-w-xl mx-auto"
                    x-data="{ currentId: '' }">
                    @csrf

                    <div class="mb-8" @input="currentId = $event.target.value">
                        <x-input-box
                            name="establishment_id"
                            placeholder=""
                            maxlength="15"
                            autofocus
                            class="text-2xl md:text-3xl tracking-[0.3em]" />
                        @error('establishment_id')
                        <p class="text-red-500 text-sm text-center mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="max-w-md mx-auto">
                        <x-button type="submit" class="w-full justify-center py-4 text-lg" ::disabled="currentId.length !== 15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            ค้นหาข้อมูลแบบสอบถาม
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection