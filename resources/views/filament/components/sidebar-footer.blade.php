@php
$user = auth()->user();
@endphp

<div
class="custom-sidebar-footer flex flex-col border-t border-gray-200/50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02] backdrop-blur-sm transition-all duration-300"
  x-data="{
        isFooterOpen: JSON.parse(localStorage.getItem('isFooterOpen') ?? 'false'),
        toggleFooter() {
            this.isFooterOpen = !this.isFooterOpen;
            localStorage.setItem('isFooterOpen', this.isFooterOpen);
        }
    }"
  class="flex flex-col border-t border-gray-200/50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02] backdrop-blur-sm transition-all duration-300">
  

  <div
    x-show="isFooterOpen"
    x-collapse
    style="display: none;"
    class="px-3 pt-4 space-y-2">
    <div
      x-data="{
                theme: localStorage.getItem('theme') || 'system',
                setTheme(val) {
                    this.theme = val;
                    localStorage.setItem('theme', val);
                    document.documentElement.classList.toggle('dark', val === 'dark' || (val === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches));
                    window.dispatchEvent(new CustomEvent('theme-changed', { detail: val }));
                }
            }"
      class="p-1 mb-3 bg-gray-200/50 dark:bg-gray-900/50 rounded-lg ring-1 ring-gray-900/5 dark:ring-white/10">
      <div class="flex items-center justify-between w-full">
        @foreach(['light' => 'sun', 'dark' => 'moon', 'system' => 'computer-desktop'] as $mode => $icon)
        <button
          @click="setTheme('{{ $mode }}')"
          :class="theme === '{{ $mode }}' 
                            ? 'bg-white text-primary-600 shadow-sm dark:bg-gray-800 dark:text-primary-400' 
                            : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
          class="flex-1 flex items-center justify-center py-1.5 rounded-md transition-all duration-200 group"
          title="Tema {{ ucfirst($mode) }}">
          @svg('heroicon-m-'.$icon, 'w-4 h-4 transition-transform group-hover:scale-110')
        </button>
        @endforeach
      </div>
    </div>

    <a
      href="{{\App\Filament\Pages\AppSettings::getUrl()}}"
      class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 rounded-lg hover:bg-gray-100 hover:text-primary-600 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-primary-400 group">
      <div class="flex items-center gap-3">
        <x-heroicon-o-cog-6-tooth class="w-4 h-4 text-gray-400 group-hover:text-primary-500 transition-colors" />
        <span>Pengaturan Aplikasi</span>
      </div>
    </a>
    <a
      href="{{\App\Filament\Pages\AccountSettings::getUrl()}}"
      class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 rounded-lg hover:bg-gray-100 hover:text-primary-600 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-primary-400 group">
      <div class="flex items-center gap-3">
        <x-heroicon-o-cog-6-tooth class="w-4 h-4 text-gray-400 group-hover:text-primary-500 transition-colors" />
        <span>Pengaturan Akun</span>
      </div>
    </a>


    <form action="{{ filament()->getLogoutUrl() }}" method="post">
      @csrf
      <button
        type="submit"
        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-500 transition-all duration-200 rounded-lg hover:bg-red-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-red-500/10 dark:hover:text-red-400 group">
        <div class="flex items-center gap-3">
          <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4 text-gray-400 group-hover:text-red-500 transition-colors" />
          <span>Keluar Aplikasi</span>
        </div>
      </button>
    </form>

    <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-white/10 mt-2"></div>
  </div>

  <button
    @click="toggleFooter()"
    type="button"
    class="flex items-center gap-3 p-3 transition-colors hover:bg-white dark:hover:bg-white/5 group text-start focus:outline-none"
    :class="!$store.sidebar.isOpen && 'justify-center px-0 py-4'">
    <div class="relative shrink-0">
      <x-filament-panels::avatar.user size="md" :user="$user" class="ring-2 ring-white dark:ring-gray-800 shadow-sm transition-transform group-hover:scale-105" />
      <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full shadow-sm"></span>
    </div>

    <div
      x-show="$store.sidebar.isOpen"
      x-transition
      class="flex items-center justify-between flex-1 min-w-0">
      <div class="flex flex-col truncate">
        <span class="text-sm font-bold text-gray-900 truncate dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
          {{ $user->name }}
        </span>
        <span class="text-xs text-gray-500 truncate dark:text-gray-400">
          {{ $user->role ?? 'Administrator' }}
        </span>
      </div>

      <x-heroicon-m-chevron-up
        class="w-4 h-4 text-gray-400 transition-transform duration-300"
        x-bind:class="isFooterOpen && 'rotate-180'" />
    </div>
  </button>
</div>