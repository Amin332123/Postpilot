<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login – PostPilot</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    :root { --violet: #7D5FFF; --pink: #FF5FA3; --dark: #0D0B1A; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--dark);
      color: #fff;
      min-height: 100vh;
      overflow-x: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    h1, .brand { font-family: 'Syne', sans-serif; }

    .grad-text {
      background: linear-gradient(135deg, #a78bff, #FF5FA3);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .grad-btn {
      background: linear-gradient(135deg, var(--violet), var(--pink));
      cursor: pointer;
      transition: opacity .2s, transform .2s, box-shadow .2s;
    }
    .grad-btn:hover {
      opacity: .9;
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(125,95,255,.45);
    }

    /* Background blobs */
    .bg-layer {
      position: fixed; inset: 0; z-index: 0; overflow: hidden;
      background: var(--dark);
    }
    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(90px);
      animation: blobDrift ease-in-out infinite alternate;
    }
    @keyframes blobDrift {
      0%   { transform: translate(0,0) scale(1); }
      100% { transform: translate(var(--dx), var(--dy)) scale(1.1); }
    }

    /* Floating shapes */
    .shape {
      position: fixed;
      border: 1px solid rgba(255,255,255,.06);
      border-radius: 50%;
      animation: shapeSpin linear infinite;
      pointer-events: none;
      z-index: 1;
    }
    @keyframes shapeSpin {
      0%   { transform: rotate(0deg) translateX(var(--r)) rotate(0deg); }
      100% { transform: rotate(360deg) translateX(var(--r)) rotate(-360deg); }
    }

    /* Card */
    .login-card {
      background: rgba(255,255,255,.04);
      border: 1px solid rgba(255,255,255,.1);
      backdrop-filter: blur(24px);
      border-radius: 28px;
      box-shadow: 0 40px 100px rgba(0,0,0,.5), 0 0 0 1px rgba(255,255,255,.05);
    }

    /* Input fields */
    .field {
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 12px;
      color: #fff;
      width: 100%;
      padding: 14px 16px;
      font-family: 'DM Sans', sans-serif;
      font-size: .95rem;
      transition: border-color .2s, box-shadow .2s;
      outline: none;
    }
    .field::placeholder { color: rgba(255,255,255,.3); }
    .field:focus {
      border-color: rgba(125,95,255,.6);
      box-shadow: 0 0 0 3px rgba(125,95,255,.15);
    }

    /* Robot icon float */
    @keyframes miniFloat {
      0%,100% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
    }
    .mini-float { animation: miniFloat 3s ease-in-out infinite; }

    /* Card entrance */
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(30px) scale(.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .card-in { animation: cardIn .6s cubic-bezier(.22,1,.36,1) forwards; }
  </style>
</head>
<body>

<!-- Animated background -->
<div class="bg-layer">
  <div class="blob" style="width:500px;height:500px;background:rgba(125,95,255,.18);top:-100px;left:-150px;--dx:60px;--dy:40px;animation-duration:9s;"></div>
  <div class="blob" style="width:400px;height:400px;background:rgba(255,95,163,.14);bottom:-80px;right:-100px;--dx:-40px;--dy:-50px;animation-duration:11s;"></div>
  <div class="blob" style="width:250px;height:250px;background:rgba(125,95,255,.1);bottom:30%;left:40%;--dx:30px;--dy:-30px;animation-duration:7s;"></div>
</div>

<!-- Floating rings -->
<div class="shape" style="width:300px;height:300px;top:10%;left:5%;--r:0px;animation-duration:30s;opacity:.4;"></div>
<div class="shape" style="width:180px;height:180px;bottom:15%;right:8%;--r:0px;animation-duration:20s;opacity:.3;"></div>

<!-- Mini robot in corner -->
<div class="fixed top-5 left-5 z-20 mini-float">
  <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
    <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg border border-white/20" style="background:linear-gradient(135deg,#7D5FFF,#FF5FA3)">✈️</div>
    <span class="brand font-bold grad-text text-lg hidden sm:block">PostPilot</span>
  </a>
</div>

<!-- Main card -->
<div class="relative z-10 w-full max-w-md px-4 card-in">
  <div class="login-card p-8 md:p-10">

    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold mb-2">Welcome back <span class="grad-text">✈️</span></h1>
      <p class="text-white/50 text-sm">Sign in to your PostPilot account</p>
    </div>

    <!-- Status Message -->
    @if (session('status'))
      <div style="background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.3); color: #86efac; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        {{ session('status') }}
      </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 20px;">
      @csrf

      <!-- Email -->
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="display: block; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.7);">Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus autocomplete="username" class="field @error('email') border-red-500 @enderror" />
        @error('email')
          <span style="color: #ff5757; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="display: block; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.7);">Password</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password" class="field @error('password') border-red-500 @enderror" style="padding-right: 44px;" />
          <button type="button" onclick="togglePwd('password','eyeP')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,.4); cursor: pointer; font-size: 16px;" id="eyeP">👁</button>
        </div>
        @error('password')
          <span style="color: #ff5757; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Remember & Forgot -->
      <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13px;">
        <label style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,.6); cursor: pointer;">
          <input type="checkbox" name="remember" />
          Remember me
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" style="color: #a78bff; text-decoration: none; transition: color .2s;">Forgot password?</a>
        @endif
      </div>

      <!-- Submit -->
      <button type="submit" class="grad-btn" style="width: 100%; padding: 14px; border-radius: 16px; color: white; font-bold; font-size: 16px; border: none; margin-top: 8px;">
        Sign In to PostPilot
      </button>

    </form>

    <!-- Divider -->
    <div style="display: flex; align-items: center; gap: 12px; margin: 24px 0;">
      <div style="flex: 1; height: 1px; background: rgba(255,255,255,.1);"></div>
      <span style="color: rgba(255,255,255,.3); font-size: 12px;">or</span>
      <div style="flex: 1; height: 1px; background: rgba(255,255,255,.1);"></div>
    </div>

    <!-- Sign up link -->
    <p style="text-align: center; font-size: 14px; color: rgba(255,255,255,.6);">
      Don't have an account?
      <a href="{{ route('register') }}" style="color: #a78bff; text-decoration: none; font-weight: 600; margin-left: 4px;">Create one free →</a>
    </p>
  </div>
</div>

<script>
  function togglePwd(id, btnId) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
  }
</script>
</body>
</html>
