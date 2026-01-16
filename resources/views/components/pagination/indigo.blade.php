@props([
'paginator' => null,
'query' => null, // request()->query()
'onEachSide' => 1, // จำนวนหน้าข้าง ๆ current
'showSummary' => true, // แสดง summary
])

@php
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

$isPaginator = $paginator instanceof PaginatorContract;

// ถ้าไม่ใช่ paginator จริง ๆ ให้ไม่แสดง (กัน error)
if ($isPaginator && !empty($query) && method_exists($paginator, 'appends')) {
$paginator->appends($query);
}

$isLengthAware = $isPaginator && ($paginator instanceof LengthAwarePaginatorContract);

// คำนวณช่วงหน้า (ทำเอง ไม่ใช้ elements())
$current = $isPaginator && method_exists($paginator, 'currentPage') ? $paginator->currentPage() : 1;
$last = $isLengthAware && method_exists($paginator, 'lastPage') ? $paginator->lastPage() : 1;

$side = max(0, (int) $onEachSide);
$start = max(1, $current - $side);
$end = min($last, $current + $side);

// สร้างรายการหน้าแบบ: 1 ... [ช่วงกลาง] ... last
$pages = [];
if ($isLengthAware && $last > 1) {
$pages[] = 1;

if ($start > 2) $pages[] = '...';

for ($i = $start; $i <= $end; $i++) {
    if ($i !==1 && $i !==$last) $pages[]=$i;
    }

    if ($end < $last - 1) $pages[]='...' ;

    if ($last !==1) $pages[]=$last;

    // ลบซ้ำ (กรณี last/page ชนกัน)
    $pages=array_values(array_unique($pages));
    }
    @endphp

    @if ($isPaginator && method_exists($paginator, 'hasPages' ) && $paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation"
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        {{-- Summary (เฉพาะ LengthAware จะมี total/firstItem/lastItem) --}}
        @if($showSummary && $isLengthAware)
        <div class="text-sm font-semibold text-slate-600">
            แสดง
            <span class="font-extrabold text-slate-800">{{ $paginator->firstItem() }}</span>
            ถึง
            <span class="font-extrabold text-slate-800">{{ $paginator->lastItem() }}</span>
            จาก
            <span class="font-extrabold text-slate-800">{{ $paginator->total() }}</span>
            รายการ
        </div>
        @endif

        {{-- Controls --}}
        <div class="inline-flex items-center gap-1 rounded-2xl bg-slate-50 border border-slate-200 p-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
            <span aria-disabled="true"
                class="w-10 h-10 inline-flex items-center justify-center rounded-2xl text-slate-400 opacity-60 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </span>
            @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="w-10 h-10 inline-flex items-center justify-center rounded-2xl text-slate-700 hover:bg-white hover:text-indigo-700 transition"
                aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </a>
            @endif

            {{-- Page numbers (ใช้ $pages ที่คำนวณเอง) --}}
            @if($isLengthAware)
            @foreach ($pages as $p)
            @if ($p === '...')
            <span class="px-2 text-slate-400 font-extrabold">…</span>
            @elseif ($p == $paginator->currentPage())
            <span aria-current="page"
                class="min-w-10 h-10 px-4 inline-flex items-center justify-center rounded-2xl bg-indigo-600 text-white font-extrabold shadow-md shadow-indigo-200">
                {{ $p }}
            </span>
            @else
            <a href="{{ $paginator->url($p) }}"
                class="min-w-10 h-10 px-4 inline-flex items-center justify-center rounded-2xl text-slate-700 font-extrabold hover:bg-white hover:text-indigo-700 hover:border-indigo-100 border border-transparent transition"
                aria-label="Go to page {{ $p }}">
                {{ $p }}
            </a>
            @endif
            @endforeach
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="w-10 h-10 inline-flex items-center justify-center rounded-2xl text-slate-700 hover:bg-white hover:text-indigo-700 transition"
                aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </a>
            @else
            <span aria-disabled="true"
                class="w-10 h-10 inline-flex items-center justify-center rounded-2xl text-slate-400 opacity-60 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </span>
            @endif
        </div>
    </nav>
    @endif