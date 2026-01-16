@extends('layouts.app', ['active' => 'home'])

@section('title', 'การสำรวจธุรกิจทางการค้าและธุรกิจทางการบริการ')

@section('content')
<header class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden bg-gradient-to-b from-slate-50 to-white">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[20rem] h-[20rem] rounded-full bg-gradient-to-br from-indigo-100/40 to-amber-100/40 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[15rem] h-[15rem] rounded-full bg-gradient-to-tr from-indigo-50 to-white blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight drop-shadow-sm">
            การสำรวจธุรกิจทางการค้า <br class="hidden md:block" />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-800 via-indigo-600 to-amber-500">และธุรกิจทางการบริการ</span>
        </h1>

        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-indigo-100 shadow-md shadow-indigo-100/50 text-indigo-900 text-sm font-bold mb-8 animate-fade-in">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
            </span>
            ประจำปี พ.ศ. 2569
        </div>

        <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-600 mb-8 leading-relaxed font-light">
            ร่วมเป็นส่วนหนึ่งในการขับเคลื่อนเศรษฐกิจไทย <br class="hidden sm:block" />
            ด้วยข้อมูลที่ถูกต้อง แม่นยำ และเป็นความลับ
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('survey.search') }}"
                class="group relative px-8 py-3 bg-gradient-to-r from-indigo-900 to-indigo-800 rounded-full text-white font-bold shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 overflow-hidden text-sm">
                <span class="relative z-10">ทำแบบสอบถามออนไลน์</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform relative z-10 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            </a>
            <a href="#objectives" class="px-8 py-3 bg-white rounded-full text-slate-700 font-bold border border-slate-200 hover:border-indigo-200 hover:bg-slate-50 hover:text-indigo-900 transition-all flex items-center justify-center shadow-md shadow-slate-100 hover:shadow-lg hover:-translate-y-1 text-sm">
                รายละเอียดเพิ่มเติม
            </a>
        </div>
    </div>
</header>

<section id="objectives" class="py-16 bg-white relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center p-3 bg-indigo-50 rounded-xl mb-4 shadow-sm rotate-3 transform transition-transform hover:rotate-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                </svg>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">วัตถุประสงค์ของการเก็บรวบรวมข้อมูล</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-indigo-600 to-amber-400 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="prose prose-base text-slate-600 mx-auto text-justify leading-relaxed">
            <p class="mb-6 indent-8 font-light text-base">
                <strong class="text-indigo-900 font-bold">สำนักงานสถิติแห่งชาติ</strong> สำนักงานสถิติแห่งชาติ ได้จัดทำการสำรวจธุรกิจทางการค้าและธุรกิจทางการบริการ มาตั้งแต่ปี 2511 โดยจัดทำเป็นประจำทุก 2 ปี เพื่อเก็บรวบรวมข้อมูลพื้นฐานเกี่ยวกับการประกอบธุรกิจทางการค้าและธุรกิจทางการบริการ ได้แก่ จำนวนคนทำงาน ลูกจ้าง ค่าตอบแทนแรงงาน รายได้และค่าใช้จ่ายจากการดำเนินงาน เป็นต้น
            </p>
            <p class="indent-8 font-light text-base">
                ซึ่งการสำรวจนี้ คุ้มรวมสถานประกอบการธุรกิจที่มีคนทำงานตั้งแต่ 1 คนขึ้นไป ที่ดำเนินธุรกิจเกี่ยวกับการขายส่ง ขายปลีก ที่พักแรม การบริการด้านอาหารและเครื่องดื่ม ข้อมูลข่าวสารและการสื่อสาร กิจกรรมอสังหาริมทรัพย์ กิจกรรมทางวิชาชีพ วิทยาศาสตร์และเทคนิค กิจกรรมการบริหารและการบริการสนับสนุน ศิลปะ ความบันเทิงและนันทนาการ และกิจกรรมบริการด้านอื่น ๆ ทั่วประเทศ เพื่อให้ประเทศไทยมีข้อมูลสถิติที่สำคัญ ซึ่งทุกภาคส่วนสามารถใช้ประโยชน์ในการวางแผนพัฒนาประเทศร่วมกัน
            </p>
        </div>
    </div>
