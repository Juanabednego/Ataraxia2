<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>

    @include('layouts.Navbar')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #efe5fc 0%, #fff 100%);
            font-family: 'Segoe UI', sans-serif;
        }
        .filter-btns .btn {
            border-radius: 30px;
            padding: 10px 20px;
            margin: 0 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .filter-btns .btn.active,
        .filter-btns .btn:hover {
            background-color: #8174A0;
            color: #fff;
        }
        .menu-card {
            border: none;
            border-radius: 18px;
            background: #f9f9f9;
            box-shadow: 0 2px 16px rgba(129, 116, 160, 0.10);
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.4s;
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0;
            transform: translateY(60px) scale(0.97);
        }
        .menu-card.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            transition: opacity 0.6s cubic-bezier(.77,0,.18,1), 
                        transform 0.5s cubic-bezier(.77,0,.18,1);
        }
        .menu-img-wrapper {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ede8f5;
        }
        .menu-img {
            max-width: 92%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 1px 7px #e8e2f6;
            margin: auto;
            display: block;
        }
        .card-body {
            width: 100%;
            text-align: center;
        }
        .menu-label {
            font-size: 0.82rem;
            letter-spacing: .2px;
            padding: 0.2em 0.7em;
            border-radius: 30px;
            background: #efe5fc;
            color: #6546a0;
            font-weight: 500;
            margin-bottom: 7px;
            display: inline-block;
        }
        .price {
            color: #8174A0;
            font-weight: 700;
        }
        @media (max-width: 600px) {
            .menu-img { height: 85px; }
            .card-title { font-size: 1rem; }
            .price { font-size: .95rem;}
        }
    </style>
</head>

<body>
<div class="container py-5">

    <!-- Filter Buttons -->
    <div class="text-center mb-4 filter-btns">
        <button class="btn btn-outline-secondary active" id="showAll">Semua</button>
        <button class="btn btn-outline-secondary" id="showMakanan">Makanan</button>
        <button class="btn btn-outline-secondary" id="showMinuman">Minuman</button>
    </div>

    <!-- Menu Items -->
    <div id="menu-list" class="row g-4">
        @foreach ($makanans as $menu)
            <div class="col-md-4 menu-item" data-role="{{ $menu->role }}">
                <div class="card menu-card shadow-sm h-100 d-flex flex-column align-items-center">
                    <div class="menu-img-wrapper w-100 d-flex justify-content-center" style="background:#ede8f5;">
                        @if($menu->foto)
                            <img src="{{ asset('uploads/' . $menu->foto) }}" alt="{{ $menu->nama_makanan }}" class="menu-img mx-auto">
                        @else
                            <img src="https://placehold.co/350x180?text=No+Image" alt="No Image" class="menu-img mx-auto">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between p-3 w-100">
                        <div>
                            <span class="menu-label mb-2">{{ ucfirst($menu->role) }}</span>
                            <h5 class="card-title mb-1">{{ $menu->nama_makanan }}</h5>
                            <p class="card-text text-muted mb-2">{{ $menu->deskripsi }}</p>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-auto">
                            <div class="price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@include('layouts.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Filter Buttons
    $(document).ready(function () {
        function setActive(buttonId) {
            $('.filter-btns .btn').removeClass('active');
            $(`#${buttonId}`).addClass('active');
        }
        $('#showAll').click(function () {
            $('.menu-item').show();
            setActive('showAll');
            animateMenuCards();
        });
        $('#showMakanan').click(function () {
            $('.menu-item').each(function () {
                $(this).toggle($(this).data('role') === 'makanan');
            });
            setActive('showMakanan');
            animateMenuCards();
        });
        $('#showMinuman').click(function () {
            $('.menu-item').each(function () {
                $(this).toggle($(this).data('role') === 'minuman');
            });
            setActive('showMinuman');
            animateMenuCards();
        });

        // Card Animation on Page Load
        function animateMenuCards() {
            // reset first
            $('.menu-card').removeClass('visible');
            // animate only visible menu-item
            $('.menu-item:visible .menu-card').each(function(i) {
                let $card = $(this);
                setTimeout(function() {
                    $card.addClass('visible');
                }, 100 + (i * 120));
            });
        }

        // Animate on load
        animateMenuCards();

        // Animate again on filter change
        $('.filter-btns .btn').on('click', function(){
            setTimeout(animateMenuCards, 10);
        });
    });
</script>
</body>
</html>
