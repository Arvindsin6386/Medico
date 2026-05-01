<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Medico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f4f8;
            overflow: hidden;
            position: relative;
        }

        /* ── Animated background ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, #c8eaf7 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 90%, #d4f0e8 0%, transparent 55%),
                radial-gradient(ellipse 50% 60% at 60% 40%, #e8f4fd 0%, transparent 50%),
                linear-gradient(145deg, #e8f5fd 0%, #f5fbf8 40%, #edf8f2 100%);
            z-index: 0;
            animation: bgShift 12s ease-in-out infinite alternate;
        }

        @keyframes bgShift {
            0%   { filter: hue-rotate(0deg) brightness(1); }
            100% { filter: hue-rotate(10deg) brightness(1.03); }
        }

        /* ── Floating pill decorations ── */
        .deco {
            position: fixed;
            border-radius: 50%;
            opacity: 0.18;
            animation: floatUp 18s ease-in-out infinite;
            z-index: 0;
        }
        .deco-1 { width: 280px; height: 280px; background: #0ea5e9; top: -60px; left: -80px; animation-delay: 0s; }
        .deco-2 { width: 180px; height: 180px; background: #10b981; bottom: 60px; right: -40px; animation-delay: -6s; }
        .deco-3 { width: 120px; height: 120px; background: #6366f1; top: 50%; right: 80px; animation-delay: -3s; }
        .deco-4 { width: 90px;  height: 90px;  background: #f59e0b; bottom: 20%; left: 60px; animation-delay: -9s; }

        @keyframes floatUp {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        /* ── Tagline banner above card ── */
        .tagline-wrap {
            text-align: center;
            margin-bottom: 1.6rem;
            animation: fadeSlideDown 0.8s ease both;
        }
        .tagline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            padding: 0.45rem 1.1rem;
            border-radius: 999px;
            box-shadow: 0 4px 18px rgba(14,165,233,.30);
            margin-bottom: 0.55rem;
        }
        .tagline-badge i { font-size: 0.95rem; }
        .tagline-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0369a1, #065f46);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.25;
        }
        .tagline-sub {
            font-size: 0.82rem;
            color: #64748b;
            margin-top: 0.3rem;
            letter-spacing: 0.01em;
        }

        /* ── Card ── */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 1.5rem;
            animation: fadeSlideUp 0.7s ease both;
        }

        @keyframes fadeSlideUp   { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeSlideDown { from { opacity:0; transform:translateY(-18px);} to { opacity:1; transform:translateY(0); } }

        .card {
            border: none !important;
            border-radius: 1.5rem !important;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            box-shadow:
                0 2px 0 rgba(255,255,255,.9) inset,
                0 20px 60px rgba(14,165,233,.13),
                0 4px 24px rgba(0,0,0,.06);
        }

        /* ── Brand header ── */
        .brand-icon {
            width: 68px; height: 68px;
            background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
            border-radius: 1.1rem;
            display: inline-flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(14,165,233,.35);
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow: 0 8px 24px rgba(14,165,233,.35); }
            50%      { box-shadow: 0 8px 32px rgba(14,165,233,.55); }
        }
        .brand-icon i { font-size: 2rem; color: #fff; }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0369a1, #047857);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Labels ── */
        .form-label { font-size: 0.78rem; font-weight: 600; color: #374151; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 0.4rem; }

        /* ── Input groups ── */
        .field-wrap {
            position: relative;
            border-radius: 0.75rem;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            transition: border-color .2s, box-shadow .2s, background .2s;
            overflow: hidden;
        }
        .field-wrap:focus-within {
            border-color: #0ea5e9;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(14,165,233,.12);
        }
        .field-wrap .fi {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1rem; pointer-events: none;
            transition: color .2s;
        }
        .field-wrap:focus-within .fi { color: #0ea5e9; }
        .field-wrap input {
            width: 100%;
            border: none;
            background: transparent;
            padding: 0.75rem 1rem 0.75rem 2.6rem;
            font-size: 0.9rem;
            color: #1e293b;
            outline: none;
            font-family: 'DM Sans', sans-serif;
        }
        .field-wrap input::placeholder { color: #cbd5e1; }

        /* ── Password toggle ── */
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94a3b8; cursor: pointer;
            font-size: 1rem; padding: 0; transition: color .2s;
        }
        .toggle-pw:hover { color: #0ea5e9; }

        /* ── Remember / forgot row ── */
        .form-check-input { accent-color: #0ea5e9; }
        .form-check-label  { font-size: 0.82rem; color: #64748b; }
        .forgot-link { font-size: 0.82rem; color: #0ea5e9; text-decoration: none; font-weight: 500; }
        .forgot-link:hover { color: #0369a1; text-decoration: underline; }

        /* ── Submit button ── */
        .btn-signin {
            width: 100%;
            padding: 0.78rem;
            border: none;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.04em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(14,165,233,.35);
            transition: transform .15s, box-shadow .15s;
        }
        .btn-signin::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #38bdf8, #34d399);
            opacity: 0; transition: opacity .25s;
        }
        .btn-signin:hover  { transform: translateY(-1px); box-shadow: 0 10px 28px rgba(14,165,233,.45); }
        .btn-signin:hover::before { opacity: 1; }
        .btn-signin:active { transform: translateY(0); }
        .btn-signin span   { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: .5rem; }

        /* ── Divider ── */
        .divider-text {
            display: flex; align-items: center; gap: .75rem;
            font-size: 0.75rem; color: #94a3b8; margin: 1.2rem 0;
        }
        .divider-text::before, .divider-text::after {
            content: ''; flex: 1; height: 1px; background: #e2e8f0;
        }

        /* ── Footer note ── */
        .secure-note {
            text-align: center;
            font-size: 0.74rem;
            color: #94a3b8;
            display: flex; align-items: center; justify-content: center; gap: .35rem;
            margin-top: 1rem;
        }
        .secure-note i { color: #10b981; }
    </style>
</head>
<body>

    <!-- Decorative blobs -->
    <div class="deco deco-1"></div>
    <div class="deco deco-2"></div>
    <div class="deco deco-3"></div>
    <div class="deco deco-4"></div>

    <div class="login-wrapper">

        <!-- ── Tagline above the card ── -->
        <div class="tagline-wrap">
            {{-- <div class="tagline-badge">
                <i class="bi bi-capsule-pill"></i>
                Your Health, Our Priority
            </div> --}}
            <div class="tagline-heading">Where Every Medicine<br>Finds Its Purpose</div>
            <p class="tagline-sub">Trusted pharmacy management — accurate, fast &amp; compassionate care.</p>
        </div>

        <!-- ── Login Card ── -->
        <div class="card">
            <div class="card-body p-4 p-md-5">

                <!-- Brand -->
                <div class="text-center mb-4">
                    <div class="brand-icon mb-3">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <div class="brand-title">Medico</div>
                    <p class="text-muted small mt-1" style="font-size:.78rem; letter-spacing:.04em;">ADMIN ACCESS ONLY</p>
                </div>
                {{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    {{-- <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="field-wrap">
                            <i class="bi bi-person fi"></i>
                            <input type="text" name="name" placeholder="Enter your username" required>
                        </div>
                    </div> --}}

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <div class="field-wrap">
                            <i class="bi bi-envelope fi"></i>
                            <input type="email" name="email" id="email" placeholder="name@company.com" required autofocus>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0">Password</label>
                            <a href="#" class="forgot-link">Forgot password?</a>
                        </div>
                        <div class="field-wrap">
                            <i class="bi bi-shield-lock fi"></i>
                            <input type="password" name="password" id="password" placeholder="••••••••" required>
                            <button type="button" class="toggle-pw" onclick="togglePw()">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember me -->
                    <div class="form-check mb-4 mt-1">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me on this device</label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-signin">
                        <span><i class="bi bi-box-arrow-in-right"></i> Sign In to Dashboard</span>
                    </button>

                </form>

                <div class="secure-note">
                    <i class="bi bi-shield-check-fill"></i>
                    256-bit encrypted &amp; HIPAA-compliant session
                </div>

            </div>
        </div>

    </div>

    <script>
        function togglePw() {
            const pw = document.getElementById('password');
            const ic = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                ic.className = 'bi bi-eye-slash';
            } else {
                pw.type = 'password';
                ic.className = 'bi bi-eye';
            }
        }
    </script>

</body>
</html>