</section>

<section id="benefits" class="py-16 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent opacity-50"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900">ประโยชน์ของข้อมูล</h2>
            <p class="text-slate-500 mt-2 text-base font-light">ข้อมูลที่ได้จะถูกนำไปใช้เพื่อการพัฒนาในทุกภาคส่วน</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-lg shadow-indigo-100/50 hover:shadow-xl hover:shadow-indigo-200/50 hover:-translate-y-1 transition-all duration-300 border border-slate-100 relative group overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-indigo-300"></div>
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                        <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                        <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                        <path d="M10 6h4" />
                        <path d="M10 10h4" />
                        <path d="M10 14h4" />
                        <path d="M10 18h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-indigo-700 transition-colors">ภาครัฐ</h3>
                <p class="text-slate-600 text-sm leading-6 font-light">
                    เป็นข้อมูลในการวางแผนและกำหนดนโยบายด้านธุรกิจทางการค้า ธุรกิจทางบริการ จัดทำแผนส่งเสริมวิสาหกิจขนาดกลางและขนาดย่อม (SMEs) ใช้ในการจัดทำบัญชีประชาชาติ ใช้ประกอบการพิจารณาจัดหาโครงสร้างพื้นฐานเพื่อสนับสนุนธุรกิจ รวมทั้งใช้ในการวิเคราะห์สถานการณ์การเปลี่ยนแปลง และการคาดการณ์แนวโน้มในอนาคตของการดำเนินธุรกิจทางการค้าและบริการของประเทศ
                </p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg shadow-amber-100/50 hover:shadow-xl hover:shadow-amber-200/50 hover:-translate-y-1 transition-all duration-300 border border-slate-100 relative group overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-amber-300"></div>
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="20" x2="12" y2="10" />
                        <line x1="18" y1="20" x2="18" y2="4" />
                        <line x1="6" y1="20" x2="6" y2="16" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-amber-600 transition-colors">ภาคเอกชน</h3>
                <p class="text-slate-600 text-sm leading-6 font-light">
                    เป็นข้อมูลสำหรับผู้ประกอบการในการวางแผนธุรกิจ การตัดสินใจลงทุน ขยายกิจการ ขยายสาขา รวมทั้งการบริหารและการดำเนินกิจการด้านต่าง ๆ มีประสิทธิภาพยิ่งขึ้น
                </p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg shadow-emerald-100/50 hover:shadow-xl hover:shadow-emerald-200/50 hover:-translate-y-1 transition-all duration-300 border border-slate-100 relative group overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-300"></div>
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors">ภาคประชาชน</h3>
                <p class="text-slate-600 text-sm leading-6 font-light">
                    เป็นข้อมูลประกอบการตัดสินใจในการลงทุน การศึกษาวิเคราะห์เชิงลึกในธุรกิจที่อยู่ในความสนใจ และเรื่องที่เกี่ยวข้อง
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-b from-white to-indigo-50/50 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 relative z-10">
            <div class="inline-flex items-center justify-center p-3 bg-white rounded-full mb-4 shadow-lg shadow-indigo-100 border border-indigo-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z" />
                    <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z" />
                    <path d="M7 21h10" />
                    <path d="M12 3v18" />
                    <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2" />
                </svg>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight leading-tight">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-900 via-slate-800 to-indigo-900">
                    การรักษาความลับของผู้ให้ข้อมูล
                </span>
            </h2>
            <div class="flex items-center justify-center gap-3 mt-4">
                <div class="h-px w-12 bg-gradient-to-r from-transparent to-amber-400"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
                <div class="h-px w-12 bg-gradient-to-l from-transparent to-amber-400"></div>
            </div>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border-l-[4px] border-amber-400 mb-10 group hover:shadow-xl transition-all duration-500 overflow-hidden">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 bg-amber-50 rounded-full blur-3xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
            <h3 class="text-lg font-bold text-indigo-900 mb-3 flex items-center gap-3 relative z-10">
                <div class="p-2 bg-indigo-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 21h8a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2h-3" />
                        <path d="M15 15h-1a2 2 0 0 0-2 2 2 2 0 0 0 2 2h1" />
                        <path d="M15 21V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v18" />
                        <path d="M8 11h.01" />
                        <path d="M8 7h.01" />
                    </svg>
                </div>
                การรักษาความลับข้อมูลของผู้ตอบแบบสอบถาม
            </h3>
            <p class="text-slate-600 text-base leading-relaxed text-justify indent-8 font-light relative z-10">
                สำนักงานสถิติแห่งชาติ ขอยืนยันให้ท่านมั่นใจในการเก็บรักษาความลับของข้อมูลที่ท่านให้มา ซึ่งเป็นข้อมูลส่วนบุคคล หรือข้อมูลรายกิจการ โดยสำนักงานสถิติแห่งชาติจะนำมาประมวลเป็นค่าสถิติต่าง ๆ เช่น ค่าเฉลี่ย ร้อยละ เพื่อเผยแพร่ ในภาพรวมเท่านั้น
                <strong class="text-indigo-900 font-semibold underline decoration-amber-400/50 decoration-2 underline-offset-4">
                    โดยจะไม่เปิดเผยข้อมูลรายกิจการที่จะทำให้ทราบได้ว่าเป็นสถานประกอบการใดโดยเด็ดขาด
                </strong>
                ซึ่งท่านผู้ให้ข้อมูลจะได้รับความคุ้มครองตามพระราชบัญญัติสถิติ พ.ศ. 2550
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100 hover:shadow-xl hover:border-emerald-100 transition-all duration-500 group">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="m9 15 2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">การคุ้มครองข้อมูล</h3>
                </div>
                <div class="p-6 space-y-6 bg-white relative">
                    <div class="relative z-10">
                        <h4 class="font-bold text-indigo-900 text-sm mb-2 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> มาตรา 15
                        </h4>
                        <div class="text-slate-600 text-sm leading-6 text-justify font-light">
                            บรรดาข้อมูลเฉพาะบุคคล หรือเฉพาะรายที่ได้มาตามพระราชบัญญัตินี้ ต้องถือเป็นความลับ โดยเคร่งครัด ห้ามมิให้ผู้ซึ่งปฏิบัติหน้าที่ตามพระราชบัญญัตินี้หรือผู้มีหน้าที่เก็บรักษาเปิดเผยข้อมูลนั้นแก่บุคคลใด ซึ่งไม่มีหน้าที่ตามพระราชบัญญัตินี้ เว้นแต่
                            <div class="mt-2 bg-emerald-50/50 p-3 rounded-lg border border-emerald-50 text-xs">
                                <span class="block mb-1 font-medium text-emerald-900">
                                    (1) เป็นการเปิดเผยเพื่อประโยชน์แก่การสอบสวนหรือการพิจารณาคดีที่ต้องหาว่ากระทำความผิดตาม พระราชบัญญัตินี้
                                </span>
                                <span class="block font-medium text-emerald-900">
                                    (2) เป็นการเปิดเผยต่อหน่วยงาน เพื่อใช้ประโยชน์ในการจัดทำสถิติ วิเคราะห์หรือวิจัย ทั้งนี้เท่าที่ไม่ก่อให้เกิด ความเสียหายแก่เจ้าของข้อมูล และต้องไม่ระบุหรือเปิดเผยถึงเจ้าของข้อมูล
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-indigo-900 text-sm mb-2 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> มาตรา 16
                        </h4>
                        <p class="text-slate-600 text-sm leading-6 text-justify font-light">
                            ภายใต้บังคับมาตรา 14 และมาตรา 15 ผู้ซึ่งปฏิบัติหน้าที่ในหน่วยงานหรือสำนักงานสถิติแห่งชาติ ต้องไม่นำบรรดาข้อมูลเฉพาะบุคคลหรือเฉพาะรายที่เจ้าของข้อมูลได้ให้ไว้หรือกรอกแบบสอบถามไปใช้ในกิจการอื่น นอกเหนือจากการจัดทำสถิติวิเคราะห์หรือวิจัย
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100 hover:shadow-xl hover:border-amber-100 transition-all duration-500 group">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="p-2 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">การให้ข้อมูล/ตอบแบบสอบถาม</h3>
                </div>
                <div class="p-6 space-y-6 bg-white relative">
                    <div class="relative z-10">
                        <h4 class="font-bold text-slate-800 text-sm mb-1">มาตรา 18</h4>
                        <div class="text-slate-600 text-sm leading-relaxed font-light">
                            ผู้ใดไม่ให้ข้อมูล หรือไม่กรอกแบบสอบถามตามวิธีการที่กำหนดในประกาศตามมาตรา 10 หรือไม่ส่งคืนแบบสอบถามที่ได้กรอกรายการแล้วแก่พนักงานเจ้าหน้าที่หรือหน่วยงานภายในระยะเวลาที่กำหนดใน ประกาศตามมาตรา 10 (4) หรือไม่ให้ความสะดวกแก่พนักงานเจ้าหน้าที่ในการปฏิบัติหน้าที่ตามมาตรา 12 ต้องระวางโทษ ปรับไม่เกินสามพันบาท
                        </div>
                    </div>
                    <div class="w-full h-px bg-slate-100"></div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-slate-800 text-sm mb-1">มาตรา 19</h4>
                        <div class="text-slate-600 text-sm leading-relaxed font-light">
                            ผู้ใดซึ่งมีหน้าที่ให้ข้อมูลตามมาตรา 11 แต่จงใจให้ข้อมูลเป็นเท็จ ต้องระวางโทษจำคุกไม่เกินสามเดือน หรือปรับไม่เกินห้าพันบาท หรือทั้งจำทั้งปรับ
                        </div>
                    </div>
                    <div class="w-full h-px bg-slate-100"></div>
                    <div class="relative z-10">
                        <h4 class="font-bold text-slate-800 text-sm mb-1">มาตรา 20</h4>
                        <div class="text-slate-600 text-sm leading-relaxed font-light">
                            ผู้ใดฝ่าฝืนมาตรา 15 หรือมาตรา 16 ต้องระวางโทษจำคุกไม่เกินหนึ่งปี หรือปรับไม่เกินสองหมื่นบาท หรือทั้งจำทั้งปรับ
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center bg-gradient-to-r from-slate-900 to-indigo-900 p-8 rounded-[2rem] shadow-xl shadow-indigo-900/20 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-24 h-24 bg-white opacity-5 rounded-full -ml-8 -mt-8"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-amber-500 opacity-10 rounded-full -mr-16 -mb-16 blur-xl"></div>

            <p class="text-white/90 text-base md:text-lg font-extrabold leading-loose max-w-4xl mx-auto italic relative z-10">
                <span class="text-4xl text-amber-400 absolute -top-4 -left-2 font-serif leading-none">"</span>
                สำนักงานสถิติแห่งชาติ หวังเป็นอย่างยิ่งว่าจะได้รับความร่วมมือจากผู้ประกอบการทุกท่านในการให้ข้อมูล ที่ถูกต้องเพื่อให้ประเทศมีข้อมูลสถิติที่เป็นจริง ในการกำหนดนโยบาย การวางแผน และการส่งเสริมการดำเนินงาน ทั้งภาครัฐและเอกชน ซึ่งจะส่งผลให้ธุรกิจรุ่งเรือง เศรษฐกิจชาติก้าวไกล
                <span class="text-4xl text-amber-400 absolute -bottom-8 -right-1 font-serif leading-none">"</span>
            </p>
        </div>

    </div>
