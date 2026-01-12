<!DOCTYPE html>
<html lang="en" class="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#AA2B1D">
  <link rel="shortcut icon" href="{{ asset('img/RSU.png') }}" type="image/x-icon">
  <title>{{ $pageTitle }}</title>

  @filamentStyles
  @livewireStyles
  @vite(["resources/css/filament/admin/theme.css"])

  <style>
    @font-face {
      font-family: 'SF-Pro';
      src: url('/fonts/SF-Pro.otf');
      font-display: swap;
    }

    :root {
      --font-family: 'SF-Pro', ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
      --bg: #0b1220;
      --card: rgba(255, 255, 255, .92);
      --stroke: rgba(15, 23, 42, .10);
      --shadow: 0 30px 80px rgba(2, 6, 23, .25);
      --shadow2: 0 12px 40px rgba(2, 6, 23, .18);
      --text: rgba(2, 6, 23, .88);
      --muted: rgba(2, 6, 23, .60);
      --accent: #8c7569;
      --accent2: #55311c;
      --radius: 22px;
    }

    html,
    body {
      height: 100%;
    }

    body {
      font-family: var(--font-family);
      background:
        radial-gradient(1000px 600px at 20% 10%, rgba(140, 117, 105, .22), transparent 60%),
        radial-gradient(900px 600px at 80% 15%, rgba(85, 49, 28, .18), transparent 60%),
        radial-gradient(900px 700px at 60% 90%, rgba(59, 130, 246, .10), transparent 60%),
        linear-gradient(180deg, #f8fafc 0%, #eef2ff 60%, #ffffff 100%);
      background-attachment: fixed;
      color: var(--text);
    }

    .dark body {
      color: rgba(255, 255, 255, .92);
      background:
        radial-gradient(1000px 600px at 20% 10%, rgba(140, 117, 105, .18), transparent 60%),
        radial-gradient(900px 600px at 80% 15%, rgba(85, 49, 28, .15), transparent 60%),
        radial-gradient(900px 700px at 60% 90%, rgba(59, 130, 246, .10), transparent 60%),
        linear-gradient(180deg, #070a12 0%, #0b1220 60%, #0f172a 100%);
    }

    .auth-shell {
      width: min(1100px, 100%);
      border-radius: calc(var(--radius) + 8px);
      overflow: hidden;
      box-shadow: var(--shadow);
      border: 1px solid rgba(255, 255, 255, .25);
      background: rgba(255, 255, 255, .04);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      position: relative;
    }

    .dark .auth-shell {
      border-color: rgba(148, 163, 184, .16);
      box-shadow: 0 40px 120px rgba(0, 0, 0, .55);
      background: rgba(255, 255, 255, .03);
    }

    .auth-hero {
      position: relative;
      min-height: 520px;
      background: #111827;
    }

    .auth-hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: scale(1.08);
      filter: saturate(1.05) contrast(1.05);
      transition: transform 1.2s ease;
    }

    .auth-shell:hover .auth-hero img {
      transform: scale(1);
    }

    .auth-hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0, 0, 0, .08), rgba(0, 0, 0, .62));
      pointer-events: none;
    }

    .hero-caption {
      position: absolute;
      left: 22px;
      right: 22px;
      bottom: 20px;
      color: rgba(255, 255, 255, .92);
    }

    .hero-caption .title {
      font-weight: 700;
      letter-spacing: .3px;
      font-size: 20px;
    }

    .hero-caption .sub {
      margin-top: 6px;
      font-size: 13px;
      color: rgba(255, 255, 255, .72);
    }

    .auth-panel {
      background: var(--card);
      color: var(--text);
      border-left: 1px solid rgba(15, 23, 42, .08);
      padding: 46px 38px;
      transform: translateY(22px);
      opacity: 0;
      animation: panelIn .65s ease forwards;
    }

    @keyframes panelIn {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .dark .auth-panel {
      background: rgba(15, 23, 42, .55);
      border-left-color: rgba(148, 163, 184, .16);
      color: rgba(255, 255, 255, .92);
    }

    .theme-toggle {
      position: absolute;
      top: 16px;
      right: 16px;
      z-index: 20;
      border-radius: 999px;
      padding: 10px 12px;
      background: rgba(255, 255, 255, .85);
      border: 1px solid rgba(15, 23, 42, .10);
      box-shadow: var(--shadow2);
      transition: transform .15s ease, background .15s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .theme-toggle:hover {
      transform: translateY(-1px);
    }

    .dark .theme-toggle {
      background: rgba(15, 23, 42, .55);
      border-color: rgba(148, 163, 184, .18);
    }

    .fi-section,
    .fi-card,
    .fi-input-wrp,
    .fi-select-input,
    .fi-fo-file-upload-input-ctn,
    .fi-btn,
    .fi-icon-btn {
      border-radius: 14px !important;
    }

    .fi-input-wrp {
      border: 1px solid rgba(15, 23, 42, .14) !important;
      background: rgba(255, 255, 255, .92) !important;
      transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .dark .fi-input-wrp {
      background: rgba(2, 6, 23, .20) !important;
      border-color: rgba(148, 163, 184, .18) !important;
    }

    .fi-input-wrp:focus-within {
      border-color: rgba(140, 117, 105, .75) !important;
      box-shadow: 0 0 0 4px rgba(140, 117, 105, .18);
      transform: translateY(-1px);
    }

    .fi-fo-field-wrp-label,
    .fi-fo-field-wrp-label span {
      font-size: 11px !important;
      letter-spacing: .08em !important;
      text-transform: uppercase !important;
      font-weight: 700 !important;
      color: rgba(140, 117, 105, .95) !important;
    }

    .dark .fi-fo-field-wrp-label,
    .dark .fi-fo-field-wrp-label span {
      color: rgba(140, 117, 105, .90) !important;
    }

    .fi-btn {
      background: green !important;
      color: #000 !important;
      border: 0 !important;
      box-shadow: 0 18px 45px rgba(85, 49, 28, .28) !important;
      transition: transform .15s ease, filter .15s ease, box-shadow .15s ease !important;
    }

    .fi-btn:hover {
      transform: translateY(-1px);
      filter: saturate(2.05);
      box-shadow: 0 24px 60px rgba(85, 49, 28, .32) !important;
    }

    @media (max-width: 1024px) {
      .auth-hero {
        display: none;
      }

      .auth-panel {
        border-left: 0;
        padding: 42px 26px;
      }
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 md:px-10 py-10">
  <div
    x-data="{
      dark: localStorage.getItem('theme') === 'dark',
      toggleTheme() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.dark);
      }
    }"
    x-init="document.documentElement.classList.toggle('dark', dark)"
    class="w-full flex items-center justify-center">
    <div class="auth-shell grid grid-cols-1 lg:grid-cols-5">
      <button @click="toggleTheme" class="theme-toggle" aria-label="Toggle theme">
        <x-heroicon-o-sun x-show="!dark" class="w-5 h-5 text-amber-500" />
        <x-heroicon-o-moon x-show="dark" class="w-5 h-5 text-white" />
        <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 hidden sm:block">
          <span x-show="!dark">Light</span><span x-show="dark">Dark</span>
        </span>
      </button>

      <div class="auth-hero hidden lg:block lg:col-span-2">
        <img src="{{ asset('img/rsu.jpg') }}" alt="Hero">
        <div class="hero-caption">
          <div class="title">SIMAKES</div>
          <div class="sub">Inventaris & Maintenance • Alat Kesehatan</div>
        </div>
      </div>

      <div class="auth-panel lg:col-span-3 flex items-center justify-center">
        <div class="w-full max-w-md">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>

  @livewire('notifications')
  @filamentScripts
  @livewireScripts
</body>

</html>