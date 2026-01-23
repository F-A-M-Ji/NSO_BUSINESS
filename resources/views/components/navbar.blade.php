@props(['active' => ''])

@php
use App\Enums\UserRole;
$user = auth()->user();
@endphp

<nav class="fixed w-full z-50 bg-white/95 backdrop-blur-xl shadow-sm border-b border-slate-100 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-3 cursor-pointer group" onclick="window.location.href='/'">
                <img src="{{ asset('images/NSOlogo.png') }}"
                    alt="Logo"
                    class="h-10 w-auto md:h-12 lg:h-14 object-contain bg-white rounded-lg transition-transform duration-300 group-hover:scale-105">
                <div class="flex flex-col">
                    <span class="font-bold text-indigo-900 text-sm md:text-base leading-tight tracking-wide">สำนักงานสถิติแห่งชาติ</span>
                    <span class="text-[10px] md:text-xs text-slate-500 font-medium">กระทรวงดิจิทัลเพื่อเศรษฐกิจและสังคม</span>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4">

                @auth
                {{-- 🔹 เมนูสำหรับ ADMIN --}}
                @if($user->role === UserRole::ADMIN)
                <a href="{{ url('/') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    หน้าหลัก
                </a>
                <a href="{{ route('users.create') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $active == 'users' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    เพิ่มผู้ใช้งาน
                </a>
                @endif

                {{-- เมนูสำหรับ INTERVIEWER --}}
                @if($user->role === UserRole::INTERVIEWER)
                <a href="{{ url('/') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    หน้าหลัก
                </a>
                {{-- ใช้ request()->routeIs('dashboard') เพื่อเช็คว่าอยู่หน้า dashboard หรือไม่ --}}
                <a href="{{ route('dashboard') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ ($active == 'dashboard' || request()->routeIs('dashboard')) ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    การติดตามงาน
                </a>
                @endif

                {{-- เมนูสำหรับ SUPERVISOR --}}
                @if($user->role === UserRole::SUPERVISOR)
                <a href="{{ url('/') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    หน้าหลัก
                </a>
                {{-- ใช้ request()->routeIs('dashboard') เพื่อเช็คว่าอยู่หน้า dashboard หรือไม่ --}}
                <a href="{{ route('dashboard') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ ($active == 'dashboard' || request()->routeIs('dashboard')) ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    การติดตามงาน
                </a>
                @endif

                @if($user->role === UserRole::SUBJECT)
                <a href="{{ url('/') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    หน้าหลัก
                </a>
                <a href="{{ route('subject.reports') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ ($active == 'subject.reports' || request()->routeIs('subject.reports')) ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    ข้อมูลที่อนุมัติแล้ว
                </a>
                @endif

                @endauth

                {{-- ส่วนปุ่ม Profile / Login --}}
                @guest
                <a href="{{ url('/') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:text-indigo-900' }}">
                    หน้าหลัก
                </a>
                <button onclick="toggleModal('login-modal')" class="ml-4 flex items-center gap-2 px-5 py-2 rounded-full bg-slate-100 hover:bg-white hover:shadow-md text-indigo-900 font-bold transition-all text-xs border border-slate-200 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    เข้าสู่ระบบเจ้าหน้าที่
                </button>
                @else
                <div class="relative ml-4">
                    <button onclick="toggleUserDropdown()" class="flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 hover:bg-indigo-100 text-indigo-900 font-bold transition-all text-sm border border-indigo-100">
                        {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-1 animate-scale-up origin-top-right z-50">
                        <div class="px-4 py-2 border-b border-slate-50 text-xs text-slate-500">
                            สถานะ: {{ Auth::user()->role->label() ?? Auth::user()->role->value }}
                        </div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                            ออกจากระบบ
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="text-slate-600 p-2 hover:bg-slate-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="12" x2="20" y2="12" />
                        <line x1="4" y1="6" x2="20" y2="6" />
                        <line x1="4" y1="18" x2="20" y2="18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 shadow-xl absolute w-full z-40">
        <div class="px-4 pt-4 pb-6 space-y-3">
            @auth
            @if($user->role === UserRole::ADMIN)
            <a href="{{ url('/') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">หน้าหลัก</a>
            <a href="{{ route('users.create') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ $active == 'users' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">จัดการผู้ใช้งาน</a>
            @endif

            @if($user->role === UserRole::INTERVIEWER)
            <a href="{{ url('/') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">หน้าหลัก</a>
            <a href="{{ route('dashboard') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ ($active == 'dashboard' || request()->routeIs('dashboard')) ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">การติดตามงาน</a>
            @endif

            @if($user->role === UserRole::SUPERVISOR)
            <a href="{{ url('/') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">หน้าหลัก</a>
            <a href="{{ route('dashboard') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ ($active == 'dashboard' || request()->routeIs('dashboard')) ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">การติดตามงาน</a>
            @endif

            @if($user->role === UserRole::SUBJECT)
            <a href="{{ url('/') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">หน้าหลัก</a>
            <a href="{{ route('subject.reports') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ ($active == 'subject.reports' || request()->routeIs('subject.reports')) ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">ข้อมูลที่อนุมัติแล้ว</a>
            @endif

            <div class="pt-4 mt-4 border-t border-slate-100">
                <div class="flex items-center gap-3 px-4 mb-3">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-800">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                        <span class="text-xs text-slate-500">{{ Auth::user()->role->label() ?? Auth::user()->role->value }}</span>
                    </div>
                </div>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm text-red-600 hover:bg-red-50 transition-colors">
                    ออกจากระบบ
                </a>
            </div>
            @endauth

            @guest
            <a href="{{ url('/') }}" class="block w-full text-left px-4 py-3 rounded-lg font-semibold text-sm {{ $active == 'home' ? 'bg-indigo-50 text-indigo-900' : 'text-slate-600 hover:bg-slate-50' }}">หน้าหลัก</a>
            <button onclick="toggleModal('login-modal'); toggleMobileMenu()" class="w-full mt-4 flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-indigo-50 text-indigo-900 font-bold border border-indigo-100 shadow-sm text-sm">
                เข้าสู่ระบบเจ้าหน้าที่
            </button>
            @endguest
        </div>
    </div>

    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('user-dropdown');
            if (dropdown) dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('user-dropdown');
            const button = document.querySelector('button[onclick="toggleUserDropdown()"]');
            if (dropdown && button && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</nav>
