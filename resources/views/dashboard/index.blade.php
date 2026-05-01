@extends('layouts.app')
@section('content')

    <style>
  .dash-wrap { font-family: 'Plus Jakarta Sans', sans-serif; }
 
  /* ── HERO BANNER ── */
  .hero-banner {
    position: relative;
    width: 100%;
    min-height: 220px;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 28px;
    display: flex;
    align-items: flex-end;
    background-color: #04342C;
  }
 
  /* Real pharmacy/medical store photo from Unsplash */
  .hero-bg {
    position: absolute; inset: 0;
    background-image: url('https://images.unsplash.com/photo-1585435557343-3b092031a831?w=1400&q=80');
    background-size: cover;
    background-position: center;
    filter: brightness(0.55);
  }
 
  /* Gradient overlay so text is readable */
  .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
      90deg,
      rgba(4, 52, 44, 0.85) 0%,
      rgba(4, 52, 44, 0.40) 60%,
      rgba(4, 52, 44, 0.10) 100%
    );
  }
 
  .hero-content {
    position: relative; z-index: 2;
    padding: 36px 36px 32px;
  }
  .hero-greeting {
    font-size: 12px; font-weight: 700;
    color: #5DCAA5; letter-spacing: .1em;
    text-transform: uppercase; margin-bottom: 8px;
  }
  .hero-title {
    font-family: 'Sora', sans-serif;
    font-size: 26px; font-weight: 700;
    color: #fff; line-height: 1.25; margin-bottom: 6px;
  }
  .hero-sub {
    font-size: 13px; color: rgba(255,255,255,0.65);
  }
  .hero-sub i { margin-right: 4px; }
 
  /* decorative pill badge on right */
  .hero-badge {
    position: absolute; top: 28px; right: 32px; z-index: 2;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(6px);
    border-radius: 12px; padding: 10px 18px;
    text-align: center;
  }
  .hero-badge-num {
    font-family: 'Sora', sans-serif;
    font-size: 22px; font-weight: 700; color: #fff; line-height: 1;
  }
  .hero-badge-lbl {
    font-size: 11px; color: rgba(255,255,255,0.65);
    margin-top: 3px; font-weight: 500;
  }
 
  /* ── STAT CARDS ── */
  .cards-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  @media(max-width: 600px) { .cards-row { grid-template-columns: 1fr; } }
 
  .stat-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2ece9;
    padding: 26px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    transition: box-shadow .2s, transform .2s;
  }
  .stat-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.09);
    transform: translateY(-3px);
  }
 
  .stat-icon {
    width: 58px; height: 58px;
    border-radius: 15px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0;
  }
  .si-teal { background: #e1f5ee; color: #1D9E75; }
  .si-blue { background: #e6f1fb; color: #185fa5; }
 
  .stat-label {
    font-size: 13px; color: #6b9e93;
    font-weight: 500; margin-bottom: 5px;
  }
  .stat-value {
    font-family: 'Sora', sans-serif;
    font-size: 28px; font-weight: 700;
    color: #0d2b24; line-height: 1;
  }
  .stat-badge {
    display: inline-block;
    margin-top: 8px;
    font-size: 11.5px; font-weight: 700;
    padding: 3px 10px; border-radius: 20px;
  }
  .badge-up   { background: #eaf3de; color: #3b6d11; }
  .badge-blue { background: #e6f1fb; color: #185fa5; }
 
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-up  { animation: fadeUp .45s ease both; }
  .delay-1  { animation-delay: .05s; }
  .delay-2  { animation-delay: .12s; }
  .delay-3  { animation-delay: .20s; }
</style>
 
<div class="dash-wrap">
 
  <!-- ── HERO BANNER ── -->
  <div class="hero-banner fade-up delay-1">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
 
    <div class="hero-badge d-none d-md-block">
      <div class="hero-badge-num">24/7</div>
      <div class="hero-badge-lbl">Store Active</div>
    </div>
 
    <div class="hero-content">
      <div class="hero-greeting"><i class="bi bi-shield-check me-1"></i> Aniket Pharmacy</div>
      <div class="hero-title">Welcome back,👋</div>
      <div class="hero-sub">
        <i class="bi bi-calendar3"></i>
        {{ now()->format('l, d F Y') }}
        &nbsp;·&nbsp; Here's your store overview for today.
      </div>
    </div>
  </div>
 
  <!-- ── STAT CARDS ── -->
  <div class="cards-row">
 
    <!-- Total Stock -->
    <div class="stat-card fade-up delay-2">
      <div class="stat-icon si-teal">
        <i class="bi bi-capsule-pill"></i>
      </div>
      <div>
        <div class="stat-label">Total Stock</div>
        <div class="stat-value">{{ $totalStock ?? '1,284' }}</div>
        <span class="stat-badge badge-up">↑ 12 added this week</span>
      </div>
    </div>
 
    <!-- Total Bill -->
    <div class="stat-card fade-up delay-3">
      <div class="stat-icon si-blue">
        <i class="bi bi-receipt-cutoff"></i>
      </div>
      <div>
        <div class="stat-label">Total Bills</div>
        <div class="stat-value">₹{{ $totalBill ?? '18,450' }}</div>
        <span class="stat-badge badge-blue">Today's revenue</span>
      </div>
    </div>
 
  </div>
 
</div>
</style>
@endsection