<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'HofraGo') }} - How it works</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">
    <!-- Header -->
    <header class="w-full bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-emerald-600 tracking-tight">
                HofraGo
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-6 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-medium text-slate-600 hover:text-emerald-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-medium text-slate-600 hover:text-emerald-600 transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="font-medium bg-emerald-600 text-white px-5 py-2 rounded-full hover:bg-emerald-700 transition shadow-sm">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-6xl mx-auto px-4 py-12 lg:py-16">

        <!-- Hero Title -->
        <div class="mb-12 text-center lg:text-left">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                Report local issues. <span class="text-emerald-600">Improve your city.</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0">
                Join thousands of citizens working together with local councils to keep our neighborhoods safe, clean,
                and beautiful.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

            <!-- Left Column: How it works & Stats -->
            <div class="lg:col-span-7">
                <h2 class="text-2xl font-bold mb-8 text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    How it works
                </h2>

                <div class="space-y-8 bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-5">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl shadow-sm">
                            1</div>
                        <div class="pt-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Enter the location</h3>
                            <p class="text-slate-600 leading-relaxed">Type in a nearby postcode, street name, or let
                                your device find your current area.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start gap-5">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl shadow-sm">
                            2</div>
                        <div class="pt-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Pinpoint on the map</h3>
                            <p class="text-slate-600 leading-relaxed">Drag the pin to the exact location of the problem
                                so workers know exactly where to go.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-5">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl shadow-sm">
                            3</div>
                        <div class="pt-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Provide the details</h3>
                            <p class="text-slate-600 leading-relaxed">Upload a photo, select a category (like Pothole or
                                Graffiti), and add a short description.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-start gap-5">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl shadow-sm">
                            4</div>
                        <div class="pt-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">We handle the rest</h3>
                            <p class="text-slate-600 leading-relaxed">We automatically route your report to the correct
                                local authority and keep you updated on its progress.</p>
                        </div>
                    </div>
                </div>

                <!-- Emerald Divider Line -->
                <div class="w-full h-1.5 bg-emerald-500 rounded-full my-10 opacity-80"></div>

                <!-- Statistics -->
                <div class="grid grid-cols-3 gap-6 text-center">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <div class="text-3xl lg:text-4xl font-black text-slate-900 mb-2">27k+</div>
                        <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Reports this week
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <div class="text-3xl lg:text-4xl font-black text-slate-900 mb-2">72k+</div>
                        <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Fixed this month</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <div class="text-3xl lg:text-4xl font-black text-slate-900 mb-2">14M</div>
                        <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Total Updates</div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Recent Reports -->
            <div class="lg:col-span-5">
                <h2 class="text-2xl font-bold mb-8 text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Recently reported
                </h2>

                <div class="space-y-4">
                    <!-- Example Report 1 -->
                    <div
                        class="flex items-start gap-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-300 hover:shadow-md transition cursor-pointer group">
                        <div class="flex-1">
                            <h4
                                class="text-base font-bold text-slate-800 group-hover:text-emerald-600 transition mb-1 leading-snug">
                                Large Fly Tip Next to Number 3 Chapel Road
                            </h4>
                            <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-orange-400"></span> Open • Updated today
                            </p>
                        </div>
                        <div class="w-24 h-20 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                            <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=300&q=80"
                                alt="Fly Tip" class="w-full h-full object-cover" />
                        </div>
                    </div>

                    <!-- Example Report 2 -->
                    <div
                        class="flex items-start gap-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-300 hover:shadow-md transition cursor-pointer group">
                        <div class="flex-1">
                            <h4
                                class="text-base font-bold text-slate-800 group-hover:text-emerald-600 transition mb-1 leading-snug">
                                Uneven and damaged paving and tarmac 26-28 Leominster Walk
                            </h4>
                            <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Investigating • Updated today
                            </p>
                        </div>
                        <div class="w-24 h-20 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                            <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?w=300&q=80"
                                alt="Damaged Paving" class="w-full h-full object-cover" />
                        </div>
                    </div>

                    <!-- Example Report 3 -->
                    <div
                        class="flex items-start gap-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-300 hover:shadow-md transition cursor-pointer group">
                        <div class="flex-1">
                            <h4
                                class="text-base font-bold text-slate-800 group-hover:text-emerald-600 transition mb-1 leading-snug">
                                Deep pothole causing damage to vehicles on Main St
                            </h4>
                            <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Fixed • Updated yesterday
                            </p>
                        </div>
                        <div class="w-24 h-20 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                            <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?w=300&q=80"
                                alt="Pothole" class="w-full h-full object-cover" />
                        </div>
                    </div>

                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-4 text-emerald-600 font-bold hover:bg-emerald-50 rounded-xl transition mt-4">
                        View all recent reports &rarr;
                    </a>
                </div>
            </div>

        </div>
    </main>
</body>

</html>
