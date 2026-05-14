<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MedicalStore</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Sora', 'sans-serif'],
                    },
                    colors: {
                        teal: {
                            50: '#E1F5EE',
                            100: '#9FE1CB',
                            200: '#5DCAA5',
                            300: '#5DCAA5',
                            400: '#1D9E75',
                            500: '#17836',
                            600: '#0F6E56',
                            700: '#085041',
                            800: '#04342C',
                            900: '#02211C',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --sidebar-w: 260px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #sidebar {
            background: linear-gradient(180deg, #04342C 0%, #085041 100%);
            width: var(--sidebar-w);
        }

        #sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='20' cy='20' r='10' fill='%239FE1CB' fill-opacity='0.04'/%3E%3C/svg%3E");
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            border-left: 3px solid #5DCAA5;
            padding-left: 13px !important;
        }

        .sidebar-link.active i {
            color: #5DCAA5;
        }

        .sidebar-link:hover:not(.active) {
            background: rgba(255, 255, 255, 0.08);
            color: #fff !important;
        }

        #header {
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
        }

        .online-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.25);
        }

        #main-content {
            margin-left: var(--sidebar-w);
            margin-top: 64px;
        }

        #footer {
            margin-left: var(--sidebar-w);
        }

        @media (max-width: 991px) {
            #sidebar {
                transform: translateX(-100%);
                transition: transform .3s;
            }

            #sidebar.open {
                transform: translateX(0);
            }

            #main-content,
            #footer {
                margin-left: 0 !important;
            }

            #header {
                padding-left: 1rem !important;
            }
        }
    </style>
