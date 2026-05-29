<div class="w-full lg:w-[700px] 2xl:w-[800px]">
    <p class="font-semibold text-[28px] md:text-[48px] text-center text-white mb-0">
        {{ number_format($currentUserPoints) }} PTS
    </p>
    <h2 class="relative font-bold text-[48px] md:text-[70px] 2xl:text-[80px] text-center title-stroke tracking-wider mb-3">
        CLASIFICACIÓN:
        <span class="title-stroke-white">{{ $currentUserPosition }}</span>
    </h2>
    <p class="font-black text-[25px] md:text-[40px] text-center text-white mb-8 flex flex-col md:flex-row justify-center items-center">
        TERMINA EN
        <span class="block w-[250px] bg-yellow text-black rounded-full md:ml-3">17:20:45</span>
    </p>

    <div class="w-full max-w-3xl bg-[#ECECEC] rounded-2xl shadow-lg p-6">
        <!-- Scroll -->
        <div class="max-h-[500px] overflow-y-auto pr-2">
            <div class="space-y-3">
                @foreach ($ranking as $key => $item)
                    <div class="flex items-center text-[#1D1D1D] font-extrabold uppercase italic">
                        <!-- Posición -->
                        <span class="w-8 text-[#0A6B4A] text-lg">
                            {{ $key+1 }}
                        </span>

                        <!-- Nombre -->
                        <span class="whitespace-nowrap text-lg">
                            {{ $item->first_name . ' ' . $item->last_name }}
                        </span>

                        <!-- Línea -->
                        <div class="flex-1 border-b border-dashed border-gray-500 mx-3 mt-3"></div>

                        <!-- Puntaje -->
                        <span class="whitespace-nowrap text-lg">
                            {{ number_format($item->total_points) }}
                        </span>

                        <!-- PTS -->
                        <span class="ml-3 text-lg">
                            PTS
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
