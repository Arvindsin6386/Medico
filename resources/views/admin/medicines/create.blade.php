@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg: #f0f4f8;
            --surface: #ffffff;
            --border: #e2e8f0;
            --border-focus: #0ea5e9;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-faint: #94a3b8;
            --accent: #0ea5e9;
            --accent-dark: #0284c7;
            --accent-bg: #e0f2fe;
            --green: #10b981;
            --green-bg: #d1fae5;
            --green-dark: #065f46;
            --shadow: 0 1px 3px rgba(15,23,42,0.08), 0 1px 2px rgba(15,23,42,0.06);
            --shadow-md: 0 4px 16px rgba(15,23,42,0.08), 0 2px 6px rgba(15,23,42,0.05);
        }

        body {
            background: var(--bg) !important;
            font-family: 'Sora', sans-serif !important;
            color: var(--text) !important;
        }

        /* ── PAGE ── */
        .create-page {
            max-width: 860px;
            margin: 2rem auto;
            padding: 0 1.5rem 4rem;
        }

        /* ── TOP NAV ── */
        .top-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 16px;
            text-decoration: none;
            transition: all 0.15s;
            box-shadow: var(--shadow);
        }

        .back-btn:hover {
            color: var(--text);
            border-color: #cbd5e1;
            background: #f8fafc;
            text-decoration: none;
        }

        .back-btn svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .page-title h1 {
            font-size: 21px;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 2px;
            letter-spacing: -0.4px;
        }

        .page-title p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        /* ── FORM CARD ── */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        /* ── SECTION BLOCKS ── */
        .form-section {
            padding: 1.5rem 1.75rem;
            border-bottom: 1px solid var(--border);
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.25rem;
        }

        .section-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--accent-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-icon svg {
            width: 15px;
            height: 15px;
            stroke: var(--accent);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .section-heading h6 {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 0;
        }

        /* ── FIELD ── */
        .field-row {
            display: grid;
            gap: 1rem;
            margin-bottom: 0;
        }

        .field-row.cols-2 { grid-template-columns: 1fr 1fr; }
        .field-row.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
        .field-row.cols-1 { grid-template-columns: 1fr; }

        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .field input,
        .field select {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 9px 13px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            height: 42px;
            width: 100%;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
        }

        .field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-color: #f8fafc;
            padding-right: 36px;
            cursor: pointer;
        }

        .field input::placeholder {
            color: var(--text-faint);
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(14,165,233,0.12);
            background: #fff;
        }

        /* price fields — mono font */
        .field.price input {
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
        }

        /* ── IMAGE UPLOAD ── */
        .image-upload-area {
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            background: #f8fafc;
            position: relative;
        }

        .image-upload-area:hover {
            border-color: var(--border-focus);
            background: var(--accent-bg);
        }

        .image-upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            width: 40px;
            height: 40px;
            background: var(--accent-bg);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .upload-icon svg {
            width: 20px;
            height: 20px;
            stroke: var(--accent);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .upload-text {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin: 0 0 3px;
        }

        .upload-hint {
            font-size: 11px;
            color: var(--text-faint);
            margin: 0;
        }

        #image-preview {
            display: none;
            margin-top: 12px;
        }

        #image-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--border);
        }

        /* ── ERROR ── */
        .field-error {
            font-size: 11px;
            color: #ef4444;
            margin-top: 2px;
            font-weight: 500;
        }

        /* ── FORM FOOTER ── */
        .form-footer {
            padding: 1.25rem 1.75rem;
            background: #f8fafc;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 10px 22px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            color: var(--text);
            text-decoration: none;
        }

        .btn-save {
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--green);
            border: none;
            border-radius: 8px;
            padding: 10px 28px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(16,185,129,0.35);
            transition: all 0.15s;
        }

        .btn-save:hover {
            background: #059669;
            box-shadow: 0 4px 14px rgba(16,185,129,0.4);
        }

        .btn-save:active { transform: scale(0.97); }

        .btn-save svg {
            width: 15px;
            height: 15px;
            stroke: #fff;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @media (max-width: 640px) {
            .field-row.cols-2,
            .field-row.cols-3 { grid-template-columns: 1fr; }
            .create-page { padding: 0 1rem 3rem; }
            .top-nav { flex-wrap: wrap; gap: 10px; }
        }
    </style>

    <div class="create-page">

        {{-- TOP NAV --}}
        <div class="top-nav">
            <a href="{{ route('admin.medicines.index') }}" class="back-btn">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Back to Medicines
            </a>
            <div class="page-title" style="text-align:right;">
                <h1>Add Medicine</h1>
                <p>Fill in the details below to add a new medicine</p>
            </div>
        </div>

        <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-card">

                {{-- SECTION 1: CLASSIFICATION --}}
                <div class="form-section">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h8M4 18h8"/></svg>
                        </div>
                        <h6>Classification</h6>
                    </div>
                    <div class="field-row cols-2">
                        <div class="field">
                            <label>Category</label>
                            <select name="category_id" id="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}">
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: MEDICINE INFO --}}
                <div class="form-section">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        </div>
                        <h6>Medicine Details</h6>
                    </div>

                    <div class="field-row cols-1" style="margin-bottom:1rem;">
                        <div class="field">
                            <label>Medicine Name</label>
                            <input type="text" name="name" placeholder="e.g. Paracetamol 500mg" required>
                        </div>
                    </div>

                    <div class="field-row cols-3">
                        <div class="field">
                            <label>Brand Name</label>
                            <input type="text" name="brand_name" placeholder="e.g. Crocin">
                        </div>
                        <div class="field">
                            <label>Medicine Type</label>
                            <select name="medicine_type">
                                <option value="">Select Type</option>
                                <option>Tablet</option>
                                <option>Capsule</option>
                                <option>Syrup</option>
                                <option>Injection</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Unit</label>
                            <select name="unit">
                                <option value="">Select Unit</option>
                                <option>Strip</option>
                                <option>Bottle</option>
                                <option>Box</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: PRICING & STOCK --}}
                <div class="form-section">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h6>Pricing & Stock</h6>
                    </div>
                    <div class="field-row cols-2" style="margin-bottom:1rem;">
                        <div class="field price">
                            <label>Purchase Price (₹)</label>
                            <input type="number" name="purchase_price" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div class="field price">
                            <label>Selling Price (₹)</label>
                            <input type="number" name="selling_price" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                    <div class="field-row cols-2">
                        <div class="field price">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock" value="0" min="0">
                        </div>
                        <div class="field">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry_date">
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: IMAGE --}}
                <div class="form-section">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <h6>Medicine Image</h6>
                    </div>

                    <div class="image-upload-area" id="upload-area">
                        <input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp" id="imageInput">
                        <div class="upload-icon">
                            <svg viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                        </div>
                        <p class="upload-text">Click to upload image</p>
                        <p class="upload-hint">JPG, JPEG, PNG, WEBP supported</p>
                        <div id="image-preview">
                            <img id="preview-img" src="" alt="Preview">
                        </div>
                    </div>

                    @error('image')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- FOOTER --}}
                <div class="form-footer">
                    <a href="{{ route('admin.medicines.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Save Medicine
                    </button>
                </div>

            </div>
        </form>

    </div>

    {{-- SUBCATEGORY FILTER --}}
    <script>
        document.getElementById('category_id').addEventListener('change', function() {

            let categoryId = this.value;
            let sub = document.getElementById('subcategory_id');

            Array.from(sub.options).forEach(opt => {
                opt.style.display = (opt.dataset.category == categoryId || opt.value == "") ?
                    "block" :
                    "none";
            });

        });
    </script>

    {{-- IMAGE PREVIEW --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('preview-img').src = ev.target.result;
                document.getElementById('image-preview').style.display = 'block';
                document.querySelector('.upload-text').textContent = file.name;
                document.querySelector('.upload-hint').textContent = (file.size / 1024).toFixed(1) + ' KB';
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection