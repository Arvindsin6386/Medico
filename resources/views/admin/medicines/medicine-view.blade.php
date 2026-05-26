@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-md-5">

                <!-- Main Image -->
                <div class="border rounded p-3">
                    <img id="mainImage"
                        src="{{ asset('storage/' . ($medicine->images->first()->image_path ?? 'default.png')) }}"
                        class="img-fluid">

                </div>

                <!-- Multiple Images -->
                <div class="d-flex mt-3">
                    @foreach ($medicine->images ?? [] as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}" onclick="changeImage(this.src)">
                    @endforeach

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-7">

                <h2>{{ $medicine->name }}</h2>

                <h3 class="text-success">
                    ₹{{ $medicine->selling_price }}
                </h3>

                <hr>

                {{-- <p>
                    {{ $medicine->stock }}
                </p> --}}
                <h2> Select Stock </h2>
                @if ($medicine->stock > 0)
                    <select name="quantity" class="form-select w-auto">

                        @for ($i = 1; $i <= $medicine->stock; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor

                    </select>
                @else
                    <span class="text-danger">Out of Stock</span>
                @endif


                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-success btn-sm px-4">
                        Add To Cart
                    </button>
                </div>

            </div>

        </div>

    </div>

    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap');

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4f0;
        }

        .container {
            background: transparent;
        }

        /* ── Left Panel ── */
        .border {
            background: #ffffff;
            border: 1.5px solid #e2ede4 !important;
            border-radius: 18px !important;
            box-shadow: 0 2px 24px rgba(25, 135, 84, 0.07), 0 1px 4px rgba(0, 0, 0, 0.04);
            padding: 18px !important;
            transition: box-shadow 0.3s ease;
        }

        .border:hover {
            box-shadow: 0 6px 32px rgba(25, 135, 84, 0.13), 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        #mainImage {
            width: 100%;
            height: 280px;
            object-fit: contain;
            border-radius: 12px;
            transition: transform 0.4s ease;
            background: #f7faf8;
            padding: 8px;
        }

        #mainImage:hover {
            transform: scale(1.02);
        }

        /* Thumbnail row */
        .d-flex {
            gap: 10px;
            flex-wrap: wrap;
        }

        .d-flex img {
            cursor: pointer;
            width: 68px;
            height: 68px;
            object-fit: contain;
            border-radius: 10px;
            border: 2px solid #e2ede4;
            background: #fff;
            padding: 4px;
            transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
        }

        .d-flex img:hover {
            border-color: #198754;
            transform: translateY(-3px);
            box-shadow: 0 4px 14px rgba(25, 135, 84, 0.18);
        }

        /* ── Right Panel ── */
        .col-md-7 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 2.5rem;
        }

        h2 {
            font-family: 'DM Serif Display', serif;
            font-weight: 400;
            font-size: 2rem;
            color: #1a2e1e;
            letter-spacing: -0.3px;
            line-height: 1.2;
            margin-bottom: 0.4rem;
        }

        h3.text-success {
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 1.65rem;
            color: #198754 !important;
            letter-spacing: -0.5px;
            margin-bottom: 0;
        }

        hr {
            border: none;
            border-top: 1.5px solid #d8ead9;
            margin: 1.1rem 0;
        }

        p {
            font-size: 0.97rem;
            color: #4a5e4d;
            line-height: 1.75;
            margin-bottom: 1.6rem;
        }

        /* ── Add to Cart Button ── */
        button.btn-success {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 32px;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #1fad6a 0%, #198754 100%);
            border: none;
            box-shadow: 0 4px 18px rgba(25, 135, 84, 0.30);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        button.btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(25, 135, 84, 0.38);
            background: linear-gradient(135deg, #23c47a 0%, #1a9e62 100%);
        }

        button.btn-success:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(25, 135, 84, 0.22);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .col-md-7 {
                padding-left: 1rem;
                margin-top: 1.5rem;
            }

            h2 {
                font-size: 1.6rem;
            }

            h3.text-success {
                font-size: 1.35rem;
            }

            #mainImage {
                height: 220px;
            }
        }
    </style>
@endsection
