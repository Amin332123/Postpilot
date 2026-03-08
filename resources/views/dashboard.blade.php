<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard – PostPilot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --violet: #7D5FFF;
            --pink: #FF5FA3;
            --dark: #0D0B1A;
            --sidebar-w: 260px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f0d1e;
            color: #fff;
            min-height: 100vh;
        }

        .grad-text {
            background: linear-gradient(135deg, #a78bff, #FF5FA3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .grad-btn {
            background: linear-gradient(135deg, var(--violet), var(--pink));
            cursor: pointer;
            border: none;
            transition: .2s;
        }

        .grad-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(125, 95, 255, .4);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: rgba(255, 255, 255, .03);
            border-right: 1px solid rgba(255, 255, 255, .07);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 2px 12px;
            font-size: .9rem;
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
        }

        .sidebar-link:hover {
            background: rgba(125, 95, 255, .15);
            color: #fff;
        }

        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        .field {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 12px;
            color: #fff;
            padding: 13px 16px;
            font-size: .93rem;
        }

        .card {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
        }

        .animate-pulse {
            animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
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
        @if ($limit != 0)
            <div class="p-4 mx-3 mb-3 rounded-2xl"
                style="background:rgba(125,95,255,.1);border:1px solid rgba(125,95,255,.2)">
                <p class="text-xs text-white/60 mb-2">Monthly generations</p>
                <div class="flex items-center justify-between mb-2">
                    <span id="usedText" class="text-sm font-bold">{{ $used }} / {{$limit}}</span>
                    <span id="planName" class="text-xs text-white/40">{{ $planName }}</span>
                </div>
                <div class="w-full h-1.5 rounded-full bg-white/10">
                    <div id="usedBar" class="h-full rounded-full"
                        style="width: {{ $percentage }}%;background:linear-gradient(90deg,#7D5FFF,#FF5FA3)">
                    </div>
                </div>
                <a href="#" class="mt-3 grad-btn w-full block text-center py-2 rounded-xl text-white text-xs font-semibold">
                    Upgrade to Pro 🚀
                </a>
            </div>
        @endif

        @if($planName == 'Captain')
            <div class="p-4 mx-3 mb-3 rounded-2xl bg-white/5 border border-white/10 text-center text-sm text-white/70">
                🚀 Unlimited captions! Enjoy your plan.
            </div>
        @endif
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link text-red-400 w-full justify-start">🚪 Log Out</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <div class="p-6 max-w-6xl mx-auto space-y-6">
            <h1 class="text-2xl font-bold">Caption Generator ✨</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="card p-6">
                        <h3 class="text-xl font-bold mb-6">Generate Caption</h3>
                        <form id="captionForm" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm mb-2">Describe your product</label>
                                <textarea name="description" id="productDesc" class="field w-full h-32"
                                    placeholder="Handmade leather bag from Fes..." required></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm mb-2">Tone</label>
                                    <select name="tone" id="tone" class="field w-full">
                                        <option value="professional">Professional</option>
                                        <option value="casual">Casual</option>
                                        <option value="funny">Funny</option>
                                        <option value="luxury">Luxury</option>
                                        <option value="minimal">Minimal</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm mb-2">Language</label>
                                    <select name="language" id="language" class="field w-full">
                                        <option value="English">English</option>
                                        <option value="French">French</option>
                                        <option value="Arabic">Arabic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hidden">
                                <label class="block text-sm mb-2">Hashtags</label>
                                <select name="hashtags" id="hashtags" class="field w-full">
                                    <option value="yes">Include hashtags</option>
                                    <option value="no">No hashtags</option>
                                    <option value="separate">Separate from caption</option>
                                </select>
                            </div>
                            <button type="submit" class="grad-btn px-8 py-4 rounded-2xl text-white font-bold w-full">🚀
                                Generate Caption</button>
                        </form>
                    </div>
                </div>

                <!-- OUTPUT -->
                <div>
                    <div id="outputSection" class="card p-6 hidden">
                        <h3 class="text-xl font-bold mb-4">✨ Generated Content</h3>

                        <!-- Loading Skeleton -->
                        <div id="loadingSkeleton" class="space-y-4 hidden">
                            <div class="mb-4 p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="space-y-3">
                                    <div class="h-4 bg-gradient-to-r from-white/10 to-white/5 rounded animate-pulse">
                                    </div>
                                    <div
                                        class="h-4 bg-gradient-to-r from-white/10 to-white/5 rounded animate-pulse w-9/12">
                                    </div>
                                    <div
                                        class="h-4 bg-gradient-to-r from-white/10 to-white/5 rounded animate-pulse w-10/12">
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="space-y-2">
                                    <div
                                        class="h-3 bg-gradient-to-r from-violet-500/20 to-white/5 rounded animate-pulse w-1/2">
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <div
                                            class="h-6 w-20 bg-gradient-to-r from-white/10 to-white/5 rounded-full animate-pulse">
                                        </div>
                                        <div
                                            class="h-6 w-20 bg-gradient-to-r from-white/10 to-white/5 rounded-full animate-pulse">
                                        </div>
                                        <div
                                            class="h-6 w-20 bg-gradient-to-r from-white/10 to-white/5 rounded-full animate-pulse">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actual Content -->
                        <div id="generatedContent" class="hidden">
                            <div id="captionOutput" class="mb-4 p-4 rounded-xl bg-white/5 border border-white/10">
                                <p></p>
                            </div>
                            <div id="hashtagsOutput"
                                class="mb-4 p-4 rounded-xl bg-white/5 border border-white/10 hidden">
                                <p class="text-xs text-violet-300 mb-2">Hashtags</p>
                                <p></p>
                            </div>
                            <div class="flex gap-2">

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const toastEl = document.createElement('div');
        toastEl.className = 'fixed bottom-6 right-6 z-50 px-5 py-3 rounded-2xl text-sm font-medium text-white';
        toastEl.style.background = 'linear-gradient(135deg,#7D5FFF,#FF5FA3)';
        toastEl.style.boxShadow = '0 8px 32px rgba(125,95,255,.4)';
        toastEl.style.display = 'none';
        document.body.appendChild(toastEl);

        function toast(msg, duration = 2500) {
            toastEl.textContent = msg;
            toastEl.style.display = 'block';
            setTimeout(() => { toastEl.style.display = 'none'; }, duration);
        }

        document.getElementById("captionForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            const description = document.getElementById("productDesc").value;
            const tone = document.getElementById("tone").value;
            const language = document.getElementById("language").value;
            const hashtags = document.getElementById("hashtags").value;

            document.getElementById("outputSection").classList.remove("hidden");
            document.getElementById("generatedContent").classList.add("hidden");
            document.getElementById("loadingSkeleton").classList.remove("hidden");

            toast("Generating caption... 🤖");

            try {

                const response = await fetch("/generate-caption", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({ description, tone, language, hashtags })
                });

                const data = await response.json();

                /* 🔴 PLAN LIMIT CHECK */
                if (!response.ok) {

                    if (data.plan === "Free" || data.plan === "Pilot") {
                        toast("🚫 Limit reached. Redirecting to upgrade...");

                        setTimeout(() => {
                            window.location.href = "/upgrade";
                        }, 1200);

                        return;
                    }

                    throw new Error(data.error || "Unknown error");
                }

                /* SUCCESS */

                document.querySelector("#captionOutput p").textContent = data.caption;

                if (data.hashtags) {
                    const hashtagsBox = document.querySelector("#hashtagsOutput p:last-child");
                    hashtagsBox.textContent = data.hashtags;
                    document.getElementById("hashtagsOutput").classList.remove("hidden");
                } else {
                    document.getElementById("hashtagsOutput").classList.add("hidden");
                }

                document.getElementById("loadingSkeleton").classList.add("hidden");
                document.getElementById("generatedContent").classList.remove("hidden");
                if (data.used !== undefined && data.limit !== undefined) {
                    const usedEl = document.getElementById("usedText");
                    const barEl = document.getElementById("usedBar");
                    const planEl = document.getElementById("planName");

                    usedEl.textContent = `${data.used} / ${data.limit}`;
                    barEl.style.width = `${data.percentage}%`;
                    planEl.textContent = data.plan;
                }
                toast("Caption generated ✅");

            } catch (error) {

                console.error("FULL ERROR:", error);

                toast("❌ " + error.message);

                document.getElementById("loadingSkeleton").classList.add("hidden");
            }
        });


        function copyText() {
            const text = document.querySelector("#captionOutput p").textContent;
            navigator.clipboard.writeText(text);
            toast("📋 Caption copied!");
        }

        function copyHashtags() {
            const text = document.querySelector("#hashtagsOutput p:last-child").textContent;
            navigator.clipboard.writeText(text);
            toast("#️⃣ Hashtags copied!");
        }

        function copyAll() {
            const caption = document.querySelector("#captionOutput p").textContent;
            const hashtags = document.querySelector("#hashtagsOutput p:last-child").textContent;
            navigator.clipboard.writeText(caption + "\n\n" + hashtags);
            toast("📄 Everything copied!");
        }
    </script>

</body>

</html>