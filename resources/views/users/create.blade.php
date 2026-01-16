@extends('layouts.app', ['active' => 'users'])

@section('title', 'เพิ่มผู้ใช้งานระบบ')

@section('content')
<div class="min-h-screen pt-24 pb-12 bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">เพิ่มผู้ใช้งานใหม่</h1>
            <p class="text-slate-500 text-sm">กรอกข้อมูลเพื่อสร้างบัญชีเจ้าหน้าที่สำหรับเข้าใช้งานระบบ</p>
        </div>

        <x-card title="ข้อมูลบัญชีผู้ใช้">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            </x-slot>

            <form class="space-y-6" action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Username (รหัสพนักงาน) <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm font-mono @error('username') border-red-500 @enderror"
                            maxlength="7" required>
                        @error('username') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm @error('password') border-red-500 @enderror"
                            required>
                        @error('password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr class="border-slate-100">

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">ชื่อจริง <span class="text-red-500">*</span></label>
                        <input type="text" name="firstname" value="{{ old('firstname') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm" placeholder="ระบุชื่อจริง" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">นามสกุล <span class="text-red-500">*</span></label>
                        <input type="text" name="lastname" value="{{ old('lastname') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-sm" placeholder="ระบุนามสกุล" required>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    
                    <x-searchable-select 
                        id="province"
                        name="province_code"
                        label="จังหวัด"
                        :options="$provinces"
                        placeholder="-- พิมพ์หรือเลือกจังหวัด --"
                        required
                    />

                    <x-select 
                        name="role"
                        label="สิทธิ์การใช้งาน (Role)"
                        :options="$roles"
                        placeholder="-- เลือกสิทธิ์ --"
                        required
                    />
                </div>

                <div class="pt-6 flex items-center justify-end gap-3">
                    
                    <x-button type="submit" color="indigo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        บันทึกผู้ใช้
                    </x-button>
                </div>

            </form>
        </x-card>

    </div>
</div>
@endsection