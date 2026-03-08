<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Syne:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --violet: #7D5FFF;
            --pink: #FF5FA3;
            --dark: #0D0B1A;
        }

        /* base */
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: #fff;
        }

        h1,
        h2,
        h3 {
            font-family: 'Syne', sans-serif;
        }

        /* gradient text */
        .grad-text {
            background: linear-gradient(135deg, #a78bff 0%, #FF5FA3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* background */
        .hero-bg {
            background:
                radial-gradient(ellipse 80% 60% at 70% 40%, rgba(125, 95, 255, .25) 0%, transparent 65%),
                radial-gradient(ellipse 60% 50% at 20% 80%, rgba(255, 95, 163, .18) 0%, transparent 60%),
                var(--dark);
        }

        /* cards */
        .feature-card {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .09);
            border-radius: 20px;
            transition: transform .3s, box-shadow .3s, border-color .3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(125, 95, 255, .4);
            box-shadow: 0 20px 60px rgba(125, 95, 255, .15);
        }

        /* gradient button */
        .grad-btn {
            background: linear-gradient(135deg, var(--violet), var(--pink));
            border: none;
            color: white;
            cursor: pointer;
            transition: opacity .2s, transform .2s, box-shadow .2s;
        }

        .grad-btn:hover {
            opacity: .9;
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(125, 95, 255, .45);
        }
    </style>

</head>

<body>

    <div class="hero-bg flex items-center justify-center px-6 py-32">


        <div class="max-w-6xl w-full text-center">

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Upgrade your <span class="grad-text">PostPilot</span>
            </h1>

            <p class="text-gray-400 mb-14 text-lg">
                Generate more captions and unlock powerful AI features
            </p>

            <!-- Plans -->
            <div class="grid md:grid-cols-3 gap-8">

                <!-- FREE PLAN -->
                <div class="feature-card p-8 rounded-2xl text-left opacity-70">

                    <h3 class="text-2xl mb-2">Free</h3>

                    <p class="text-gray-400 mb-6">
                        Perfect for testing PostPilot
                    </p>

                    <div class="text-4xl font-bold mb-6">
                        $0
                        <span class="text-gray-400 text-lg">/month</span>
                    </div>

                    <ul class="space-y-3 text-gray-300 mb-8">
                        <li>✔ 5 captions per month</li>
                        <li>✔ Basic AI captions</li>
                        <li>✖ No priority speed</li>
                        <li>✖ No premium tones</li>
                    </ul>

                    <button disabled class="w-full py-3 rounded-xl bg-gray-700 text-gray-400 cursor-not-allowed">
                        Current Plan
                    </button>

                </div>


                <!-- PILOT PLAN -->
                <div class="feature-card p-8 rounded-2xl text-left relative">

                    <span class="absolute top-4 right-4 text-xs px-3 py-1 rounded-full"
                        style="background:rgba(125,95,255,.2); color:#a78bff;">
                        Popular
                    </span>

                    <h3 class="text-2xl mb-2">Pilot</h3>

                    <p class="text-gray-400 mb-6">
                        For creators who post regularly
                    </p>

                    <div class="text-4xl font-bold mb-6">
                        $5.99
                        <span class="text-gray-400 text-lg">/month</span>
                    </div>

                    <ul class="space-y-3 text-gray-300 mb-8">
                        <li>✔ 600 captions per month</li>
                        <li>✔ All caption tones</li>
                        <li>✔ Faster AI generation</li>
                        <li>✔ Hashtag optimization</li>
                    </ul>
                    <button class="grad-btn w-full py-3 rounded-xl font-semibold">

                        <a href="/checkout/Pilot">
                            Upgrade to Pilot 🚀
                        </a>
                    </button>
                </div>


                <!-- CAPTAIN PLAN -->
                <div class="feature-card p-8 rounded-2xl text-left">

                    <h3 class="text-2xl mb-2">Captain</h3>

                    <p class="text-gray-400 mb-6">
                        Unlimited power for serious brands
                    </p>

                    <div class="text-4xl font-bold mb-6">
                        $19.99
                        <span class="text-gray-400 text-lg">/month</span>
                    </div>

                    <ul class="space-y-3 text-gray-300 mb-8">
                        <li>✔ Unlimited captions</li>
                        <li>✔ Premium AI quality</li>
                        <li>✔ Fastest generation</li>
                        <li>✔ Future AI tools included</li>
                    </ul>
                    <button class="grad-btn w-full py-3 rounded-xl font-semibold">
                        <a href="checkout/Captain">
                            Upgrade to Captain 🌟
                        </a>

                    </button>



                </div>

            </div>


            <!-- Bottom note -->
            <p class="text-gray-500 mt-10 text-sm">
                Secure payment • Cancel anytime
            </p>

        </div>

    </div>
</body>
<script>
    function upgradePlan(plan) {
        fetch(`/checkout/${plan}`)
            .then(res => res.json())
            .then(data => {
                if (data.url) {
                    window.location.href = data.url;
                    // redirect to Paddle checkout
                } else {
                    alert("Something went wrong.");
                }
            })
            .catch(err => console.error(err));
    }
</script>

</html>