<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ระบบสำรวจธุรกิจ')</title>

    <link rel="icon" href="{{ asset('images/NSOlogo.png') }}" type="image/jpeg">
    <link rel="shortcut icon" href="{{ asset('images/NSOlogo.png') }}" type="image/jpeg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Prompt', sans-serif;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-scale-up {
            animation: scaleUp 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleUp {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 selection:bg-indigo-100 selection:text-indigo-900">

    <x-navbar :active="$active ?? ''" />

    <main>
        @yield('content')
    </main>

    <div id="login-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 animate-fade-in">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('login-modal')"></div>
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 border border-white/50 animate-scale-up">
            <button onclick="toggleModal('login-modal')" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center p-4 bg-indigo-50 rounded-2xl mb-4 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">เข้าสู่ระบบ</h3>
                <p class="text-slate-500 text-sm mt-2">กรุณาระบุรหัสผ่านเพื่อเข้าใช้งานระบบ</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="space-y-1.5 mb-5">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">
                        ชื่อผู้ใช้งาน
                    </label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all placeholder:text-slate-400 text-sm font-medium"
                            placeholder="Username / ID Code" required autofocus>
                    </div>
                </div>

                <div class="space-y-1.5 mb-4">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">
                        รหัสผ่าน
                    </label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m21 2-2 2m-7.6 7.6a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0 3 3L22 7l-3-3m-3.5 3.5L19 4" />
                            </svg>
                        </div>
                        <input type="password" name="password"
                            class="w-full pl-10 pr-12 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all placeholder:text-slate-400 text-sm font-medium"
                            placeholder="Password" required>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded cursor-pointer transition-colors bg-slate-50">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-500 cursor-pointer select-none hover:text-slate-700 font-medium">
                            จำการเข้าระบบไว้
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-indigo-900 to-indigo-800 hover:from-indigo-800 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    เข้าสู่ระบบ
                </button>
            </form>
        </div>
    </div>

    <div id="login-error-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center p-4 animate-fade-in">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeLoginErrorModal()"></div>
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6 border border-red-100 animate-scale-up text-center">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">เข้าสู่ระบบไม่สำเร็จ</h3>
            <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                @if($errors->any())
                {{ $errors->first() }}
                @else
                เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง
                @endif
            </p>
            <button onclick="closeLoginErrorModal()" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-red-200">
                ตกลง
            </button>
        </div>
    </div>

    <div id="error-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center p-4 animate-fade-in">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeErrorModal()"></div>
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6 border border-red-100 animate-scale-up text-center">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">ดำเนินการไม่สำเร็จ</h3>
            <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                @if($errors->any())
                {{ $errors->first() }}
                @else
                เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง
                @endif
            </p>
            <button onclick="closeErrorModal()" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-red-200">
                ตกลง
            </button>
        </div>
    </div>

    <div id="success-modal" class="fixed inset-0 z-[120] hidden flex items-center justify-center p-4 animate-fade-in">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeSuccessModal()"></div>
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6 border border-green-100 animate-scale-up text-center">
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-2">ดำเนินการสำเร็จ</h3>

            <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                {{ session('success') }}
            </p>

            <button onclick="closeSuccessModal()" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-green-200">
                ตกลง
            </button>
        </div>
    </div>

    <div x-data="{ open: false }"
        x-show="open"
        @open-confirm-modal.window="open = true"
        class="relative z-[150]"
        style="display: none;"
        x-cloak>
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md animate-scale-up">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 text-center">
                        <div class="mx-auto flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:h-24 sm:w-24 mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-amber-500 sm:h-14 sm:w-14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                <path d="M12 9v4" />
                                <path d="M12 17h.01" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold leading-6 text-slate-900 mb-3">
                            ยืนยันการส่งข้อมูล
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-slate-500">
                                ท่านต้องการส่งข้อมูลนี้ใช่หรือไม่?
                                <!-- <br>เมื่อส่งแล้วจะไม่สามารถแก้ไขได้ -->
                            </p>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <button type="button"
                            @click="$dispatch('submit-confirm-form'); open = false;"
                            class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 sm:w-auto transition-colors">
                            ใช่, ส่งข้อมูล
                        </button>
                        <button type="button"
                            @click="open = false"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                            ไม่, กลับไปแก้ไข
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) menu.classList.toggle('hidden');
        }

        function closeLoginErrorModal() {
            const modal = document.getElementById('login-error-modal');
            if (modal) modal.classList.add('hidden');
        }

        function closeErrorModal() {
            document.getElementById('error-modal').classList.add('hidden');
        }

        function closeSuccessModal() {
            document.getElementById('success-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const hasErrors = "{{ $errors->any() ? 'true' : 'false' }}" === 'true';

            if (hasErrors) {
                const errorModal = document.getElementById('error-modal');
                if (errorModal) {
                    errorModal.classList.remove('hidden');
                }
            }

            const hasSuccess = "{{ session()->has('success') ? 'true' : 'false' }}" === 'true';

            if (hasSuccess) {
                const successModal = document.getElementById('success-modal');
                if (successModal) successModal.classList.remove('hidden');
            }
        });
    </script>
</body>

</html>
