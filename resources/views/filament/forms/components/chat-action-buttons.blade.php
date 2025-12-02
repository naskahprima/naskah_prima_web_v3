<div 
    x-data="{
        copied: false,
        loading: false,
        
        copyMessage() {
            const textarea = this.$el.closest('.fi-modal').querySelector('textarea');
            if (!textarea || !textarea.value) {
                alert('❌ Pesan tidak ditemukan!');
                return;
            }
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(textarea.value)
                    .then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    })
                    .catch(() => this.fallbackCopy(textarea.value));
            } else {
                this.fallbackCopy(textarea.value);
            }
        },
        
        fallbackCopy(text) {
            const temp = document.createElement('textarea');
            temp.value = text;
            temp.style.position = 'fixed';
            temp.style.left = '-999999px';
            document.body.appendChild(temp);
            temp.select();
            try {
                document.execCommand('copy');
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            } catch (err) {
                alert('❌ Gagal menyalin');
            }
            document.body.removeChild(temp);
        },
        
        openWhatsApp(phone) {
            const textarea = this.$el.closest('.fi-modal').querySelector('textarea');
            if (!textarea || !textarea.value) {
                alert('❌ Pesan tidak ditemukan!');
                return;
            }
            
            this.loading = true;
            const message = encodeURIComponent(textarea.value);
            
            setTimeout(() => {
                window.location.href = 'whatsapp://send?phone=' + phone + '&text=' + message;
                this.loading = false;
            }, 300);
        }
    }"
    class="space-y-3"
>
    <!-- Success Toast - FIXED VERSION -->
    {{-- <div 
        x-show="copied"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed top-20 right-4 z-[9999] pointer-events-none"
        style="display: none;"
    >
        <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 min-w-[280px] backdrop-blur-sm border border-emerald-400/50">
            <!-- Icon dengan animasi -->
            <div class="flex-shrink-0 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <!-- Text -->
            <div class="flex-1">
                <p class="text-sm font-bold">Berhasil!</p>
                <p class="text-xs opacity-90">Pesan telah disalin ke clipboard</p>
            </div>
        </div>
    </div> --}}

    <!-- Action Buttons -->
    <div class="flex gap-2.5">
        @if($hasWhatsapp)
        <!-- WhatsApp Button -->
        <button 
            type="button"
            @click="openWhatsApp('{{ $phone }}')"
            :disabled="loading"
            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3
                   bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700
                   text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl
                   transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]
                   disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:scale-100
                   focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2
                   focus:ring-offset-gray-900"
        >
            <!-- Loading Spinner -->
            <svg 
                x-show="loading" 
                class="animate-spin w-5 h-5"
                style="display: none;"
                fill="none" 
                viewBox="0 0 24 24"
            >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            
            <!-- WhatsApp Icon -->
            <svg 
                x-show="!loading"
                class="w-5 h-5 transition-transform hover:rotate-6" 
                fill="currentColor" 
                viewBox="0 0 24 24"
            >
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            
            <span x-text="loading ? 'Membuka WhatsApp...' : 'Buka WhatsApp'"></span>
        </button>
        @endif
        
        <!-- Copy Button -->
        <button 
            type="button"
            @click="copyMessage()"
            class="inline-flex items-center justify-center gap-2 px-4 py-3
                   text-sm font-semibold rounded-lg border-2 shadow-md hover:shadow-lg
                   transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]
                   focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2
                   focus:ring-offset-gray-900
                   {{ $hasWhatsapp ? 'min-w-[140px]' : 'flex-1' }}"
            :class="copied ? 
                'bg-emerald-500 border-emerald-500 text-white' : 
                'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-gray-50 dark:hover:bg-gray-600'"
        >
            <svg 
                class="w-5 h-5 transition-transform duration-200"
                :class="copied ? 'scale-110' : ''"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
                stroke-width="2.5"
            >
                <path 
                    x-show="!copied"
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                ></path>
                <path 
                    x-show="copied"
                    style="display: none;"
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M5 13l4 4L19 7"
                ></path>
            </svg>
            
            <span x-text="copied ? 'Tersalin!' : 'Copy Pesan'"></span>
        </button>
    </div>
    
    <!-- Info Badge -->
    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800/50 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <span>WhatsApp Desktop harus terinstall untuk membuka langsung</span>
    </div>
</div>