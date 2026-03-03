<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400&display=swap" rel="stylesheet">

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* 1. Correção do x-cloak para evitar piscar o layout */
    [x-cloak] { display: none !important; }
    
    .font-serif-nostalgia { font-family: 'Playfair Display', serif; }
    .font-sans-modern { font-family: 'Inter', sans-serif; }
    .bg-paper { background-color: #F9F8F6; background-image: radial-gradient(#e5e5e5 1px, transparent 1px); background-size: 20px 20px; }
</style>

<div x-data="{ activePoem: null }" class="min-h-screen bg-paper text-gray-800 font-serif-nostalgia selection:bg-amber-200 selection:text-amber-900">
    
    <div class="max-w-6xl mx-auto p-6 md:p-12 flex flex-col md:flex-row gap-8 lg:gap-24">

        <aside class="w-full md:w-1/3 md:h-screen md:sticky md:top-0 md:pt-12 md:overflow-y-auto scrollbar-hide"
               :class="!activePoem ? 'block' : 'hidden md:block'">
               
            <h1 class="text-4xl md:text-5xl font-bold mb-10 text-gray-900 tracking-tight">
                Casa de conchas
            </h1>
            
            <nav class="space-y-6 relative border-l-2 border-amber-100 pl-6">
                @foreach($posts as $post)
                    <div class="group">
                        <button @click="activePoem = {{ $post->id }}; window.scrollTo({ top: 0, behavior: 'smooth' })"
                                class="text-left w-full transition-all duration-300 flex items-center gap-4 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-4 focus:ring-offset-[#F9F8F6] p-1 -ml-1">

                            @if($post->cover_image)
                                <div class="shrink-0 w-10 h-10 md:w-12 md:h-12 overflow-hidden rounded-full border border-gray-200 shadow-sm transition-transform duration-500 group-hover:scale-105"
                                     :class="activePoem === {{ $post->id }} ? 'ring-2 ring-amber-300 ring-offset-2 ring-offset-[#F9F8F6]' : ''">
                                    <img src="{{ asset('storage/' . $post->cover_image) }}" 
                                         alt="Capa do poema {{ $post->title }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center">
                                </div>
                            @endif

                            <div class="flex flex-col">
                                <h2 class="text-lg md:text-xl font-medium transition-colors duration-300"
                                    :class="activePoem === {{ $post->id }} ? 'text-amber-700 italic' : 'text-gray-600 group-hover:text-amber-600'">
                                    {{ $post->title }}
                                </h2>
                                <small class="font-sans-modern text-xs tracking-widest text-gray-400 uppercase mt-1">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </small>
                            </div>

                        </button>
                    </div>
                @endforeach
            </nav>
        </aside>

        <main class="w-full md:w-2/3 min-h-[60vh] md:pt-12 flex-col relative pb-20"
              :class="activePoem ? 'flex' : 'hidden md:flex'">
            
            <button x-show="activePoem" 
                    @click="activePoem = null; window.scrollTo({ top: 0, behavior: 'smooth' })" 
                    class="md:hidden mb-8 text-amber-700 font-sans-modern text-sm tracking-widest uppercase flex items-center gap-2 hover:text-amber-900 transition-colors w-fit focus:outline-none focus:ring-2 focus:ring-amber-400 rounded-md p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar ao índice
            </button>

            <div x-show="!activePoem" class="hidden md:flex h-full items-center justify-center text-gray-400 italic text-lg opacity-70">
                <p>Selecione um poema para iniciar a leitura...</p>
            </div>

            @foreach($posts as $post)
                <article x-cloak 
                         x-show="activePoem === {{ $post->id }}"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="w-full bg-white/80 backdrop-blur-sm p-8 md:p-16 shadow-[0_4px_40px_-15px_rgba(0,0,0,0.05)] rounded-sm border border-gray-100">
                    
                    <header class="mb-10 text-center md:text-left">
                        <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $post->title }}
                        </h2>
                        <div class="w-12 h-0.5 bg-amber-300 mx-auto md:mx-0 mb-4"></div>

                        @if($post->cover_image)
                            <div class="w-full h-48 md:h-64 mt-6 mb-8 overflow-hidden rounded-md border border-gray-100 shadow-sm">
                                <img src="{{ asset('storage/' . $post->cover_image) }}" 
                                     alt="Banner do poema {{ $post->title }}" 
                                     loading="lazy"
                                     class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-700 ease-in-out">
                            </div>
                        @endif

                    </header>

                    <div class="prose prose-lg prose-amber max-w-none text-gray-700 leading-loose text-lg whitespace-pre-wrap">
                        {!! $post->body ?? $post->content !!}
                    </div>
                </article>
            @endforeach
        </main>

    </div>
</div>