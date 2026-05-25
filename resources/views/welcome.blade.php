@extends('layouts.app')

@section('title', 'AgriMarket')

@section('content')
<style>

    .full-bleed-container {
        width: 100vw !important;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        background-color: #fcfbf7;
    }
    @keyframes floatElement {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }
    @keyframes pulseLive {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.5; }
    }
    .animate-float {
        animation: floatElement 4s ease-in-out infinite;
    }
    .animate-live-dot {
        animation: pulseLive 2s ease-in-out infinite;
    }
</style>

<div class="full-bleed-container min-h-[calc(100vh-70px)] flex flex-col font-sans text-slate-900 antialiased selection:bg-emerald-500 selection:text-white mt-0">
    
    <main class="w-full flex-1 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center py-12 px-8 md:px-16 lg:px-24 relative overflow-hidden">
        
        <div class="absolute inset-0 pointer-events-none opacity-40 mix-blend-multiply z-0">
            <div class="absolute top-12 left-10 w-96 h-96 bg-emerald-200/30 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-lime-200/40 rounded-full filter blur-3xl"></div>
        </div>

        <div class="lg:col-span-5 space-y-8 relative z-10">
            <div class="inline-flex items-center space-x-2 bg-emerald-50 border border-emerald-100 px-3.5 py-1.5 rounded-full shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-live-dot"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Direct Crop Trade Platform</span>
            </div>
            
            <div class="space-y-4">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.1]">
                    Welcome to <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-700 via-emerald-600 to-lime-600">AgriMarket</span>
                </h1>
                <p class="text-slate-600 text-lg sm:text-xl leading-relaxed max-w-xl font-medium">
                    Farmers list crops, buyers purchase directly, mandi rates guide pricing, and live alerts keep deals moving forward. Simple, transparent, and profitable.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-extrabold rounded-xl shadow-xl shadow-emerald-600/20 transform hover:-translate-y-1 transition duration-200 flex items-center space-x-2">
                    <span>Create Free Account</span>
                    <span class="text-lg">→</span>
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white hover:bg-slate-50 text-slate-800 font-bold rounded-xl transform hover:-translate-y-1 transition duration-200 border border-slate-200/80 shadow-sm">
                    Login
                </a>
            </div>

            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-200/60">
                <div>
                    <p class="text-2xl font-black text-slate-900">Cloud</p>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mt-1">MongoDB Ready</p>
                </div>
                <div>
                    <p class="text-2xl font-black text-slate-900">2 Roles</p>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mt-1">Farmer & Buyer</p>
                </div>
                
            </div>
        </div>

        <div class="lg:col-span-7 relative w-full z-10 flex flex-col items-center">
            
            <div class="w-full max-w-2xl bg-slate-900/5 p-3 rounded-[2.5rem] shadow-2xl shadow-emerald-950/10 border border-white">
                <div class="w-full bg-white rounded-[2rem] overflow-hidden shadow-md flex flex-col">
                    
                    <div class="w-full h-[280px] bg-cover bg-center relative group" style="background-image: url('https://subsistencefarming.in/wp-content/uploads/2026/01/farmer_portal.jpg');">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                        
                        <div class="absolute top-4 right-4 bg-emerald-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-md flex items-center space-x-1.5 animate-float">
                            <span class="w-1.5 h-1.5 rounded-full bg-white inline-block animate-pulse"></span>
                            <span>Verified Mandi Partner</span>
                        </div>

                        <div class="absolute bottom-6 left-6 text-white">
                            <p class="text-xs font-bold uppercase tracking-widest text-emerald-300">Direct From Source</p>
                            <h3 class="text-2xl font-black tracking-tight mt-0.5">Empowering Local Agritech</h3>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex flex-col space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                📊 Live Mandi Signals
                            </h4>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Updating Live
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-xl border border-slate-200/60 shadow-sm hover:border-emerald-300 transition duration-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-800">Potato</span>
                                    <span class="text-xs text-emerald-600 font-bold">▲ +2%</span>
                                </div>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">Lucknow Mandi</p>
                                <p class="text-lg font-black text-slate-900 mt-2">₹24 <span class="text-xs font-normal text-slate-500">/ kg</span></p>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-slate-200/60 shadow-sm hover:border-emerald-300 transition duration-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-800">Cotton</span>
                                    <span class="text-xs text-emerald-600 font-bold">▲ +5%</span>
                                </div>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">Rajkot APMC</p>
                                <p class="text-lg font-black text-slate-900 mt-2">₹7,240 <span class="text-xs font-normal text-slate-500">/ qtl</span></p>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-slate-200/60 shadow-sm hover:border-emerald-300 transition duration-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-800">Basmati Rice</span>
                                    <span class="text-xs text-slate-500 font-bold">Stable</span>
                                </div>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">Karnal Mandi</p>
                                <p class="text-lg font-black text-slate-900 mt-2">₹4,720 <span class="text-xs font-normal text-slate-500">/ qtl</span></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

</div>
@endsection