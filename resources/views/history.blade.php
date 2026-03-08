<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>History – PostPilot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --violet: #7D5FFF;
            --pink: #FF5FA3;
            --sidebar-w: 260px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f0d1e;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        .brand {
            font-family: 'Syne', sans-serif;
        }

        .grad-text {
            background: linear-gradient(135deg, #a78bff, #FF5FA3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .grad-btn {
            background: linear-gradient(135deg, var(--violet), var(--pink));
            transition: all .2s;
            cursor: pointer;
        }

        .grad-btn:hover {
            opacity: .9;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(125, 95, 255, .4);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: rgba(255, 255, 255, .03);
            border-right: 1px solid rgba(255, 255, 255, .07);
            backdrop-filter: blur(14px);
            z-index: 40;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 4px 12px;
            font-size: .9rem;
            color: rgba(255, 255, 255, .5);
            transition: all .2s;
            text-decoration: none;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(125, 95, 255, .15);
            color: #c4b5ff;
        }

        .main-content {
            margin-left: var(--sidebar-w);
            transition: margin .3s;
        }

        .history-card {
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 24px;
            transition: all .3s;
        }

        .desc-block {
            background: rgba(125, 95, 255, .06);
            border: 1px solid rgba(125, 95, 255, .15);
            border-radius: 14px;
            position: relative;
        }

        .desc-block::before {
            content: 'DESCRIPTION';
            position: absolute;
            top: -9px;
            left: 14px;
            font-size: .6rem;
            font-weight: 800;
            color: #a78bff;
            background: #0f0d1e;
            padding: 0 6px;
        }

        .ai-block {
            background: rgba(255, 95, 163, .06);
            border: 1px solid rgba(255, 95, 163, .15);
            border-radius: 14px;
            position: relative;
        }

        .ai-block::before {
            content: 'AI CAPTION';
            position: absolute;
            top: -9px;
            left: 14px;
            font-size: .6rem;
            font-weight: 800;
            color: #FF5FA3;
            background: #0f0d1e;
            padding: 0 6px;
        }

        .hash-pill {
            background: rgba(125, 95, 255, .1);
            border: 1px solid rgba(125, 95, 255, .2);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: .75rem;
            color: #c4b5ff;
        }

        .copy-btn,
        .delete-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 12px;
            font-size: .8rem;
            transition: all .2s;
        }

        .copy-btn {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .6);
        }

        .copy-btn.success {
            border-color: #22c55e;
            color: #22c55e;
        }

        .delete-btn {
            background: rgba(239, 68, 68, .05);
            border: 1px solid rgba(239, 68, 68, .15);
            color: rgba(239, 68, 68, .6);
        }

        .filter-select {
            appearance: none;
            background: #1a1630;
            border: 1px solid rgba(255, 255, 255, .1);
            color: #fff;
            padding: 10px 16px;
            border-radius: 14px;
            font-size: .9rem;
            cursor: pointer;
            outline: none;
            width: 100%;
        }

        .confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            background: rgba(0, 0, 0, .7);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .3s;
        }

        .confirm-overlay.show {
            display: flex;
            opacity: 1;
        }

        .fade-out {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.4s ease;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
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
        <header
            class="topbar px-8 py-5 border-b border-white/5 sticky top-0 bg-[#0f0d1e]/80 backdrop-blur-md z-30 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold tracking-tight">Generation History</h1>
            </div>
            <a href="{{ route('dashboard') }}"
                class="grad-btn px-6 py-2.5 rounded-2xl text-sm font-bold text-white no-underline">+ New Caption</a>
        </header>

        <div class="px-8 py-8 max-w-5xl mx-auto space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex gap-2">
                    <div class="bg-white/5 border border-white/10 px-4 py-2 rounded-xl text-xs text-white/60">Total:
                        <span id="numberofcards" class="text-white font-bold">{{ count($histories) }}</span></div>
                </div>
                <select id="langFilter" class="filter-select">
                    <option value="all">🌐 All Languages</option>
                    @foreach($histories->unique('language') as $h)
                        <option value="{{ $h->language }}">{{ strtoupper($h->language) }}</option>
                    @endforeach
                </select>
            </div>

            <div id="cardsGrid" class="space-y-6">
                @forelse ($histories as $history)
                    <article class="history-card overflow-hidden" data-lang="{{ $history->language }}"
                        data-history-id="{{ $history->id }}">
                        <div class="h-1 w-full bg-gradient-to-r from-[#7D5FFF] via-[#a855f7] to-[#FF5FA3]"></div>
                        <div class="p-6 space-y-5">
                            <div class="flex justify-between items-center">
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-indigo-500/20 border border-indigo-500/30 rounded-full text-[10px] font-bold text-indigo-300 uppercase">{{ $history->language }}</span>
                                    <span
                                        class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold text-white/40">{{ $history->tone }}</span>
                                </div>
                                <span class="text-[11px] text-white/20">{{ $history->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="desc-block p-4 pt-6">
                                <p class="text-sm text-violet-200/80 italic">"{{ $history->user_input }}"</p>
                            </div>
                            <div class="ai-block p-4 pt-6">
                                <p id="caption-{{ $history->id }}"
                                    class="text-sm text-pink-50 leading-relaxed whitespace-pre-line">
                                    {{ Str::before($history->ai_output, '#') }}</p>
                            </div>
                            <div id="tags-{{ $history->id }}" class="flex flex-wrap gap-2">
                                @php preg_match_all('/#\w+/', $history->ai_output, $matches); @endphp
                                @foreach($matches[0] as $tag) <span class="hash-pill">{{ $tag }}</span> @endforeach
                            </div>
                            <div class="pt-4 border-t border-white/5 flex flex-wrap justify-between items-center gap-4">
                                <div class="flex gap-2">
                                    <button class="copy-btn btn-copy" data-type="caption" data-id="{{ $history->id }}">📑
                                        Caption</button>
                                    <button class="copy-btn btn-copy" data-type="tags" data-id="{{ $history->id }}">#️⃣
                                        Tags</button>
                                    <button class="copy-btn btn-copy" data-type="all" data-id="{{ $history->id }}">✨
                                        All</button>
                                </div>
                                <button class="delete-btn btn-trigger-delete" data-id="{{ $history->id }}">🗑️
                                    Delete</button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-20 text-white/40">🤖 No history found</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="confirm-overlay" id="confirmOverlay">
        <div class="bg-[#1a1630] border border-red-500/30 p-8 rounded-[32px] max-w-sm w-full text-center shadow-2xl">
            <div class="text-4xl mb-4">⚠️</div>
            <h3 class="text-xl font-bold">Delete permanently?</h3>
            <div class="flex gap-3 mt-8">
                <button id="cancelDelete" class="flex-1 py-3 rounded-2xl bg-white/5 font-bold text-sm">Cancel</button>
                <button id="confirmDelete"
                    class="flex-1 py-3 rounded-2xl bg-red-500 font-bold text-sm shadow-lg shadow-red-500/20">Yes,
                    Delete</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let pendingDeleteId = null;

            // --- 1. Copy Logic (RESTORED) ---
            document.querySelectorAll('.btn-copy').forEach(btn => {
                btn.addEventListener('click', async function () {
                    const id = this.dataset.id;
                    const type = this.dataset.type;
                    const caption = document.getElementById(`caption-${id}`).innerText;
                    const tags = Array.from(document.querySelectorAll(`#tags-${id} .hash-pill`)).map(t => t.innerText).join(' ');

                    let textToCopy = (type === 'caption') ? caption : (type === 'tags') ? tags : `${caption}\n\n${tags}`;

                    await navigator.clipboard.writeText(textToCopy.trim());

                    const originalText = this.innerHTML;
                    this.innerHTML = "✅ Copied";
                    this.classList.add('success');
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('success');
                    }, 2000);
                });
            });

            // --- 2. Modal Controls (FIXED) ---
            document.querySelectorAll('.btn-trigger-delete').forEach(btn => {
                btn.addEventListener('click', function () {
                    pendingDeleteId = this.dataset.id;
                    document.getElementById('confirmOverlay').classList.add('show');
                });
            });

            document.getElementById('cancelDelete').addEventListener('click', () => {
                document.getElementById('confirmOverlay').classList.remove('show');
                pendingDeleteId = null;
            });

            // --- 3. AJAX Delete ---
            document.getElementById('confirmDelete').addEventListener('click', () => {
                if (!pendingDeleteId) return;

                fetch(`/history/delete/${pendingDeleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        const card = document.querySelector(`article[data-history-id="${pendingDeleteId}"]`);
                        card.classList.add('fade-out');
                        setTimeout(() => card.remove(), 400);

                        document.getElementById('confirmOverlay').classList.remove('show');
                        document.getElementById('numberofcards').textContent = data.numberofcards;
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: data.message, timer: 7000, showConfirmButton: false, background: '#1a1630', color: '#fff' });
                    })
                    .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: 'Action failed', background: '#1a1630', color: '#fff' }));
            });

            // --- 4. Language Filter ---
            document.getElementById('langFilter').addEventListener('change', function () {
                const lang = this.value;
                document.querySelectorAll('.history-card').forEach(card => {
                    card.style.display = (lang === 'all' || card.dataset.lang === lang) ? 'block' : 'none';
                });
            });
        });
    </script>
</body>

</html>