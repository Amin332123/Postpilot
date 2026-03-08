<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PostPilot – AI Co-Pilot for Instagram</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet" />
  <style>
    :root {
      --violet: #7D5FFF;
      --pink: #FF5FA3;
      --dark: #0D0B1A;
      --card-bg: rgba(255,255,255,0.05);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--dark);
      color: #fff;
      overflow-x: hidden;
    }
    h1, h2, h3, .brand { font-family: 'Syne', sans-serif; }

    /* ── gradient text ── */
    .grad-text {
      background: linear-gradient(135deg, #a78bff 0%, #FF5FA3 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ── gradient button ── */
    .grad-btn {
      background: linear-gradient(135deg, var(--violet), var(--pink));
      border: none;
      cursor: pointer;
      transition: opacity .2s, transform .2s, box-shadow .2s;
    }
    .grad-btn:hover {
      opacity: .9;
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(125,95,255,.45);
    }

    /* ── navbar ── */
    nav {
      position: fixed; top: 0; left: 0; right: 0; z-index: 50;
      backdrop-filter: blur(18px);
      background: rgba(13,11,26,.7);
      border-bottom: 1px solid rgba(255,255,255,.07);
    }

    /* ── hero ── */
    .hero-bg {
      background: radial-gradient(ellipse 80% 60% at 70% 40%, rgba(125,95,255,.25) 0%, transparent 65%),
                  radial-gradient(ellipse 60% 50% at 20% 80%, rgba(255,95,163,.18) 0%, transparent 60%),
                  var(--dark);
      min-height: 100vh;
    }

    /* ── floating robot ── */
    @keyframes float {
      0%,100% { transform: translateY(0px) rotate(-1deg); }
      50%      { transform: translateY(-22px) rotate(1deg); }
    }
    .robot-float { animation: float 4s ease-in-out infinite; }

    /* ── glow pulse behind robot ── */
    @keyframes glowPulse {
      0%,100% { opacity: .5; transform: scale(1); }
      50%      { opacity: .8; transform: scale(1.08); }
    }
    .robot-glow {
      animation: glowPulse 4s ease-in-out infinite;
      background: radial-gradient(circle, rgba(125,95,255,.4) 0%, transparent 70%);
      border-radius: 50%;
    }

    /* ── feature cards ── */
    .feature-card {
      background: rgba(255,255,255,.04);
      border: 1px solid rgba(255,255,255,.09);
      border-radius: 20px;
      transition: transform .3s, box-shadow .3s, border-color .3s;
      opacity: 0;
      transform: translateY(40px);
      transition: opacity .6s ease, transform .6s ease, box-shadow .3s;
    }
    .feature-card.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .feature-card:hover {
      border-color: rgba(125,95,255,.4);
      box-shadow: 0 20px 60px rgba(125,95,255,.15);
    }
    .feature-icon {
      width: 52px; height: 52px;
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem;
    }

    /* ── footer ── */
    footer {
      background: linear-gradient(135deg, rgba(125,95,255,.15) 0%, rgba(255,95,163,.12) 100%);
      border-top: 1px solid rgba(255,255,255,.08);
    }

    /* ── particles background ── */
    .particle {
      position: absolute;
      border-radius: 50%;
      animation: particleDrift linear infinite;
      pointer-events: none;
    }
    @keyframes particleDrift {
      0%   { transform: translate(0,0) scale(1); opacity: .6; }
      50%  { opacity: .3; }
      100% { transform: translate(var(--tx), var(--ty)) scale(.5); opacity: 0; }
    }

    /* ── scrollbar ── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--dark); }
    ::-webkit-scrollbar-thumb { background: var(--violet); border-radius: 3px; }
  </style>
</head>
<body>

<!-- ══════════════ NAV ══════════════ -->
<nav class="px-6 py-4">
  <div class="max-w-6xl mx-auto flex items-center justify-between">
    <a href="/" class="brand text-xl font-bold flex items-center gap-2">
      <span class="grad-text text-2xl">PostPilot</span>
      <span class="text-xs text-white/40 font-normal mt-1">✈️</span>
    </a>
    <div class="hidden md:flex items-center gap-8 text-sm text-white/60">
      <a href="#features" class="hover:text-white transition-colors">Features</a>
      <a href="#about" class="hover:text-white transition-colors">About</a>
      <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
    </div>
    <a href="{{ route('register') }}" class="grad-btn px-5 py-2 rounded-full text-white text-sm font-semibold">
      Get Started Free
    </a>
  </div>
</nav>

<!-- ══════════════ HERO ══════════════ -->
<section class="hero-bg relative overflow-hidden pt-28 pb-20">
  <!-- background particles -->
  <div id="particles" class="absolute inset-0 pointer-events-none overflow-hidden"></div>

  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-[80vh]">

    <!-- Left: copy -->
    <div class="space-y-7 z-10 relative">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-white/5 text-xs text-white/60">
        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
        Now live — Try free, no credit card needed
      </div>

      <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight">
        Your AI<br/>
        <span class="grad-text">Co-Pilot</span><br/>
        for Instagram
      </h1>

      <p class="text-white/60 text-lg max-w-md leading-relaxed">
        Generate scroll-stopping captions &amp; smart hashtags in seconds — built for Moroccan shops &amp; online businesses.
      </p>

      <div class="flex flex-wrap gap-4">
        <!-- Try Free Demo - points to dashboard if logged in, otherwise register -->
        <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="grad-btn px-8 py-4 rounded-2xl text-white font-bold text-base">
          🚀 {{ auth()->check() ? 'Go to Dashboard' : 'Try Free Demo' }}
        </a>
        <a href="#features" class="px-8 py-4 rounded-2xl border border-white/15 text-white/70 hover:border-white/40 hover:text-white transition-all font-medium text-base">
          See How It Works
        </a>
      </div>

      <div class="flex items-center gap-6 pt-2">
        <div class="flex -space-x-2">
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-400 to-pink-400 border-2 border-dark"></div>
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-orange-400 border-2 border-dark"></div>
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-violet-400 border-2 border-dark"></div>
        </div>
        <span class="text-sm text-white/50">Trusted by <strong class="text-white">500+</strong> sellers already</span>
      </div>
    </div>

    <!-- Right: robot mascot -->
    <div class="relative flex items-center justify-center">
      <!-- glow blob behind robot -->
      <div class="robot-glow absolute w-80 h-80 z-0"></div>
      <!-- {{-- Laravel: img src="{{ asset('images/robot-mascot.jpg') }}" --}} -->
      <img
        src="robot-mascot.jpg"
        alt="PostPilot AI Robot Mascot"
        class="robot-float relative z-10 w-72 lg:w-96 drop-shadow-2xl"
        onerror="this.style.display='none'; document.getElementById('robot-fallback').style.display='flex';"
      />
      <!-- Fallback SVG robot if image missing -->
      <div id="robot-fallback" class="robot-float relative z-10 hidden flex-col items-center justify-center w-72 h-80">
        <svg viewBox="0 0 200 260" width="220" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="rbg" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#e8e0ff"/>
              <stop offset="100%" stop-color="#f0f0f0"/>
            </linearGradient>
          </defs>
          <!-- body -->
          <rect x="60" y="110" width="80" height="90" rx="20" fill="url(#rbg)"/>
          <!-- chest emblem -->
          <path d="M85 145 L100 135 L115 145 L110 155 L90 155 Z" fill="#FFB830" opacity=".8"/>
          <!-- head -->
          <rect x="55" y="55" width="90" height="70" rx="22" fill="url(#rbg)"/>
          <!-- visor -->
          <rect x="65" y="65" width="70" height="40" rx="14" fill="#1a1040"/>
          <!-- eyes -->
          <ellipse cx="83" cy="85" rx="9" ry="8" fill="#00CFFF" opacity=".9"/>
          <ellipse cx="117" cy="85" rx="9" ry="8" fill="#00CFFF" opacity=".9"/>
          <!-- eye glow -->
          <ellipse cx="83" cy="85" rx="5" ry="4" fill="#fff" opacity=".5"/>
          <ellipse cx="117" cy="85" rx="5" ry="4" fill="#fff" opacity=".5"/>
          <!-- hat brim -->
          <rect x="45" y="52" width="110" height="10" rx="5" fill="#2d2d4e"/>
          <!-- hat top -->
          <rect x="60" y="22" width="80" height="35" rx="10" fill="#2d2d4e"/>
          <!-- hat badge -->
          <circle cx="100" cy="40" r="8" fill="#FFB830"/>
          <text x="100" y="44" text-anchor="middle" font-size="8" fill="#2d2d4e" font-weight="bold">✈</text>
          <!-- arms -->
          <rect x="20" y="115" width="38" height="14" rx="7" fill="url(#rbg)" transform="rotate(-25 39 122)"/>
          <rect x="142" y="115" width="38" height="14" rx="7" fill="url(#rbg)" transform="rotate(25 161 122)"/>
          <!-- legs -->
          <rect x="70" y="198" width="22" height="45" rx="11" fill="url(#rbg)"/>
          <rect x="108" y="198" width="22" height="45" rx="11" fill="url(#rbg)"/>
          <!-- feet -->
          <rect x="62" y="235" width="36" height="16" rx="8" fill="#e0d8f8"/>
          <rect x="102" y="235" width="36" height="16" rx="8" fill="#e0d8f8"/>
        </svg>
      </div>

      <!-- decorative stars around robot -->
      <div class="absolute top-10 right-10 text-yellow-300 text-2xl animate-spin" style="animation-duration:8s">✦</div>
      <div class="absolute bottom-16 left-8 text-pink-400 text-lg animate-bounce" style="animation-delay:.5s">✦</div>
      <div class="absolute top-1/2 right-4 text-violet-400 text-sm animate-pulse">★</div>
    </div>
  </div>
</section>

<!-- ══════════════ FEATURES ══════════════ -->
<section id="features" class="py-24 px-6 relative">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <p class="text-sm font-semibold uppercase tracking-widest text-violet-400 mb-3">What PostPilot Does</p>
      <h2 class="text-4xl lg:text-5xl font-bold">Everything your Instagram <span class="grad-text">needs</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      <!-- Card 1 -->
      <div class="feature-card p-8 group" style="transition-delay: 0s">
        <div class="feature-icon mb-6" style="background: linear-gradient(135deg,rgba(125,95,255,.25),rgba(125,95,255,.05))">
          ✍️
        </div>
        <h3 class="text-xl font-bold mb-3">Auto-Generate Captions</h3>
        <p class="text-white/50 leading-relaxed text-sm">Describe your product and get compelling, on-brand Instagram captions instantly — in Arabic, French, or English.</p>
        <div class="mt-6 h-px bg-gradient-to-r from-violet-500/40 to-transparent"></div>
        <p class="mt-4 text-xs text-violet-400 font-medium">→ Powered by advanced AI</p>
      </div>

      <!-- Card 2 -->
      <div class="feature-card p-8 group" style="transition-delay: 0.15s">
        <div class="feature-icon mb-6" style="background: linear-gradient(135deg,rgba(255,95,163,.25),rgba(255,95,163,.05))">
          #️⃣
        </div>
        <h3 class="text-xl font-bold mb-3">Smart Hashtags</h3>
        <p class="text-white/50 leading-relaxed text-sm">Get targeted, high-reach hashtags tailored to your niche, audience, and post content — no guessing game.</p>
        <div class="mt-6 h-px bg-gradient-to-r from-pink-500/40 to-transparent"></div>
        <p class="mt-4 text-xs text-pink-400 font-medium">→ Up to 30 curated hashtags</p>
      </div>

      <!-- Card 3 -->
      <div class="feature-card p-8 group" style="transition-delay: 0.3s">
        <div class="feature-icon mb-6" style="background: linear-gradient(135deg,rgba(255,184,48,.2),rgba(255,184,48,.05))">
          ⚡
        </div>
        <h3 class="text-xl font-bold mb-3">Save Time &amp; Boost Engagement</h3>
        <p class="text-white/50 leading-relaxed text-sm">Cut caption writing time from 30 minutes to 30 seconds. Post more, stress less, grow faster.</p>
        <div class="mt-6 h-px bg-gradient-to-r from-yellow-500/40 to-transparent"></div>
        <p class="mt-4 text-xs text-yellow-400 font-medium">→ 10× faster workflow</p>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════ CTA BANNER ══════════════ -->
<section class="py-20 px-6">
  <div class="max-w-3xl mx-auto text-center">
    <div class="rounded-3xl p-12 relative overflow-hidden border border-white/10"
         style="background: linear-gradient(135deg, rgba(125,95,255,.2) 0%, rgba(255,95,163,.15) 100%)">
      <div class="absolute inset-0 opacity-30" style="background: radial-gradient(circle at 50% 50%, rgba(125,95,255,.4), transparent 70%)"></div>
      <h2 class="text-3xl lg:text-4xl font-bold relative z-10 mb-4">Ready to fly your Instagram to the top?</h2>
      <p class="text-white/60 mb-8 relative z-10">Join hundreds of Moroccan sellers growing their brand with AI-powered content.</p>
      <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="grad-btn inline-block px-10 py-4 rounded-2xl text-white font-bold text-lg relative z-10">
        {{ auth()->check() ? 'Go to Dashboard' : 'Start Free Today' }} ✈️
      </a>
    </div>
  </div>
</section>

<!-- ══════════════ FOOTER ══════════════ -->
<footer class="py-12 px-6">
  <div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center gap-8">
      <div>
        <span class="brand text-2xl font-bold grad-text">PostPilot</span>
        <p class="text-white/40 text-sm mt-1">Your AI co-pilot for Instagram captions</p>
      </div>
      <div class="flex items-center gap-6 text-sm text-white/50">
        <a href="#" class="hover:text-white transition-colors">About</a>
        <a href="#" class="hover:text-white transition-colors">Contact</a>
        <a href="#" class="hover:text-white transition-colors">Terms</a>
        <a href="#" class="hover:text-white transition-colors">Privacy</a>
      </div>
      <!-- Social icons -->
      <div class="flex items-center gap-4">
        <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-colors text-sm">📷</a>
        <a href="#" aria-label="TikTok" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-colors text-sm">🎵</a>
        <a href="#" aria-label="Twitter/X" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-colors text-sm">𝕏</a>
      </div>
    </div>
    <div class="mt-8 pt-6 border-t border-white/5 text-center text-white/25 text-xs">
      © 2025 PostPilot. Built with ❤️ for Moroccan entrepreneurs.
    </div>
  </div>
</footer>

<!-- ══════════════ JS ══════════════ -->
<script>
  /* ── Scroll Fade-in for feature cards ── */
  const cards = document.querySelectorAll('.feature-card');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.15 });
  cards.forEach(c => observer.observe(c));

  /* ── Particle generator ── */
  const container = document.getElementById('particles');
  for (let i = 0; i < 18; i++) {
    const p = document.createElement('div');
    const size = Math.random() * 5 + 2;
    const colors = ['rgba(125,95,255,.5)', 'rgba(255,95,163,.4)', 'rgba(255,184,48,.3)'];
    p.className = 'particle';
    Object.assign(p.style, {
      width: size + 'px', height: size + 'px',
      left: Math.random() * 100 + '%',
      top: Math.random() * 100 + '%',
      background: colors[Math.floor(Math.random() * colors.length)],
      '--tx': (Math.random() * 200 - 100) + 'px',
      '--ty': (Math.random() * -300 - 50) + 'px',
      animationDuration: (Math.random() * 8 + 5) + 's',
      animationDelay: (Math.random() * 5) + 's',
    });
    container.appendChild(p);
  }

  /* ── Smooth nav link scroll ── */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      e.preventDefault();
      const target = document.querySelector(a.getAttribute('href'));
      if (target) target.scrollIntoView({ behavior: 'smooth' });
    });
  });
</script>
</body>
</html>