</section>

<section class="py-12 bg-slate-900 text-white relative border-t border-slate-800">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="inline-flex items-center justify-center p-3 bg-white/5 rounded-full mb-6 border border-white/10 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                <path d="m9 12 2 2 4-4" />
            </svg>
        </div>
        <h2 class="text-xl md:text-2xl font-bold mb-6 tracking-wide">อำนาจหน้าที่ในการเก็บรวบรวมข้อมูล</h2>
        <div class="bg-white/5 p-8 rounded-2xl border border-white/10 backdrop-blur-md shadow-xl relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-1 bg-amber-500 rounded-full"></div>
            <p class="text-indigo-50 text-base leading-loose indent-10 font-light">
                สำนักงานสถิติแห่งชาติดำเนินการจัดทำสำมะโน โดยอาศัยอำนาจตามพระราชบัญญัติสถิติ พ.ศ. 2550 จึงใคร่ขอความร่วมมือจากท่านในการสละเวลาตอบข้อถามที่เป็นข้อมูลของการดำเนินกิจการ และขอให้ความมั่นใจว่าข้อความหรือข้อมูลที่บันทึกในแบบข้อถามนี้ สำนักงานสถิติแห่งชาติจะเก็บไว้เป็นความลับอย่างเคร่งครัดโดยจะไม่นำไปเปิดเผยเป็นรายกิจการ แต่จะนำไปประมวลผลและนำเสนอในลักษณะภาพรวมเท่านั้น และไม่เกี่ยวข้องกับการเรียกเก็บภาษีใด ๆ
            </p>
            <div class="mt-6 pt-4 border-t border-white/5 text-amber-400 font-semibold tracking-wide text-sm">
                สำนักงานสถิติแห่งชาติ หวังเป็นอย่างยิ่งว่าคงได้รับความร่วมมือจากท่านเป็นอย่างดีและขอแสดงความขอบคุณมา ณ โอกาสนี้ด้วย
            </div>
        </div>
    </div>
