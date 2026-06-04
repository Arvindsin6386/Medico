@extends('layouts.app')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

<style>
  :root {
    --bg:           #f1f5f9;
    --surface:      #ffffff;
    --surface-2:    #f8fafc;
    --border:       #e2e8f0;
    --border-soft:  #f1f5f9;
    --accent:       #1D9E75;
    --accent-dim:   #157a58;
    --accent-glow:  rgba(29,158,117,.18);
    --accent-soft:  rgba(29,158,117,.09);
    --text-primary: #0d1f18;
    --text-muted:   #64748b;
    --text-faint:   #94a3b8;
    --danger:       #ef4444;
    --danger-soft:  rgba(239,68,68,.09);
    --success-soft: rgba(29,158,117,.09);
    --radius:       16px;
    --radius-sm:    10px;
    --shadow:       0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.07);
    --shadow-sm:    0 1px 2px rgba(0,0,0,.05);
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    background: var(--bg);
    font-family: 'DM Sans', sans-serif;
    color: var(--text-primary);
    min-height: 100vh;
  }

  /* ── ALERTS ── */
  .cat-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 18px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    margin-bottom: 16px;
    border: 1px solid transparent;
    animation: slideDown .3s ease;
  }
  .cat-alert-success { background: #ecfdf5; border-color: var(--accent-dim); color: #065f46; }
  .cat-alert-danger  { background: #fef2f2; border-color: #fca5a5; color: #991b1b; }
  .cat-alert .cat-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    font-size: 16px;
    opacity: .6;
    line-height: 1;
  }
  .cat-alert .cat-alert-close:hover { opacity: 1; }
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── PAGE WRAPPER ── */
  .cat-page { padding: 36px 32px; max-width: 1300px; }

  /* ── HERO BANNER ── */
  .page-hero {
    background: linear-gradient(135deg, #0d2b22 0%, #1a4d38 45%, #0f3d2d 100%);
    border-radius: 20px;
    padding: 32px 32px 0;
    margin-bottom: 0;
    position: relative;
    overflow: hidden;
  }
  .page-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(29,158,117,.25) 0%, transparent 70%);
    border-radius: 50%;
  }
  .page-hero::after {
    content: '';
    position: absolute;
    bottom: 20px; left: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(52,211,153,.10) 0%, transparent 70%);
    border-radius: 50%;
  }

  .hero-crumb {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
    color: rgba(255,255,255,.45);
    margin-bottom: 14px;
    letter-spacing: .3px;
  }
  .hero-crumb span { color: rgba(255,255,255,.75); }
  .hero-crumb svg  { width: 12px; height: 12px; }

  .hero-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    position: relative; z-index: 1;
  }
  .hero-title-block { display: flex; flex-direction: column; gap: 6px; }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(29,158,117,.22);
    border: 1px solid rgba(29,158,117,.35);
    color: #5dffc0;
    border-radius: 20px;
    padding: 3px 11px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .5px;
    text-transform: uppercase;
    width: fit-content;
    margin-bottom: 4px;
  }
  .hero-badge::before {
    content: '';
    width: 6px; height: 6px;
    background: #34d399;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
  }
  @keyframes pulse-dot {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .5; transform: scale(.75); }
  }

  .hero-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 28px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -.5px;
    line-height: 1.15;
  }
  .hero-title em { font-style: normal; color: #34d399; }

  .hero-subtitle {
    font-size: 13px;
    color: rgba(255,255,255,.5);
    font-weight: 400;
  }

  .hero-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1D9E75;
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 12px 22px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(29,158,117,.4);
    white-space: nowrap;
    align-self: center;
  }
  .hero-add-btn:hover {
    background: #22c891;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(29,158,117,.5);
  }
  .hero-add-btn svg { width: 16px; height: 16px; }

  /* stat strip */
  .hero-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: rgba(255,255,255,.07);
    border-radius: 14px 14px 0 0;
    margin-top: 28px;
    overflow: hidden;
    position: relative; z-index: 1;
  }
  .hero-stat {
    padding: 20px 24px;
    background: rgba(255,255,255,.04);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: background .2s;
  }
  .hero-stat:hover { background: rgba(255,255,255,.08); }

  .hero-stat-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .hero-stat-icon svg { width: 20px; height: 20px; }
  .icon-total    { background: rgba(99,179,237,.15);  color: #63b3ed; }
  .icon-active   { background: rgba(52,211,153,.15);  color: #34d399; }
  .icon-inactive { background: rgba(252,129,129,.15); color: #fc8181; }

  .hero-stat-info { display: flex; flex-direction: column; gap: 2px; }
  .hero-stat-val {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 26px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
  }
  .hero-stat-label {
    font-size: 11px;
    color: rgba(255,255,255,.45);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .7px;
  }

  /* ── FILTER BAR ── */
  .filter-bar {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 0 0 16px 16px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
    flex-wrap: wrap;
    border-top: none;
  }
  .filter-input-wrap { position: relative; flex: 1; min-width: 180px; }
  .filter-input-wrap svg {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    width: 14px; height: 14px;
    color: var(--text-faint);
    pointer-events: none;
  }
  .filter-input, .filter-select {
    width: 100%;
    background: #f8fafc;
    border: 1.5px solid var(--border);
    color: var(--text-primary);
    border-radius: var(--radius-sm);
    padding: 9px 12px 9px 36px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
  }
  .filter-select { padding-left: 12px; min-width: 145px; flex: none; }
  .filter-input:focus, .filter-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
    background: #fff;
  }
  .filter-input::placeholder { color: var(--text-faint); }
  .filter-select option { background: #fff; }

  .filter-reset-btn {
    background: transparent;
    border: 1.5px solid var(--border);
    color: var(--text-muted);
    border-radius: var(--radius-sm);
    padding: 9px 16px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
    flex: none;
  }
  .filter-reset-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-soft); }

  /* ── TABLE CARD ── */
  .table-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
  }
  .table-responsive { overflow-x: auto; }

  table.cat-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }
  .cat-table thead tr {
    background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 2px solid #e2e8f0;
  }
  .cat-table thead th {
    padding: 14px 16px;
    font-size: 11px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #64748b;
    white-space: nowrap;
    text-align: left;
  }
  .cat-table tbody tr {
    border-bottom: 1px solid var(--border-soft);
    transition: background .15s;
  }
  .cat-table tbody tr:last-child { border-bottom: none; }
  .cat-table tbody tr:hover { background: rgba(29,158,117,.04); }
  .cat-table td { padding: 14px 16px; vertical-align: middle; }

  .row-num {
    font-size: 12px;
    color: var(--text-faint);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 600;
  }

  .cat-thumb {
    width: 42px; height: 42px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid var(--border);
  }
  .cat-thumb-placeholder {
    width: 42px; height: 42px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
  }
  .cat-thumb-placeholder svg { width: 18px; height: 18px; color: var(--text-faint); }

  .cat-name { font-weight: 600; color: var(--text-primary); font-size: 13.5px; }
  .cat-parent {
    font-size: 11.5px;
    color: var(--accent-dim);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .cat-parent svg { width: 11px; height: 11px; }
  .cat-desc { font-size: 12px; color: var(--text-muted); max-width: 200px; }

  .badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .2px;
  }
  .badge-pill::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  .badge-active   { background: #ecfdf5; color: #065f46; border: 1px solid rgba(16,185,129,.2); }
  .badge-active::before { background: #059669; }
  .badge-inactive { background: #fef2f2; color: #b91c1c; border: 1px solid rgba(239,68,68,.2); }
  .badge-inactive::before { background: #dc3545; }

  /* ── ACTION BTNS ── */
  .action-btns { display: flex; gap: 8px; align-items: center; }

  .btn-icon {
    width: 32px; height: 32px;
    border: none;
    border-radius: var(--radius-sm);
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background .2s, transform .15s;
    flex-shrink: 0;
  }
  .btn-icon:hover { transform: scale(1.08); }
  .btn-icon svg { width: 14px; height: 14px; }
  .btn-icon-edit   { background: var(--accent-soft); color: var(--accent); }
  .btn-icon-edit:hover  { background: rgba(29,158,117,.22); }
  .btn-icon-delete { background: var(--danger-soft); color: var(--danger); }
  .btn-icon-delete:hover { background: rgba(239,68,68,.2); }

  /* ── EMPTY STATE ── */
  .empty-state {
    padding: 64px 20px;
    text-align: center;
    color: var(--text-muted);
  }
  .empty-state svg { width: 48px; height: 48px; margin-bottom: 12px; color: var(--text-faint); }
  .empty-state p { font-size: 14px; margin-bottom: 16px; }

  /* ── MODAL ── */
  .cat-modal .modal-content {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    color: var(--text-primary);
    font-family: 'DM Sans', sans-serif;
    box-shadow: var(--shadow);
  }
  .cat-modal .modal-header {
    background: var(--surface-2);
    border-bottom: 1px solid var(--border);
    padding: 18px 22px;
  }
  .cat-modal .modal-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -.2px;
  }
  .cat-modal .btn-close { opacity: .5; }
  .cat-modal .modal-body { padding: 22px; }
  .cat-modal .modal-footer {
    border-top: 1px solid var(--border);
    padding: 16px 22px;
    gap: 10px;
  }
  .cat-modal .form-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .7px;
    color: var(--text-muted);
    margin-bottom: 6px;
    display: block;
  }
  .cat-modal .req { color: var(--danger); margin-left: 2px; }
  .cat-modal .form-control,
  .cat-modal .form-select {
    background: var(--surface-2);
    border: 1.5px solid var(--border);
    color: var(--text-primary);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    padding: 10px 13px;
    transition: border-color .2s, box-shadow .2s;
  }
  .cat-modal .form-control:focus,
  .cat-modal .form-select:focus {
    background: #fff;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
    color: var(--text-primary);
    outline: none;
  }
  .cat-modal .form-control.is-invalid,
  .cat-modal .form-select.is-invalid { border-color: var(--danger); }
  .cat-modal .form-control::placeholder { color: var(--text-faint); }
  .cat-modal select option { background: #fff; }
  .cat-modal .field-error { font-size: 11.5px; color: var(--danger); margin-top: 4px; display: block; }

  .cat-modal .img-preview-wrap {
    width: 60px; height: 60px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--border);
    margin-bottom: 10px;
  }
  .cat-modal .img-preview-wrap img { width: 100%; height: 100%; object-fit: cover; }

  .btn-modal-cancel {
    background: var(--surface-2);
    border: 1.5px solid var(--border);
    color: var(--text-muted);
    border-radius: var(--radius-sm);
    padding: 9px 18px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    cursor: pointer;
    transition: all .2s;
  }
  .btn-modal-cancel:hover { border-color: var(--text-muted); color: var(--text-primary); }

  .btn-modal-submit {
    background: var(--accent);
    border: none;
    color: #fff;
    border-radius: var(--radius-sm);
    padding: 9px 24px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, box-shadow .2s;
  }
  .btn-modal-submit:hover { background: #22b888; box-shadow: 0 0 0 5px var(--accent-glow); }

  /* ── RESPONSIVE ── */
  @media(max-width:768px) {
    .cat-page { padding: 20px 16px; }
    .hero-stats { grid-template-columns: repeat(3,1fr); }
    .hero-stat-val { font-size: 20px; }
    .hero-top { flex-wrap: wrap; gap: 12px; }
    .hero-title { font-size: 22px; }
  }
  @media(max-width:480px) {
    .hero-stats { grid-template-columns: 1fr; }
  }
</style>

<div class="cat-page">

  {{-- ── ALERTS ── --}}
  @if(session('success'))
    <div class="cat-alert cat-alert-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
      <button class="cat-alert-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
  @endif
  @if(session('error'))
    <div class="cat-alert cat-alert-danger">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      {{ session('error') }}
      <button class="cat-alert-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
  @endif

  {{-- ── HERO BANNER ── --}}
  <div class="page-hero">

    {{-- breadcrumb --}}
    <div class="hero-crumb">
      Dashboard
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      Categories
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      <span>Subcategories</span>
    </div>

    {{-- title + button --}}
    <div class="hero-top">
      <div class="hero-title-block">
        <div class="hero-badge">Catalog</div>
        <h1 class="hero-title">Subcategory <em>Management</em></h1>
        <p class="hero-subtitle">Manage subcategories across your product catalog</p>
      </div>
      <button class="hero-add-btn" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Subcategory
      </button>
    </div>

    {{-- stat strip --}}
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-icon icon-total">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
        </div>
        <div class="hero-stat-info">
          <div class="hero-stat-val">{{ $subcategories->count() }}</div>
          <div class="hero-stat-label">Total Subcategories</div>
        </div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-icon icon-active">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="hero-stat-info">
          <div class="hero-stat-val">{{ $subcategories->where('status','active')->count() }}</div>
          <div class="hero-stat-label">Active</div>
        </div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-icon icon-inactive">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
        <div class="hero-stat-info">
          <div class="hero-stat-val">{{ $subcategories->where('status','inactive')->count() }}</div>
          <div class="hero-stat-label">Inactive</div>
        </div>
      </div>
    </div>

  </div>{{-- end .page-hero --}}

  {{-- ── FILTER BAR ── --}}
  <div class="filter-bar">
    <div class="filter-input-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="searchInput" class="filter-input" placeholder="Search subcategories…">
    </div>
    <select id="filterCategory" class="filter-select">
      <option value="">All Categories</option>
      @foreach($categories as $category)
        <option value="{{ strtolower($category->name) }}">{{ $category->name }}</option>
      @endforeach
    </select>
    <select id="filterStatus" class="filter-select">
      <option value="">All Status</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
    <button id="resetBtn" class="filter-reset-btn">Reset</button>
  </div>

  {{-- ── TABLE ── --}}
  <div class="table-card">
    <div class="table-responsive">
      <table class="cat-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Category</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="subcategoryTableBody">

          @forelse($subcategories as $index => $subcategory)
            <tr class="subcategory-row"
                data-name="{{ strtolower($subcategory->name) }}"
                data-category="{{ strtolower($subcategory->category->name ?? '') }}"
                data-status="{{ $subcategory->status }}">

              {{-- # --}}
              <td><span class="row-num">{{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}</span></td>

              {{-- IMAGE --}}
              <td>
                @if($subcategory->image)
                  <img class="cat-thumb"
                       src="{{ Str::startsWith($subcategory->image,'http') ? $subcategory->image : asset('storage/'.$subcategory->image) }}"
                       alt="{{ $subcategory->name }}">
                @else
                  <div class="cat-thumb-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                  </div>
                @endif
              </td>

              {{-- PARENT CATEGORY --}}
              <td>
                <span class="cat-parent">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                  {{ $subcategory->category->name ?? '—' }}
                </span>
              </td>

              {{-- NAME --}}
              <td><div class="cat-name">{{ $subcategory->name }}</div></td>

              {{-- DESCRIPTION --}}
              <td><div class="cat-desc">{{ Str::limit($subcategory->description, 40) ?? '—' }}</div></td>

              {{-- STATUS --}}
              <td>
                @if($subcategory->status === 'active')
                  <span class="badge-pill badge-active">Active</span>
                @else
                  <span class="badge-pill badge-inactive">Inactive</span>
                @endif
              </td>

              {{-- ACTIONS --}}
              <td>
                <div class="action-btns">
                  <button class="btn-icon btn-icon-edit"
                          data-bs-toggle="modal"
                          data-bs-target="#editSubcategory{{ $subcategory->id }}"
                          title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </button>
                  <button type="button" class="btn-icon btn-icon-delete delete-btn"
                          data-id="{{ $subcategory->id }}"
                          data-url="{{ route('admin.subcategories.destroy', $subcategory->id) }}"
                          title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                  </button>
                </div>
              </td>

            </tr>

            {{-- ── EDIT MODAL ── --}}
            <div class="modal fade cat-modal" id="editSubcategory{{ $subcategory->id }}" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_edit_id" value="{{ $subcategory->id }}">
                    <div class="modal-body">
                      <div class="row g-3">

                        <div class="col-md-6">
                          <label class="form-label">Category <span class="req">*</span></label>
                          <select name="category_id"
                            class="form-control {{ $errors->has('category_id') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                            required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}"
                                {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                              </option>
                            @endforeach
                          </select>
                          @if($errors->has('category_id') && old('_edit_id') == $subcategory->id)
                            <span class="field-error">{{ $errors->first('category_id') }}</span>
                          @endif
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Status <span class="req">*</span></label>
                          <select name="status"
                            class="form-control {{ $errors->has('status') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                            required>
                            <option value="active"   {{ old('status',$subcategory->status) === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status',$subcategory->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                          </select>
                          @if($errors->has('status') && old('_edit_id') == $subcategory->id)
                            <span class="field-error">{{ $errors->first('status') }}</span>
                          @endif
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Subcategory Name <span class="req">*</span></label>
                          <input type="text" name="name"
                            class="form-control {{ $errors->has('name') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                            value="{{ old('name', $subcategory->name) }}"
                            placeholder="e.g. Painkillers" required>
                          @if($errors->has('name') && old('_edit_id') == $subcategory->id)
                            <span class="field-error">{{ $errors->first('name') }}</span>
                          @endif
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Description</label>
                          <input type="text" name="description"
                            class="form-control {{ $errors->has('description') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                            value="{{ old('description', $subcategory->description) }}"
                            placeholder="Optional short description">
                          @if($errors->has('description') && old('_edit_id') == $subcategory->id)
                            <span class="field-error">{{ $errors->first('description') }}</span>
                          @endif
                        </div>

                        <div class="col-md-12">
                          <label class="form-label">Image</label>
                          @if($subcategory->image)
                            <div class="img-preview-wrap">
                              <img src="{{ Str::startsWith($subcategory->image,'http') ? $subcategory->image : asset('storage/'.$subcategory->image) }}"
                                   alt="{{ $subcategory->name }}">
                            </div>
                          @else
                            <img id="editPreview{{ $subcategory->id }}" src="#" alt="Preview"
                                 style="display:none; width:60px; height:60px; object-fit:cover; border-radius:10px; margin-bottom:10px;">
                          @endif
                          <input type="file" name="image" class="form-control image-input"
                                 accept="image/jpg,image/jpeg,image/png,image/webp"
                                 data-preview="editPreview{{ $subcategory->id }}">
                          @if($errors->has('image') && old('_edit_id') == $subcategory->id)
                            <span class="field-error">{{ $errors->first('image') }}</span>
                          @endif
                        </div>

                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn-modal-submit">Update Subcategory</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            {{-- END EDIT MODAL --}}

          @empty
            <tr id="emptyRow">
              <td colspan="7">
                <div class="empty-state">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                  <p>No subcategories found.</p>
                  <button class="hero-add-btn" style="margin:0 auto;" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add First Subcategory
                  </button>
                </div>
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>
  </div>

</div>{{-- end .cat-page --}}


{{-- ── ADD SUBCATEGORY MODAL ── --}}
<div class="modal fade cat-modal" id="addSubcategoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Subcategory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Category <span class="req">*</span></label>
              <select name="category_id"
                class="form-control {{ $errors->has('category_id') && !old('_edit_id') ? 'is-invalid' : '' }}"
                required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @if($errors->has('category_id') && !old('_edit_id'))
                <span class="field-error">{{ $errors->first('category_id') }}</span>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label">Status <span class="req">*</span></label>
              <select name="status"
                class="form-control {{ $errors->has('status') && !old('_edit_id') ? 'is-invalid' : '' }}"
                required>
                <option value="">-- Select --</option>
                <option value="active"   {{ old('status') == 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              @if($errors->has('status') && !old('_edit_id'))
                <span class="field-error">{{ $errors->first('status') }}</span>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label">Subcategory Name <span class="req">*</span></label>
              <input type="text" name="name"
                class="form-control {{ $errors->has('name') && !old('_edit_id') ? 'is-invalid' : '' }}"
                placeholder="e.g. Painkillers"
                value="{{ old('name') }}" required>
              @if($errors->has('name') && !old('_edit_id'))
                <span class="field-error">{{ $errors->first('name') }}</span>
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label">Description</label>
              <input type="text" name="description"
                class="form-control {{ $errors->has('description') && !old('_edit_id') ? 'is-invalid' : '' }}"
                placeholder="Optional short description"
                value="{{ old('description') }}">
              @if($errors->has('description') && !old('_edit_id'))
                <span class="field-error">{{ $errors->first('description') }}</span>
              @endif
            </div>

            <div class="col-md-12">
              <label class="form-label">Image</label>
              <input type="file" name="image" class="form-control image-input"
                     accept="image/jpg,image/jpeg,image/png,image/webp"
                     data-preview="addPreview">
              @if($errors->has('image') && !old('_edit_id'))
                <span class="field-error">{{ $errors->first('image') }}</span>
              @endif
              <img id="addPreview" src="#" alt="Preview"
                   style="display:none; margin-top:10px; width:60px; height:60px; object-fit:cover; border-radius:10px;">
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-modal-submit">Add Subcategory</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- ── SCRIPTS ── --}}
<script>
  // ── Filter / search ──
  document.getElementById('searchInput').addEventListener('input', filterTable);
  document.getElementById('filterCategory').addEventListener('change', filterTable);
  document.getElementById('filterStatus').addEventListener('change', filterTable);

  function filterTable() {
    const search   = document.getElementById('searchInput').value.toLowerCase();
    const category = document.getElementById('filterCategory').value.toLowerCase();
    const status   = document.getElementById('filterStatus').value.toLowerCase();

    document.querySelectorAll('.subcategory-row').forEach(row => {
      const matchName     = row.dataset.name.includes(search);
      const matchCategory = category === '' || row.dataset.category === category;
      const matchStatus   = status   === '' || row.dataset.status   === status;
      row.style.display   = (matchName && matchCategory && matchStatus) ? '' : 'none';
    });
  }

  document.getElementById('resetBtn').addEventListener('click', () => {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterStatus').value = '';
    filterTable();
  });

  // ── AJAX delete ──
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const url = this.dataset.url;
      const row = this.closest('tr');
      if (!confirm('Are you sure you want to delete this subcategory?')) return;
      fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: '_method=DELETE&_token={{ csrf_token() }}'
      })
      .then(res => {
        if (res.ok) { row.remove(); }
        else        { alert('Delete failed. Please try again.'); }
      })
      .catch(() => alert('Delete failed. Please try again.'));
    });
  });

  // ── Image preview ──
  document.querySelectorAll('.image-input').forEach(input => {
    input.addEventListener('change', function() {
      const file    = this.files[0];
      const preview = document.getElementById(this.dataset.preview);
      if (file && preview) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(file);
      }
    });
  });
</script>

{{-- ── Reopen edit modal after validation error ── --}}
<script>
  window.addEventListener('load', function() {
    @if($errors->any())
      const editId = "{{ old('_edit_id') }}";
      const modalId = editId ? 'editSubcategory' + editId : 'addSubcategoryModal';
      const el = document.getElementById(modalId);
      if (el) setTimeout(() => new bootstrap.Modal(el).show(), 300);
    @endif
  });
</script>

@endsection