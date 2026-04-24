<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    ::-webkit-scrollbar {
      display: none;
    }

    html {
      scrollbar-width: none;
    }

    @keyframes floatGlow {
      0%, 100% {
        transform: translate3d(0, 0, 0) scale(1);
        opacity: 0.55;
      }
      50% {
        transform: translate3d(18px, -14px, 0) scale(1.08);
        opacity: 0.9;
      }
    }

    @keyframes driftSlow {
      0% { transform: translate3d(0, 0, 0) rotate(0deg); }
      50% { transform: translate3d(-16px, 12px, 0) rotate(6deg); }
      100% { transform: translate3d(0, 0, 0) rotate(0deg); }
    }

    .glow-blob {
      position: absolute;
      border-radius: 9999px;
      filter: blur(42px);
      pointer-events: none;
      animation: floatGlow 8s ease-in-out infinite;
    }

    .glow-blob-secondary {
      animation: driftSlow 11s ease-in-out infinite;
    }

    @keyframes pulseRing {
      0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.35);
      }
      50% {
        transform: scale(1.04);
        box-shadow: 0 0 0 12px rgba(249, 115, 22, 0);
      }
    }

    .pulse-ring {
      animation: pulseRing 2.4s ease-in-out infinite;
    }

    @keyframes cubeFloat {
      0% {
        transform: translate3d(0, 0, 0) rotate(0deg) scale(1);
        opacity: 0.18;
      }
      25% {
        transform: translate3d(18px, -28px, 0) rotate(20deg) scale(1.04);
        opacity: 0.32;
      }
      50% {
        transform: translate3d(-10px, -48px, 0) rotate(45deg) scale(1.08);
        opacity: 0.22;
      }
      75% {
        transform: translate3d(-22px, -18px, 0) rotate(70deg) scale(1.03);
        opacity: 0.3;
      }
      100% {
        transform: translate3d(0, 0, 0) rotate(90deg) scale(1);
        opacity: 0.18;
      }
    }

    .cube-bg {
      position: absolute;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.22);
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.22), rgba(251, 191, 36, 0.28));
      box-shadow: 0 0 32px rgba(251, 191, 36, 0.22);
      pointer-events: none;
      animation: cubeFloat 10s ease-in-out infinite;
      backdrop-filter: blur(2px);
    }
  </style>
</head>
<body class="relative min-h-screen bg-black text-white flex items-center justify-center px-4 py-4 overflow-hidden">
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="cube-bg w-10 h-10 top-8 left-8" style="animation-delay: 0s;"></div>
    <div class="cube-bg w-6 h-6 top-24 left-24" style="animation-delay: -1.5s;"></div>
    <div class="cube-bg w-12 h-12 top-16 right-14" style="animation-delay: -2.8s;"></div>
    <div class="cube-bg w-5 h-5 top-40 right-1/3" style="animation-delay: -4.2s;"></div>
    <div class="cube-bg w-8 h-8 top-1/4 right-1/4" style="animation-delay: -6.8s;"></div>
    <div class="cube-bg w-5 h-5 top-1/3 left-1/4" style="animation-delay: -1.2s;"></div>
    <div class="cube-bg w-11 h-11 top-3/4 left-10" style="animation-delay: -7.4s;"></div>
    <div class="cube-bg w-8 h-8 bottom-24 left-16" style="animation-delay: -4s;"></div>
    <div class="cube-bg w-14 h-14 bottom-14 right-20" style="animation-delay: -5.5s;"></div>
    <div class="cube-bg w-7 h-7 top-1/2 left-1/2" style="animation-delay: -3.7s;"></div>
    <div class="cube-bg w-9 h-9 bottom-1/3 left-1/3" style="animation-delay: -6.2s;"></div>
    <div class="cube-bg w-4 h-4 top-16 left-1/2" style="animation-delay: -2.1s;"></div>
    <div class="cube-bg w-6 h-6 bottom-10 left-1/2" style="animation-delay: -8.1s;"></div>
    <div class="cube-bg w-10 h-10 top-10 right-1/2" style="animation-delay: -4.9s;"></div>
    <div class="cube-bg w-5 h-5 bottom-1/4 right-8" style="animation-delay: -2.7s;"></div>
    <div class="cube-bg w-7 h-7 top-2/3 right-1/3" style="animation-delay: -9s;"></div>
  </div>
  <div class="relative z-10 w-full max-w-2xl rounded-3xl overflow-hidden border border-white/10 bg-gradient-to-br from-black via-gray-900 to-gray-800 shadow-[0_0_60px_rgba(0,0,0,0.65)]">
    <div class="glow-blob glow-blob-secondary top-[-40px] left-[-40px] w-40 h-40 bg-orange-500/25"></div>
    <div class="glow-blob bottom-[-50px] right-[-30px] w-44 h-44 bg-amber-400/20" style="animation-delay: -3s;"></div>
    <div class="relative p-6 md:p-8 text-center">
      <div class="flex items-center justify-start mb-4">
        <img src="https://aerthh.com/storage/app/public/company/2025-03-26-67e3da8f9b411.webp" alt="Aerthh Logo" class="w-14 h-14 rounded-2xl border border-white/10 shadow-lg shadow-black/40 object-cover">
      </div>

      <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center pulse-ring">
        <i class="fa-solid fa-circle-check text-3xl text-orange-400"></i>
      </div>

      <p class="text-xs uppercase tracking-[0.28em] text-orange-400 mb-2">Thank You for Joining</p>
      <h1 class="text-2xl md:text-3xl font-bold leading-tight mb-3">Your vendor account has been created successfully.</h1>
      <p class="text-gray-300 text-sm md:text-base leading-relaxed max-w-xl mx-auto">
        Your account is currently pending review. The admin team will verify your details first, and once approved, you will be able to log in and access your vendor dashboard.
      </p>

      <div class="mt-6 grid gap-3 md:grid-cols-2">
        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-left">
          <div class="text-sm font-semibold text-white mb-1">Status</div>
          <div class="text-sm text-gray-300">Pending verification by admin</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-left">
          <div class="text-sm font-semibold text-white mb-1">Next Step</div>
          <div class="text-sm text-gray-300">Wait for approval before login</div>
        </div>
      </div>

      <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('vendor.login') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-orange-500 text-black font-semibold hover:bg-orange-400 transition">
          <i class="fa-solid fa-right-to-bracket"></i>
          Go to Login
        </a>
        <span class="text-sm text-gray-400">You will receive access after approval.</span>
      </div>

    </div>
  </div>
</body>
</html>