</head>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<body class="bg-gray-50">

    <!-- MOBILE OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black/40 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full z-30 flex flex-col shadow-2xl"
        style="width:var(--sidebar-w); position:fixed;">

        <!-- Logo -->
        <div class="px-5 py-5 border-b border-white/10 flex items-center gap-3 flex-shrink-0">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg border border-white/15"
                style="background:rgba(255,255,255,0.15);">
                <i class="bi bi-capsule-pill text-teal-300" style="color:#5DCAA5;"></i>
            </div>
            <div>
                <h1 class="font-display text-white font-bold text-base leading-none"
                    style="font-family:'Sora',sans-serif;">AniketPharmacy</h1>
                <p class="text-xs mt-1" style="color:#5DCAA5;">Management System</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-5 overflow-y-auto" style="scrollbar-width:none;">

            <p class="text-xs font-bold uppercase tracking-widest mb-3 px-3"
                style="color:rgba(255,255,255,0.35); letter-spacing:.1em;">Main Menu</p>

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.dashboard') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-speedometer2 w-4 text-center" style="color:#5DCAA5;"></i> Dashboard
            </a>

            {{-- Add Medicine --}}
            <a href="{{ route('admin.medicines.create') }}"
                class="sidebar-link {{ request()->routeIs('admin.medicines.create') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.medicines.create') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-plus-circle w-4 text-center" style="color:#5DCAA5;"></i> Add Medicine
            </a>

            {{-- Manage Medicines --}}
            <a href="{{ route('admin.medicines.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.medicines.index') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.medicines.index') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-archive w-4 text-center" style="color:#5DCAA5;"></i> Manage Medicines
            </a>

            {{-- Categories --}}
            <a href="{{ route('admin.categories.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.categories.*') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-grid w-4 text-center" style="color:#5DCAA5;"></i> Categories
            </a>

            {{-- Subcategories --}}
            <a href="{{ route('admin.subcategories.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.subcategories.*') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-diagram-3 w-4 text-center" style="color:#5DCAA5;"></i> Subcategories
            </a>

            {{-- Billing System --}}
            <a href="{{ route('admin.billing.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.billing.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.billing.*') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-receipt w-4 text-center" style="color:#5DCAA5;"></i> Billing System
            </a>

            {{-- Reports --}} --
            <a href="{{ route('admin.reports.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
                style="color:{{ request()->routeIs('admin.reports.*') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
                <i class="bi bi-bar-chart-line w-4 text-center" style="color:#5DCAA5;"></i> Reports
            </a>

            <hr class="my-4 border-white/10" />

            <p class="text-xs font-bold uppercase tracking-widest mb-3 px-3"
                style="color:rgba(255,255,255,0.35); letter-spacing:.1em;">Account</p>

            {{-- Settings --}}
            {{-- <a href="{{ route('admin.settings.index') }}"
        class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
        style="color:{{ request()->routeIs('admin.settings.*') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
        <i class="bi bi-gear w-4 text-center" style="color:#5DCAA5;"></i> Settings
    </a> --}}

            {{-- Help & Support --}}
            {{-- <a href="{{ route('admin.help.index') }}"
        class="sidebar-link {{ request()->routeIs('admin.help.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mb-1 transition-all duration-150"
        style="color:{{ request()->routeIs('admin.help.*') ? '#fff' : 'rgba(255,255,255,0.65)' }}; text-decoration:none;">
        <i class="bi bi-question-circle w-4 text-center" style="color:#5DCAA5;"></i> Help &amp; Support
    </a> --}}

            {{-- Logout --}}
            <a onclick="confirmLogout()"
                class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer text-sm font-medium mt-1 transition-all duration-150"
                style="color:rgba(252,135,135,0.85); text-decoration:none;">
                <i class="bi bi-box-arrow-right w-4 text-center"></i> Logout
            </a>

        </nav>

        <!-- User chip -->
        <div class="px-3 py-4 border-t border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3 rounded-xl px-3 py-2.5"
                style="background:rgba(255,255,255,0.09); border:1px solid rgba(255,255,255,0.1);">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0"
                    style="background:linear-gradient(135deg,#5DCAA5,#0F6E56); color:#02211C;">A</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white leading-none">Aniket</p>
                    <p class="text-xs mt-0.5" style="color:#5DCAA5;">Store Manager</p>
                </div>
                <div class="online-dot flex-shrink-0"></div>
            </div>
        </div>

    </aside>

    <!-- HEADER -->
    <header id="header" class="fixed top-0 right-0 z-20 flex items-center bg-white px-5 gap-4"
        style="left:var(--sidebar-w); height:64px; border-bottom:1px solid #e2ece9;">

        <!-- Mobile toggle -->
        <button class="d-lg-none btn p-0 border-0 me-2" onclick="toggleSidebar()">
            <i class="bi bi-list fs-4 text-teal-700"></i>
        </button>

        <!-- Search -->
        <div class="flex items-center gap-2 flex-1 max-w-sm rounded-xl px-3 py-2"
            style="background:#f0f4f3; border:1px solid #dce8e4;">
            <i class="bi bi-search text-sm" style="color:#8aada5;"></i>
            <input type="text" placeholder="Search medicines, orders…"
                class="bg-transparent border-0 outline-none text-sm flex-1"
                style="color:#1a2e2a; font-family:inherit;" onfocus="this.parentElement.style.borderColor='#1D9E75'"
                onblur="this.parentElement.style.borderColor='#dce8e4'" />
        </div>

        <!-- Right actions -->
        <div class="flex items-center gap-2 ms-auto">

            <!-- Notifications -->
            <div class="dropdown">
                <button class="position-relative flex items-center justify-center rounded-xl border bg-white"
                    style="width:40px;height:40px;border-color:#e2ece9;color:#4a7a6e;" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-bell" style="font-size:16px;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                        style="background:#1D9E75;font-size:10px;">4</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                    style="min-width:280px;border-radius:12px;">
                    <li class="px-3 pt-2 pb-1">
                        <span class="fw-bold text-sm" style="color:#0d2b24;">Notifications</span>
                        <span class="badge ms-2 rounded-pill" style="background:#e1f5ee;color:#0F6E56;">4 new</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-start gap-2" href="#">
                            <i class="bi bi-exclamation-circle text-warning mt-1"></i>
                            <div>
                                <p class="mb-0 text-sm fw-medium" style="color:#0d2b24;">Low stock alert</p>
                                <p class="mb-0 text-xs text-muted">Insulin Glargine — 2 units left</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-start gap-2" href="#">
                            <i class="bi bi-check-circle text-success mt-1"></i>
                            <div>
                                <p class="mb-0 text-sm fw-medium" style="color:#0d2b24;">Order completed</p>
                                <p class="mb-0 text-xs text-muted">Invoice #1042 has been paid</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-start gap-2" href="#">
                            <i class="bi bi-x-circle text-danger mt-1"></i>
                            <div>
                                <p class="mb-0 text-sm fw-medium" style="color:#0d2b24;">Expiry warning</p>
                                <p class="mb-0 text-xs text-muted">9 medicines expire within 30 days</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li class="px-3 pb-2 text-center">
                        <a href="#" class="text-xs fw-semibold"
                            style="color:#1D9E75;text-decoration:none;">View all notifications</a>
                    </li>
                </ul>
            </div>

            <!-- Messages -->
            <div class="dropdown">
                <button class="position-relative flex items-center justify-center rounded-xl border bg-white"
                    style="width:40px;height:40px;border-color:#e2ece9;color:#4a7a6e;" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-chat-left-text" style="font-size:16px;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                        style="background:#e53e5b;font-size:10px;">3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                    style="min-width:280px;border-radius:12px;">
                    <li class="px-3 pt-2 pb-1">
                        <span class="fw-bold text-sm" style="color:#0d2b24;">Messages</span>
                        <span class="badge ms-2 rounded-pill" style="background:#fde8ed;color:#c93254;">3 new</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="#">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-xs"
                                style="width:34px;height:34px;background:#e1f5ee;color:#085041;">MH</div>
                            <div>
                                <p class="mb-0 text-sm fw-medium" style="color:#0d2b24;">Maria Hudson</p>
                                <p class="mb-0 text-xs text-muted">New order request placed…</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="#">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-xs"
                                style="width:34px;height:34px;background:#faeeda;color:#854f0b;">AN</div>
                            <div>
                                <p class="mb-0 text-sm fw-medium" style="color:#0d2b24;">Anna Nelson</p>
                                <p class="mb-0 text-xs text-muted">Payment confirmed, thanks!</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="#">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-xs"
                                style="width:34px;height:34px;background:#e6f1fb;color:#185fa5;">DM</div>
                            <div>
                                <p class="mb-0 text-sm fw-medium" style="color:#0d2b24;">David Muldon</p>
                                <p class="mb-0 text-xs text-muted">Delivery scheduled for tomorrow</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li class="px-3 pb-2 text-center">
                        <a href="#" class="text-xs fw-semibold"
                            style="color:#1D9E75;text-decoration:none;">View all messages</a>
                    </li>
                </ul>
            </div>

            <!-- Profile -->
            <div class="dropdown">
                <button class="flex items-center gap-2 rounded-xl px-3 py-2 border bg-white"
                    style="border-color:#e2ece9;font-family:inherit;" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0"
                        style="width:32px;height:32px;background:linear-gradient(135deg,#1D9E75,#085041);color:#fff;">
                        AS</div>
                    <div class="text-start d-none d-md-block">
                        <p class="mb-0 text-xs fw-semibold" style="color:#1a2e2a;">Aniket Singh</p>
                        <p class="mb-0" style="font-size:10px;color:#6b9e93;">Store Manager</p>
                    </div>
                    <i class="bi bi-chevron-down ms-1" style="font-size:11px;color:#6b9e93;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                    style="min-width:200px;border-radius:12px;">
                    <li class="px-3 pt-2 pb-1">
                        <p class="mb-0 fw-bold text-sm" style="color:#0d2b24;">Aniket Singh</p>
                        <p class="mb-0 text-xs text-muted">Web Designer</p>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 text-sm"
                            href="users-profile.html">
                            <i class="bi bi-person" style="color:#1D9E75;"></i> My Profile</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 text-sm"
                            href="users-profile.html">
                            <i class="bi bi-gear" style="color:#1D9E75;"></i> Account Settings</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 text-sm" href="pages-faq.html">
                            <i class="bi bi-question-circle" style="color:#1D9E75;"></i> Need Help?</a></li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    {{-- ✅ Sign Out in dropdown also uses confirmLogout() --}}
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 text-sm" href="#"
                            onclick="confirmLogout()" style="color:#e53e5b;">
                            <i class="bi bi-box-arrow-right"></i> Sign Out</a></li>
                </ul>
            </div>

        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main id="main-content" class="p-6 min-vh-100">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer id="footer" class="flex items-center justify-between px-6 py-3 bg-white border-t"
        style="border-color:#e2ece9;">
        <p class="mb-0 text-xs" style="color:#6b9e93;">
            &copy; <span id="yr"></span> <strong style="color:#0d2b24;">MediStore</strong>. All Rights
            Reserved.
        </p>
        <p class="mb-0 text-xs" style="color:#6b9e93;">
            Designed by <a href="https://bootstrapmade.com/"
                style="color:#1D9E75;font-weight:600;text-decoration:none;">BootstrapMade</a>
        </p>
    </footer>

    {{-- ✅ HIDDEN LOGOUT FORM — submits POST to admin.logout route --}}
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <script>
        // Year
        document.getElementById('yr').textContent = new Date().getFullYear();

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        }

        // Active sidebar link
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // showPage stub
        function showPage(page) {
            console.log('Navigate to:', page);
        }

        // ✅ FIXED: confirmLogout() — submits POST form instead of GET redirect
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>

</body>

</html>
