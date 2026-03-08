<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PostPilot') }}</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@400;500;700&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --violet: #7D5FFF;
            --pink: #FF5FA3;
            --sidebar-w: 260px;
            --bg-dark: #0f0d1e;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-dark);
            color: #fff;
            margin: 0;
            overflow-x: hidden;
        }

        .grad-text {
            background: linear-gradient(135deg, #a78bff, #FF5FA3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .grad-btn {
            background: linear-gradient(135deg, var(--violet), var(--pink));
            transition: all 0.2s;
        }

        .grad-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(125, 95, 255, 0.3);
        }

        /* Sidebar Layout */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: rgba(255, 255, 255, 0.02);
            border-right: 1px solid rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(10px);
            z-index: 50;
            display: flex;
            flex-direction: column;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(125, 95, 255, 0.1);
            color: #c4b5ff;
        }

        /* Main Content Wrapper */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            padding: 2rem;
        }

        /* Common Card Styles */
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
        }

        .field {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: white;
            outline: none;
            transition: border-color 0.2s;
        }

        .field:focus {
            border-color: var(--violet);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }


        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-bounce-in {
            animation: bounceIn 0.5s ease-out;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="p-6 border-b border-white/10">
            <a href="/" class="text-xl font-bold grad-text">PostPilot ✈️</a>
            <p class="text-xs text-white/30 mt-1">AI Caption Generator</p>
        </div>
        <nav class="flex-1 py-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="sidebar-link">🏠 Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">👤 Profile</a>
            <a href="{{ route('history.show') }}" class="sidebar-link"><span>📋</span> History</a>
        </nav>
      
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link text-red-400 w-full justify-start">🚪 Log Out</button>
            </form>
        </div>
    </aside>

    <div class="main-content">
        {{ $slot }}
    </div>

    <script>
        // Global tab switching logic
        function switchTab(btn, targetId) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active', 'bg-white/10', 'text-white'));
            document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));

            btn.classList.add('active', 'bg-white/10', 'text-white');
            document.getElementById(targetId).classList.remove('hidden');
        }

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-flash');
            alerts.forEach(a => a.style.display = 'none');
        }, 3000);
    </script>
</body>

</html>