</section>

<footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-8">
            <div class="space-y-4">
                <h4 class="text-white font-bold text-base flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    ที่อยู่ไปรษณีย์
                </h4>
                <div class="w-8 h-1 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full"></div>
                <p class="text-sm leading-6 font-light">
                    <strong class="text-white text-sm">สำนักงานสถิติแห่งชาติ</strong> <br />
                    ศูนย์ราชการเฉลิมพระเกียรติ ๘๐ พรรษา <br />
                    อาคาร C ชั้น 5-11<br />
                    ซ.แจ้งวัฒนะ 7 ถ.แจ้งวัฒนะ เขตหลักสี่ กทม. 10210
                </p>
            </div>
            <div class="space-y-4">
                <h4 class="text-white font-bold text-base flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M2 12h20" />
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                    เมนูลัด
                </h4>
                <div class="w-8 h-1 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full"></div>
                <ul class="space-y-2 text-sm font-light">
                    <li>
                        <a href="#" class="flex items-center gap-2 hover:text-amber-400 transition-colors hover:translate-x-1 duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                            หน้าหลัก
                        </a>
                    </li>
                    <li>
                        <button onclick="document.getElementById('login-modal').classList.remove('hidden')" class="flex items-center gap-2 hover:text-amber-400 transition-colors hover:translate-x-1 duration-300 text-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                            สำหรับเจ้าหน้าที่
                        </button>
                    </li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="text-white font-bold text-base flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    ติดต่อเรา
                </h4>
                <div class="w-8 h-1 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full"></div>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-3 group">
                        <div class="bg-slate-900 p-2 rounded-lg border border-slate-800 group-hover:border-indigo-500/50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </div>
                        <a href="https://www.nso.go.th" target="_blank" class="hover:text-amber-400 transition-colors text-slate-300">www.nso.go.th</a>
                    </li>
                    <li class="flex items-center gap-3 group">
                        <div class="bg-slate-900 p-2 rounded-lg border border-slate-800 group-hover:border-emerald-500/50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <a href="tel:021421234" class="hover:text-amber-400 transition-colors text-slate-300">0 2142 1234</a>
                    </li>
                    <li class="flex items-center gap-3 group">
                        <div class="bg-slate-900 p-2 rounded-lg border border-slate-800 group-hover:border-amber-500/50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </div>
                        <a href="mailto:services@nso.go.th" class="hover:text-amber-400 transition-colors text-slate-300">services@nso.go.th</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
@endsection