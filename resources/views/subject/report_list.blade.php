{{-- resources/views/subject/report_list.blade.php --}}
@extends('layouts.app')

@section('title', 'รายการข้อมูลครบถ้วน (Subject)')

@section('content')
<style>
    [x-cloak] { display: none !important; }

    @keyframes scaleUp {
        0% { transform: scale(.96); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-scale-up { animation: scaleUp .18s ease-out; }

    /* Sticky columns */
    :root {
        --sticky-col1: 120px; /* NO */
        --sticky-col2: 90px;  /* ERROR */
    }
    @media (max-width: 640px) {
        :root {
            --sticky-col1: 108px;
            --sticky-col2: 84px;
        }
    }
    .sticky-col-1 { position: sticky; left: 0; z-index: 12; }
    .sticky-col-2 { position: sticky; left: var(--sticky-col1); z-index: 12; }
    .sticky-shadow { box-shadow: 2px 0 10px -6px rgba(0,0,0,.18); }

    /* Optional scrollbar */
    .scroll-smoothbar::-webkit-scrollbar { height: 10px; width: 10px; }
    .scroll-smoothbar::-webkit-scrollbar-thumb { background: rgba(100,116,139,.22); border-radius: 999px; }
    .scroll-smoothbar::-webkit-scrollbar-track { background: rgba(148,163,184,.12); }
</style>

<div
    class="min-h-screen pt-24 pb-12 bg-slate-50 font-sans"
    x-data="{
        reportModalOpen: false,
        targetId: '',
        note: '',
        noteMax: 255,
        inputVal: '',
        openReport(id) {
            this.reportModalOpen = true;
            this.targetId = id;
            this.note = '';
            this.$nextTick(() => this.$refs.noteInput?.focus());
        },
        closeReport() {
            this.reportModalOpen = false;
            this.targetId = '';
            this.note = '';
        }
    }"
    @keydown.escape.window="if(reportModalOpen) closeReport()"
>

    {{-- ===== TOP UI (เอากลับมาเหมือนที่เคยตกแต่ง) ===== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div class="mb-6 rounded-3xl overflow-hidden border border-indigo-100 shadow-sm bg-gradient-to-br from-indigo-50 via-white to-slate-50">
            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="min-w-0">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-200 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4" />
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900">รายการข้อมูลที่อนุมัติแล้ว</h1>
                            <p class="text-sm text-slate-600 font-medium">
                                ข้อมูลจากทุกจังหวัดที่ผ่านการตรวจสอบสมบูรณ์
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                    <span class="inline-flex items-center justify-center px-4 py-2 rounded-2xl bg-white border border-indigo-100 text-indigo-700 font-extrabold text-sm shadow-sm">
                        ทั้งหมด: {{ number_format($items->total()) }} รายการ
                    </span>

                    <button type="button"
                        onclick="window.location.reload()"
                        class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 px-5 py-3 rounded-2xl font-extrabold border border-slate-200 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-3-6.7" />
                            <path d="M21 3v6h-6" />
                        </svg>
                        รีเฟรช
                    </button>
                </div>
            </div>
        </div>

        {{-- Filters (สำคัญ: z สูง + overflow-visible กัน dropdown โดนตัด/โดนบัง) --}}
        <div class="relative z-10 bg-white/90 backdrop-blur p-5 rounded-3xl shadow-sm border border-slate-200 mb-6 overflow-visible">
            <form action="{{ route('subject.reports') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                {{-- ค้นหา --}}
                <div class="md:col-span-5">
                    <x-input-box
                        name="search"
                        label="ค้นหาสถานประกอบการณ์"
                        :value="request('search')"
                        placeholder="ระบุคำค้นหา..."
                        class="text-left text-sm font-medium text-slate-700"
                        @input="inputVal = $event.target.value" />
                </div>

                {{-- จังหวัด (ห่อด้วย z สูงอีกชั้น แก้ตามรูป dropdown ทับตารางแล้วโดนบัง) --}}
                <div class="md:col-span-4 relative z-20">
                    <x-searchable-select
                        id="cwt_filter"
                        name="cwt"
                        label="จังหวัด"
                        :options="$provinces"
                        :value="request('cwt')"
                        placeholder="-- ทุกจังหวัด --" />
                </div>

                {{-- ปุ่ม --}}
                <div class="md:col-span-3 flex gap-2">
                    <x-button type="submit" class="flex-1 justify-center py-3 font-extrabold rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        กรองข้อมูล
                    </x-button>

                    @if(request()->has('search') || request()->has('cwt'))
                        <a href="{{ route('subject.reports') }}"
                           class="px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-extrabold transition-colors flex items-center justify-center">
                            ล้าง
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden relative z-0">
            {{-- แค่ overflow-x ตัวเดียว (ไม่ทำ scroll ซ้อน) --}}
            <div class="overflow-x-auto scroll-smoothbar">
                <table class="w-max min-w-full text-left border-collapse whitespace-nowrap">
                    {{-- ลด z ของ thead sticky ไม่ให้ทับ dropdown (แก้ตามรูป) --}}
                    <thead class="text-xs text-slate-600 uppercase bg-slate-50 border-b border-slate-200 font-extrabold tracking-wider sticky top-0 z-[5]">
                        <tr>
                            <th
                                class="px-4 sm:px-6 py-4 sticky-col-1 !bg-slate-50 border-r border-slate-200 sticky-shadow"
                                style="width: var(--sticky-col1); min-width: var(--sticky-col1);"
                            >
                                ลำดับ (NO)
                            </th>

                            <th
                                class="px-4 sm:px-6 py-4 sticky-col-2 !bg-slate-50 border-r border-slate-200 sticky-shadow text-center"
                                style="width: var(--sticky-col2); min-width: var(--sticky-col2);"
                            >
                                ERROR
                            </th>

                            @foreach($columns as $col)
                                <th class="px-4 sm:px-6 py-4 border-r border-slate-200/70 last:border-0">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-sm font-semibold">
                        @forelse($items as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                {{-- NO --}}
                                <td
                                    class="px-4 sm:px-6 py-4 sticky-col-1 bg-white group-hover:bg-slate-50/80 border-r border-slate-200 sticky-shadow"
                                    style="width: var(--sticky-col1); min-width: var(--sticky-col1);"
                                >
                                    <div class="flex items-center gap-3">
                                        <button type="button"
                                            @click="openReport('{{ $item->ID }}')"
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-2xl text-red-600 hover:bg-red-50 border border-transparent hover:border-red-100 transition-colors shrink-0"
                                            title="แจ้งหมายเหตุ / แจ้งแก้ไข"
                                            aria-label="แจ้งหมายเหตุ">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </button>

                                        <span class="font-mono font-extrabold text-slate-800">
                                            {{ (int)$item->NO }}
                                        </span>
                                    </div>
                                </td>

                                {{-- ERROR --}}
                                <td
                                    class="px-4 sm:px-6 py-4 sticky-col-2 bg-white group-hover:bg-slate-50/80 border-r border-slate-200 sticky-shadow text-center"
                                    style="width: var(--sticky-col2); min-width: var(--sticky-col2);"
                                >
                                    <!-- <span class="text-slate-400 font-bold">-</span> -->
                                </td>

                                {{-- Dynamic --}}
                                @foreach($columns as $col)
                                    @php($val = $item->$col)
                                    <td class="px-4 sm:px-6 py-4 border-r border-slate-100 last:border-0 text-slate-700 text-center">
                                        @if(blank($val))
                                            <!-- <span class="text-slate-400 font-bold">-</span> -->
                                        @else
                                            {{ $val }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + 2 }}" class="px-6 py-14 text-center bg-slate-50/60">
                                    <div class="max-w-md mx-auto">
                                        <div class="w-14 h-14 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-center justify-center mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8" />
                                                <path d="m21 21-4.3-4.3" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 text-slate-700 font-extrabold">ไม่พบข้อมูล</p>
                                        <p class="text-sm text-slate-500 font-medium mt-1">ลองเปลี่ยนคำค้นหา หรือเลือกจังหวัดใหม่</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination + เว้นท้าย (เหมือนภาพ) --}}
            <div class="px-4 sm:px-6 pt-4 pb-6 border-t border-slate-100 bg-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-sm text-slate-600 font-semibold">
                        @if($items->total() > 0)
                            แสดง {{ number_format($items->firstItem()) }} ถึง {{ number_format($items->lastItem()) }}
                            จาก {{ number_format($items->total()) }} รายการ
                        @else
                            แสดง 0 รายการ
                        @endif
                    </div>

                    <div class="w-full sm:w-auto">
                        <x-pagination.indigo :paginator="$items" :query="request()->query()" :on-each-side="1" />
                    </div>
                </div>

                {{-- เว้นท้ายเพิ่มอีกนิดให้เหมือนรูป --}}
                <div class="h-6"></div>
            </div>
        </div>
    </div>

    {{-- ===== Modal แจ้งหมายเหตุ ===== --}}
    <div
        x-show="reportModalOpen"
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        x-trap.noscroll="reportModalOpen"
        @click.self="closeReport()"
    >
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeReport()"></div>

        <div
            class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden animate-scale-up"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            @click.stop
        >
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-2xl bg-red-50 border border-red-200 flex items-center justify-center text-red-600 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 9v4" />
                                <path d="M12 17h.01" />
                                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-lg font-extrabold text-slate-900">บันทึกหมายเหตุ</h3>
                            <p class="text-sm text-slate-600 font-medium">
                                สถานประกอบการ:
                                <span x-text="targetId" class="font-mono font-extrabold text-indigo-700"></span>
                            </p>
                        </div>
                    </div>

                    <button type="button"
                        @click="closeReport()"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-2xl text-slate-600 hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-colors"
                        title="ปิด"
                        aria-label="ปิด">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="M6 6 18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <form action="{{ route('subject.reportWrong') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="id" :value="targetId">

                <div class="mb-4">
                    <label class="block text-sm font-extrabold text-slate-700 mb-2">รายละเอียดหมายเหตุ</label>

                    <textarea
                        name="message"
                        rows="5"
                        x-ref="noteInput"
                        x-model="note"
                        :maxlength="noteMax"
                        class="w-full p-4 rounded-2xl border border-slate-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none transition-all text-sm leading-relaxed placeholder:text-slate-400 font-medium"
                        placeholder="ระบุข้อผิดพลาด หรือสิ่งที่ต้องแก้ไข (สูงสุด 255 ตัวอักษร)..."
                        required
                    ></textarea>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-xs text-slate-500 font-bold">
                            <!-- เหลืออีก <span x-text="noteMax - note.length"></span> ตัวอักษร -->
                        </p>
                        <p class="text-xs text-slate-500 font-bold">
                            <span x-text="note.length"></span> / <span x-text="noteMax"></span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 justify-end">
                    <button type="button"
                        @click="closeReport()"
                        class="px-5 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-extrabold transition-colors">
                        ยกเลิก
                    </button>

                    <button type="submit"
                        class="px-5 py-3 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-extrabold shadow-md shadow-red-200 transition-all inline-flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m22 2-7 20-4-9-9-4Z" />
                            <path d="M22 2 11 13" />
                        </svg>
                        ส่งแจ้งเตือน
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
