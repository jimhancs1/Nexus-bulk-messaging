<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Bulk SMS, Email & WhatsApp for Business</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3); }
        .gradient-text {
            background: linear-gradient(90deg, #4F46E5, #06B6D4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-bg {
            background-color: #ffffff;
            background-image: radial-gradient(#e2e8f0 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }
        .code-block {
            background: #0f172a;
            color: #94a3b8;
            font-family: 'Fira Code', monospace;
        }
    </style>
</head>
<body class="bg-white text-slate-900 hero-bg">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-1.5 rounded-lg shadow-lg shadow-indigo-200">
                    <i data-lucide="layers" class="text-white w-5 h-5"></i>
                </div>
                <span class="text-xl font-bold tracking-tight uppercase">NEXUS</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="#features" class="hover:text-indigo-600 transition">Features</a>
                <a href="#solutions" class="hover:text-indigo-600 transition">Solutions</a>
                <a href="#pricing" class="hover:text-indigo-600 transition">Pricing</a>
                <a href="#docs" class="hover:text-indigo-600 transition">API Docs</a>
                <a href="signup.php" class="bg-slate-900 text-white px-5 py-2.5 rounded-full hover:bg-slate-800 transition shadow-lg shadow-slate-200">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="pt-40 pb-20 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold mb-8 border border-indigo-100">
                POWERING KENYAN BUSINESSES
            </span>
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-8 leading-[1.1]">
                Reach everyone, <br> <span class="gradient-text">everywhere instantly.</span>
            </h1>
            <p class="text-lg text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                The all-in-one unified platform for Bulk SMS, Professional Email, and WhatsApp. Inform employees, alert clients, or launch massive marketing campaigns with a single click.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="signup.php" class="w-full sm:w-auto bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 flex items-center justify-center gap-2">
                    Create Free Account <i data-lucide="send" class="w-5 h-5"></i>
                </a>
                <a href="#solutions" class="w-full sm:w-auto bg-white text-slate-700 px-8 py-4 rounded-2xl font-bold border border-slate-200 hover:bg-slate-50 transition">
                    See Use Cases
                </a>
            </div>
        </div>
    </header>

    <!-- Unified Channels Section -->
    <section id="features" class="py-24 px-6 bg-slate-50/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Unified Communication Channels</h2>
                <p class="text-slate-500">Stop juggling different providers. Manage everything from one dashboard.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Bulk SMS -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i data-lucide="message-square" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Bulk SMS</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Send branded alerts to thousands of contacts. Perfect for emergency updates, promotional offers, and school notifications.</p>
                    <ul class="text-xs space-y-2 text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3 h-3"></i> Branded Sender IDs</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3 h-3"></i> 99.9% Delivery Rate</li>
                    </ul>
                </div>
                <!-- WhatsApp Business -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i data-lucide="phone" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">WhatsApp Business</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Engage on the app your customers use most. Send rich media, PDF invoices, and automated service reminders.</p>
                    <ul class="text-xs space-y-2 text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3 h-3"></i> Verified Blue Tick Ready</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3 h-3"></i> Rich Media Support</li>
                    </ul>
                </div>
                <!-- Professional Email -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                        <i data-lucide="mail" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Email Marketing</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Design beautiful newsletters and internal memos. Reach the inbox every time with our high-reputation SMTP servers.</p>
                    <ul class="text-xs space-y-2 text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3 h-3"></i> Drag & Drop Builder</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3 h-3"></i> Detailed Open Tracking</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions/Use Cases -->
    <section id="solutions" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Built for every type of <br> organization</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-xl h-fit"><i data-lucide="graduation-cap"></i></div>
                            <div>
                                <h4 class="font-bold mb-1">Schools & Universities</h4>
                                <p class="text-slate-500 text-sm">Send exam results, fee reminders, and event alerts to parents and students instantly.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-cyan-100 text-cyan-600 p-3 rounded-xl h-fit"><i data-lucide="briefcase"></i></div>
                            <div>
                                <h4 class="font-bold mb-1">Corporate Internal Comms</h4>
                                <p class="text-slate-500 text-sm">Keep employees informed with policy updates, meeting schedules, and HR announcements.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-emerald-100 text-emerald-600 p-3 rounded-xl h-fit"><i data-lucide="shopping-bag"></i></div>
                            <div>
                                <h4 class="font-bold mb-1">Retail & E-commerce</h4>
                                <p class="text-slate-500 text-sm">Advertise new stock, send order confirmations, and run holiday sales via WhatsApp and SMS.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-indigo-500/10 rounded-[2rem] blur-2xl"></div>
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800" class="relative rounded-3xl shadow-2xl border border-slate-100" alt="Team meeting">
                </div>
            </div>
        </div>
    </section>

    <!-- Documentation Section -->
    <section id="docs" class="py-24 px-6 bg-slate-50/50">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <div class="code-block rounded-3xl p-8 shadow-2xl overflow-hidden relative">
                    <div class="flex gap-2 mb-6">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    </div>
                    <pre class="text-sm"><code><span class="text-slate-500">// Broadcast to all employees</span>
client.broadcast.create({
  channel: <span class="text-emerald-400">'whatsapp'</span>,
  contacts: <span class="text-emerald-400">'staff_group'</span>,
  template: <span class="text-emerald-400">'office_notice'</span>,
  vars: { <span class="text-indigo-300">date</span>: <span class="text-emerald-400">'Tomorrow'</span> }
});</code></pre>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <h2 class="text-3xl font-bold mb-6">Seamless API Integration</h2>
                <p class="text-slate-500 mb-8 leading-relaxed">
                    Connect your existing ERP, CRM, or HR system to Nexus in minutes. Our REST API allows you to automate notifications based on system triggers.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-white rounded-2xl border border-slate-200">
                        <div class="font-bold text-indigo-600 mb-1">SDKs</div>
                        <p class="text-xs text-slate-400">PHP, Python, Node.js</p>
                    </div>
                    <div class="p-4 bg-white rounded-2xl border border-slate-200">
                        <div class="font-bold text-indigo-600 mb-1">Webhooks</div>
                        <p class="text-xs text-slate-400">Real-time callbacks</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Pricing for Every Scale</h2>
                <p class="text-slate-500">No monthly fees for basic use. Pay only for what you send.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Basic -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
                    <h3 class="text-xl font-bold mb-2">SME Starter</h3>
                    <p class="text-slate-400 text-sm mb-6">For small business advertising</p>
                    <div class="text-4xl font-bold mb-8">Ksh 1,500 <span class="text-sm font-normal text-slate-400">/mo</span></div>
                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> 1,000 SMS Credits</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Basic Email Tool</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Shared WhatsApp No.</li>
                    </ul>
                    <button class="w-full py-4 rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition font-bold">Get Started</button>
                </div>
                <!-- Pro -->
                <div class="bg-white p-8 rounded-3xl border-2 border-indigo-600 shadow-xl flex flex-col relative scale-105">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Recommended</div>
                    <h3 class="text-xl font-bold mb-2">Organization</h3>
                    <p class="text-slate-400 text-sm mb-6">For schools & corporations</p>
                    <div class="text-4xl font-bold mb-8">Ksh 7,500 <span class="text-sm font-normal text-slate-400">/mo</span></div>
                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> 10,000 SMS Credits</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Custom Branded SMS ID</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Professional SMTP</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> 24/7 Priority Support</li>
                    </ul>
                    <button class="w-full py-4 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition font-bold">Choose Pro</button>
                </div>
                <!-- Enterprise -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
                    <h3 class="text-xl font-bold mb-2">Enterprise</h3>
                    <p class="text-slate-400 text-sm mb-6">High volume advertising</p>
                    <div class="text-4xl font-bold mb-8">Custom</div>
                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Unlimited Credits</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Dedicated Server</li>
                        <li class="flex items-center gap-3 text-sm text-slate-600"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Whitelabel Dashboard</li>
                    </ul>
                    <button class="w-full py-4 rounded-xl bg-slate-100 text-slate-900 hover:bg-slate-200 transition font-bold">Contact Sales</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 px-6 bg-slate-900 text-white rounded-[3rem] mx-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Trusted by 500+ Organizations</h2>
                <p class="text-slate-400 italic">"The speed of information flow has improved our operations by 40%."</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700">
                    <p class="text-slate-300 text-sm mb-6">"Nexus helped our school manage fee communications during the busy admission season. The bulk SMS delivery is instant!"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold">BM</div>
                        <div>
                            <div class="font-bold text-sm">Benson Mwangi</div>
                            <div class="text-xs text-slate-500">Principal, Highridge Academy</div>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700">
                    <p class="text-slate-300 text-sm mb-6">"Our marketing campaigns on WhatsApp have seen a 5x increase in engagement compared to traditional ads. Simply amazing."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center font-bold">JW</div>
                        <div>
                            <div class="font-bold text-sm">Jane Wambui</div>
                            <div class="text-xs text-slate-500">Marketing, Glow Beauty Kenya</div>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700">
                    <p class="text-slate-300 text-sm mb-6">"Reliable internal memos for our 200+ employees across the country. The email open-tracking is a game changer for HR."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-cyan-500 flex items-center justify-center font-bold">PO</div>
                        <div>
                            <div class="font-bold text-sm">Peter Otieno</div>
                            <div class="text-xs text-slate-500">HR Director, LogiLink Ltd</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 mt-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-2">
                <div class="bg-slate-900 p-1.5 rounded"><i data-lucide="layers" class="text-white w-4 h-4"></i></div>
                <span class="font-bold text-sm tracking-widest uppercase">NEXUS</span>
            </div>
            <p class="text-slate-400 text-xs">© 2025 Nexus Communication. Empowering organizations across Africa.</p>
            <div class="flex gap-6">
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition"><i data-lucide="linkedin" class="w-5 h-5"></i></a>
            </div>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>