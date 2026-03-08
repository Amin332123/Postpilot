<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up – PostPilot</title>
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
      padding: 32px 16px;
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

    .bg-layer {
      position: fixed; inset: 0; z-index: 0; overflow: hidden;
      background: var(--dark);
    }
    .blob {
      position: absolute; border-radius: 50%;
      filter: blur(90px);
      animation: blobDrift ease-in-out infinite alternate;
    }
    @keyframes blobDrift {
      0%   { transform: translate(0,0) scale(1); }
      100% { transform: translate(var(--dx), var(--dy)) scale(1.1); }
    }

    .login-card {
      background: rgba(255,255,255,.04);
      border: 1px solid rgba(255,255,255,.1);
      backdrop-filter: blur(24px);
      border-radius: 28px;
      box-shadow: 0 40px 100px rgba(0,0,0,.5);
    }

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
    .field.error { border-color: rgba(255,95,103,.6); }

    @keyframes miniFloat {
      0%,100% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
    }
    .mini-float { animation: miniFloat 3s ease-in-out infinite; }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(30px) scale(.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .card-in { animation: cardIn .6s cubic-bezier(.22,1,.36,1) forwards; }

    @keyframes hexFloat {
      0%,100% { transform: translateY(0) rotate(0deg); opacity: .15; }
      50%      { transform: translateY(-30px) rotate(20deg); opacity: .3; }
    }
    .hex {
      position: fixed; pointer-events: none; z-index: 1;
      animation: hexFloat ease-in-out infinite;
      font-size: 3rem;
      color: rgba(125,95,255,.3);
    }
  </style>
</head>
<body>

<!-- Animated background -->
<div class="bg-layer">
  <div class="blob" style="width:550px;height:550px;background:rgba(125,95,255,.15);top:-120px;right:-100px;--dx:-50px;--dy:50px;animation-duration:10s;"></div>
  <div class="blob" style="width:380px;height:380px;background:rgba(255,95,163,.13);bottom:-60px;left:-80px;--dx:60px;--dy:-40px;animation-duration:12s;"></div>
  <div class="blob" style="width:200px;height:200px;background:rgba(125,95,255,.08);top:50%;right:20%;--dx:20px;--dy:20px;animation-duration:7s;"></div>
</div>

<!-- Decorative hex floats -->
<div class="hex" style="top:15%;left:3%;animation-duration:7s;">⬡</div>
<div class="hex" style="top:65%;right:4%;animation-duration:9s;animation-delay:2s;font-size:2rem;">⬡</div>
<div class="hex" style="bottom:10%;left:12%;animation-duration:11s;animation-delay:1s;font-size:1.5rem;">⬡</div>

<!-- Mini robot corner -->
<div class="fixed top-5 left-5 z-20 mini-float">
  <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
    <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg border border-white/20" style="background:linear-gradient(135deg,#7D5FFF,#FF5FA3)">✈️</div>
    <span class="brand font-bold grad-text text-lg hidden sm:block">PostPilot</span>
  </a>
</div>

<!-- Main card -->
<div class="relative z-10 w-full max-w-md card-in">
  <div class="login-card p-8 md:p-10">

    <!-- Header -->
    <div class="text-center mb-8">
      <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 999px; background: rgba(125,95,255,.15); border: 1px solid rgba(125,95,255,.2); color: rgba(167,139,255,1); font-size: 12px; margin-bottom: 16px;">
        🚀 Free forever plan — no credit card
      </div>
      <h1 class="text-3xl font-extrabold mb-2">Join <span class="grad-text">PostPilot</span></h1>
      <p class="text-white/50 text-sm">Start generating captions in 30 seconds</p>
    </div>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 20px;">
      @csrf

      <!-- Name -->
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="display: block; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.7);">Full Name</label>
        <input type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required autofocus autocomplete="name" class="field @error('name') border-red-500 @enderror" />
        @error('name')
          <span style="color: #ff5757; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Email -->
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="display: block; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.7);">Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="username" class="field @error('email') border-red-500 @enderror" />
        @error('email')
          <span style="color: #ff5757; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="display: block; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.7);">Password</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password" class="field @error('password') border-red-500 @enderror" style="padding-right: 44px;" oninput="checkStrength(this.value)" />
          <button type="button" onclick="togglePwd('password')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,.4); cursor: pointer; font-size: 16px;">👁</button>
        </div>
        <!-- Password strength indicator -->
        <div style="display: flex; gap: 4px; margin-top: 4px;" id="strengthBars">
          <div style="flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,.1);" id="sb1"></div>
          <div style="flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,.1);" id="sb2"></div>
          <div style="flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,.1);" id="sb3"></div>
          <div style="flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,.1);" id="sb4"></div>
        </div>
        <p style="font-size: 12px; color: rgba(255,255,255,.3); margin-top: 4px;" id="strengthLabel">Enter a password</p>
        @error('password')
          <span style="color: #ff5757; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="display: block; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.7);">Confirm Password</label>
        <div style="position: relative;">
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required autocomplete="new-password" class="field @error('password_confirmation') border-red-500 @enderror" style="padding-right: 44px;" />
          <button type="button" onclick="togglePwd('password_confirmation')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,.4); cursor: pointer; font-size: 16px;">👁</button>
        </div>
        @error('password_confirmation')
          <span style="color: #ff5757; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Terms checkbox -->
      <label style="display: flex; align-items: flex-start; gap: 12px; font-size: 14px; color: rgba(255,255,255,.6); cursor: pointer;">
        <input type="checkbox" name="terms" required style="margin-top: 4px; cursor: pointer;" />
        <span>I agree to PostPilot's <a href="#" style="color: #a78bff; text-decoration: none; cursor: pointer;">Terms of Service</a> &amp; <a href="#" style="color: #a78bff; text-decoration: none; cursor: pointer;">Privacy Policy</a></span>
      </label>

      <!-- Submit -->
      <button type="submit" class="grad-btn" style="width: 100%; padding: 14px; border-radius: 16px; color: white; font-bold; font-size: 16px; border: none; margin-top: 8px;">
        Create My Free Account ✈️
      </button>

    </form>

    <!-- Login link -->
    <p style="text-align: center; font-size: 14px; color: rgba(255,255,255,.6); margin-top: 24px;">
      Already have an account?
      <a href="{{ route('login') }}" style="color: #a78bff; text-decoration: none; font-weight: 600; margin-left: 4px;">Login →</a>
    </p>

  </div>
</div>

<script>
  function togglePwd(id) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
  }

  function checkStrength(val) {
    const bars = [document.getElementById('sb1'), document.getElementById('sb2'), document.getElementById('sb3'), document.getElementById('sb4')];
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e'];
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong 🔒'];
    bars.forEach((b, i) => {
      b.style.background = i < score ? colors[score] : 'rgba(255,255,255,.1)';
    });
    label.textContent = val.length === 0 ? 'Enter a password' : labels[score];
    label.style.color = colors[score] || 'rgba(255,255,255,.3)';
  }
</script>
</body>
</html>
