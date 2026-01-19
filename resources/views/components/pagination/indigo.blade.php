@props([
'paginator' => null,
'query' => null,
'onEachSide' => 1,
'showSummary' => true,
'showJump' => true,
])

@php
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

$isPaginator = $paginator instanceof PaginatorContract;

if ($isPaginator && !empty($query) && method_exists($paginator, 'appends')) {
$paginator->appends($query);
}

$isLengthAware = $isPaginator && ($paginator instanceof LengthAwarePaginatorContract);
$current = $isPaginator && method_exists($paginator, 'currentPage') ? $paginator->currentPage() : 1;
$last = $isLengthAware && method_exists($paginator, 'lastPage') ? $paginator->lastPage() : 1;
$side = max(0, (int) $onEachSide);
$start = max(1, $current - $side);
$end = min($last, $current + $side);

$pages = [];
if ($isLengthAware && $last > 1) {
$pages[] = 1;
if ($start > 2) $pages[] = '...';
for ($i = $start; $i <= $end; $i++) {
    if ($i !==1 && $i !==$last) $pages[]=$i;
    }
    if ($end < $last - 1) $pages[]='...' ;
    if ($last !==1) $pages[]=$last;
    $pages=array_values(array_unique($pages));
    }

    $jumpQuery=is_array($query) ? $query : [];
    unset($jumpQuery['page']);
    @endphp

    @if ($isPaginator && method_exists($paginator, 'hasPages' ) && $paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row items-center justify-between gap-4">

        {{-- Summary (ซ่อนในมือถือ แสดงเฉพาะ Tablet ขึ้นไป) --}}
        @if($showSummary && $isLengthAware)
        <div class="hidden sm:block text-sm font-semibold text-slate-600">
            แสดง <span class="font-extrabold text-slate-800">{{ $paginator->firstItem() }}</span>
            ถึง <span class="font-extrabold text-slate-800">{{ $paginator->lastItem() }}</span>
            จาก <span class="font-extrabold text-slate-800">{{ $paginator->total() }}</span> รายการ
        </div>

        {{-- Summary สำหรับมือถือ (ย่อสั้นๆ) --}}
        <div class="sm:hidden text-xs font-semibold text-slate-500">
            หน้า {{ $current }} / {{ $last }} ({{ $paginator->total() }} รายการ)
        </div>
        @endif

        {{-- Controls --}}
        <div class="flex flex-wrap justify-center items-center gap-1 rounded-2xl bg-slate-50 border border-slate-200 p-1 w-full sm:w-auto">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
            <span class="w-9 h-9 sm:w-10 sm:h-10 inline-flex items-center justify-center rounded-xl text-slate-300 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </span>
            @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-9 h-9 sm:w-10 sm:h-10 inline-flex items-center justify-center rounded-xl text-slate-600 hover:bg-white hover:text-indigo-700 hover:shadow-sm transition-all" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </a>
            @endif

            {{-- Page Numbers --}}
            @if($isLengthAware)
            @foreach ($pages as $p)
            @if ($p === '...')
            <span class="px-1 text-slate-400 font-bold text-xs">...</span>
            @elseif ($p == $paginator->currentPage())
            <span class="min-w-[2.25rem] h-9 sm:min-w-[2.5rem] sm:h-10 px-2 inline-flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold shadow-md shadow-indigo-200 text-sm">
                {{ $p }}
            </span>
            @else
            <a href="{{ $paginator->url($p) }}" class="min-w-[2.25rem] h-9 sm:min-w-[2.5rem] sm:h-10 px-2 inline-flex items-center justify-center rounded-xl text-slate-600 font-bold hover:bg-white hover:text-indigo-700 hover:shadow-sm border border-transparent transition-all text-sm">
                {{ $p }}
            </a>
            @endif
            @endforeach
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 sm:w-10 sm:h-10 inline-flex items-center justify-center rounded-xl text-slate-600 hover:bg-white hover:text-indigo-700 hover:shadow-sm transition-all" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </a>
            @else
            <span class="w-9 h-9 sm:w-10 sm:h-10 inline-flex items-center justify-center rounded-xl text-slate-300 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </span>
            @endif

            {{-- Jump to page (ซ่อนในมือถือถ้าหน้าจอมันแน่นเกินไป หรือปรับให้เล็กลง) --}}
            @if($showJump && $isLengthAware && $last > 1)
            <div class="hidden sm:block mx-1 w-px h-6 bg-slate-200"></div>
            <form method="GET" action="{{ request()->url() }}" class="hidden sm:inline-flex items-center gap-1">
                @foreach($jumpQuery as $k => $v)
                @if(is_array($v))
                @foreach($v as $vv) <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}"> @endforeach
                @else
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endif
                @endforeach

                <input name="page" type="number" inputmode="numeric" min="1" max="{{ $last }}" value="{{ $current }}"
                    class="w-14 h-9 px-2 rounded-xl border border-slate-200 bg-white text-slate-800 font-bold text-xs text-center focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                    onchange="this.form.submit()" />
            </form>
            @endif

        </div>
    </nav>
    @endif