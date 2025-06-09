<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.Navbar')
    <br>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .seat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .seat-group {
            display: grid;
            grid-template-columns: repeat(2, 50px);
            grid-template-rows: repeat(2, 50px);
            gap: 5px;
            justify-content: center;
            background-color: #222;
            padding: 10px;
            border-radius: 10px;
        }

        .seat {
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            font-size: 14px;
            background-color: black;
            color: white;
            border-radius: 10px;
            cursor: pointer;
        }

        .seat.booked {
            background-color: grey !important;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: blue !important;
        }

        .seat:hover:not(.booked) {
            background-color: blue !important;
        }

        .stage {
            background: linear-gradient(to bottom, #999, #666);
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            width: 80%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 20px 20px 50px 50px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
            color: white;
            text-transform: uppercase;
        }

        .indoor-row,
        .indoor-rows {
            display: flex;
            justify-content: space-between;
            width: 110%;
            gap: 10px;
        }

        .card {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 10px;
            margin-bottom: 30px;
        }

        .card2 {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .card1 {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 10px;
            margin-bottom: 20px;
        }
        
        .booking-section {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            width: 100%;
        }
        
        .custom-layout {
            display: flex;
            gap: 20px;
        }
        
        .left-column {
            flex: 1;
        }
        
        .right-column {
            flex: 1;
        }
        
        .floor2-container {
            display: flex;
            gap: 20px;
        }
        
        .floor2-seats {
            flex: 1;
        }
        
        .floor2-booking {
            width: 300px;
        }
    </style>
</head>

<body> 
    <div class="container mx-auto p-4 overflow-x-auto">
        <div class="custom-layout">
            <!-- Left Column (Outdoor + Booking) -->
            <div class="left-column">
                <!-- Outdoor Section -->
                <div class="card">
                    <h5 class="text-center">Luar Ruang</h5>
                    <div class="seat-container">
                        @php $formattedSeats = $formattedSeats ?? []; @endphp
                        @for($i = 1; $i <= 18; $i++)
                            @php
                                $seatId1 = $i . 'oa';
                                $seatId2 = $i . 'ob';
                                $seatId3 = $i . 'oc';
                                $seatId4 = $i . 'od';
                            @endphp
                            <div class="seat-group">
                                <div class="seat {{ in_array($seatId1, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId1 }}">{{ $seatId1 }}</div>
                                <div class="seat {{ in_array($seatId2, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId2 }}">{{ $seatId2 }}</div>
                                <div class="seat {{ in_array($seatId3, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId3 }}">{{ $seatId3 }}</div>
                                <div class="seat {{ in_array($seatId4, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId4 }}">{{ $seatId4 }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Booking Section -->
                <div class="booking-section">
                    <h4 class="mb-3 fw-semibold text-dark">
                        <i class="bi bi-cash-stack me-2 text-success"></i> Total Harga: 
                        <span id="totalPrice" class="text-success">Rp 0</span>
                    </h4>

                    <h5 class="mb-4 text-dark fw-normal">
                        <i class="bi bi-chair me-2 text-primary"></i> Tempat Duduk: 
                        <span id="selectedSeats" class="text-primary">-</span>
                    </h5>

                    <div class="d-flex flex-column gap-3">
                        <button id="confirmBooking" class="btn btn-success px-4 py-2 rounded-pill shadow-sm d-flex align-items-center" disabled>
                            Konfirmasi Pemesanan
                        </button>

                        <button class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm d-flex align-items-center" id="cancelSelection">
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Right Column (Indoor) -->
            <div class="right-column">
                <div class="stage">Panggung</div>
                
                <!-- Indoor First Floor -->
                <div class="card1">
                    <h5 class="text-center">Dalam Ruang Lantai 1</h5>
                    <div class="seat-container">
                        <!-- Baris 1 (1-4) Kiri ke Kanan -->
                        <div class="indoor-row">
                            @foreach([1, 2, 3, 4] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Baris 2 (8-5) Kanan ke Kiri -->
                        <div class="indoor-row">
                            @foreach([8, 7, 6, 5] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Baris 3 (9-12) Kiri ke Kanan -->
                        <div class="indoor-row">
                            @foreach([9, 10, 11, 12] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Baris 4 (16-13) Kanan ke Kiri -->
                        <div class="indoor-row">
                            @foreach([16, 15, 14, 13] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Baris 5 (17-20) Kiri ke Kanan -->
                        <div class="indoor-row">
                            @foreach([17, 18, 19, 20] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Baris 6 (24-21) Kanan ke Kiri -->
                        <div class="indoor-row">
                            @foreach([24, 23, 22, 21] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Baris 7 (25-28) Kiri ke Kanan -->
                        <div class="indoor-row">
                            @foreach([25, 26, 27, 28] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="indoor-row">
                            @foreach([32, 31, 30, 29] as $number)
                                <div class="seat-group">
                                    <div class="seat {{ in_array($number.'a', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'a' }}">{{ $number.'a' }}</div>
                                    <div class="seat {{ in_array($number.'b', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'b' }}">{{ $number.'b' }}</div>
                                    <div class="seat {{ in_array($number.'c', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'c' }}">{{ $number.'c' }}</div>
                                    <div class="seat {{ in_array($number.'d', $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $number.'d' }}">{{ $number.'d' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Indoor Second Floor -->
                <div class="card2">
                    <h5 class="text-center">Dalam Ruang Lantai 2</h5>
                    <div class="seat-container">
                        @for($i = 1; $i <= 3; $i++) <!-- 3 rows -->
                            <div class="indoor-rows">
                                @for($j = 1; $j <= 5; $j++) <!-- 5 groups per row -->
                                    @php 
                                        $seatId1 = ($i - 1) * 5 + $j . 'sa'; 
                                        $seatId2 = ($i - 1) * 5 + $j . 'sb'; 
                                        $seatId3 = ($i - 1) * 5 + $j . 'sc'; 
                                        $seatId4 = ($i - 1) * 5 + $j . 'sd'; 
                                    @endphp
                                    <div class="seat-group">
                                        <div class="seat {{ in_array($seatId1, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId1 }}">{{ $seatId1 }}</div>
                                        <div class="seat {{ in_array($seatId2, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId2 }}">{{ $seatId2 }}</div>
                                        <div class="seat {{ in_array($seatId3, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId3 }}">{{ $seatId3 }}</div>
                                        <div class="seat {{ in_array($seatId4, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId4 }}">{{ $seatId4 }}</div>
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

<script>
    const eventId = "{{ $eventId }}";

// Konversi seatPrice ke integer agar pasti benar dalam perhitungan
const seatPrice = parseInt(@json($seatPrice ?? 0));
const outdoorDiscount = 0.20; // Luar Ruang diskon 20%
const floor2Discount = 0.10;  // Lantai 2 diskon 10%

let selectedSeats = [];
const confirmButton = $("#confirmBooking");

// Deteksi apakah seatId adalah kursi luar ruang (1oa - 18od)
function isOutdoorSeat(seatId) {
    return /^([1-9]|1[0-8])o[a-d]$/.test(seatId);
}

// Deteksi apakah seatId adalah lantai 2 (pakai pola: angka + s[a-d], ex: 1sa, 1sb, dst)
function isSecondFloor(seatId) {
    // Lantai 2: seatId yang ada 'sa', 'sb', 'sc', 'sd' dan nomor urut 1-15
    return /^([1-9]|1[0-5])s[a-d]$/.test(seatId);
}

// Fungsi menghitung total harga dengan logika diskon: 
// - Luar Ruang diskon 20%
// - Lantai 2 diskon 10%
// - Lainnya harga normal
function calculateTotalPrice() {
    let total = 0;
    selectedSeats.forEach(seat => {
        if (isOutdoorSeat(seat)) {
            total += Math.round(seatPrice * (1 - outdoorDiscount));
        } else if (isSecondFloor(seat)) {
            total += Math.round(seatPrice * (1 - floor2Discount));
        } else {
            total += seatPrice;
        }
    });
    return total;
}

// Update tampilan kursi & total harga
function updatePriceAndSeats() {
    $("#selectedSeats").text(selectedSeats.length > 0 ? selectedSeats.join(', ') : '-');
    $("#totalPrice").text('Rp ' + calculateTotalPrice().toLocaleString('id-ID'));
    confirmButton.prop("disabled", selectedSeats.length === 0);
}

// Ambil & render ulang kursi dari backend
function loadSeats() {
    $.ajax({
        url: "{{ route('pilih-kursi') }}",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Reset kursi
            $(".seat").removeClass("selected")
                .css("background-color", "black")
                .css("cursor", "pointer")
                .off("click");

            // Tandai kursi yang sudah dipesan
            response.formattedSeats.forEach(function(seat) {
                $(".seat[data-seat='" + seat + "']")
                    .addClass("booked")
                    .css("background-color", "grey")
                    .css("cursor", "not-allowed")
                    .off("click");
            });

            // Event pilih seat (hanya untuk yang tidak booked)
            $(".seat:not(.booked)").click(function() {
                let seat = $(this).data("seat");
                if ($(this).hasClass("selected")) {
                    $(this).removeClass("selected");
                    selectedSeats = selectedSeats.filter(s => s !== seat);
                } else {
                    if (!selectedSeats.includes(seat)) {
                        $(this).addClass("selected");
                        selectedSeats.push(seat);
                    }
                }
                updatePriceAndSeats();
            });
        },
        error: function(xhr) {
            console.error("Gagal mengambil kursi terbaru:", xhr.responseText);
        }
    });
}

$(document).ready(function() {
    loadSeats();

    // Konfirmasi booking
    $("#confirmBooking").click(function() {
        let selectedSeatsString = selectedSeats.join(', ');
        let totalHarga = calculateTotalPrice();

        $.post("{{ route('booking.store') }}", {
            _token: "{{ csrf_token() }}",
            seats: selectedSeatsString,
            total_price: totalHarga,
            event_id: eventId
        }).done(function(response) {
            if (response.booking_id) {
                loadSeats();
                window.location.href = `/payment?booking_id=${response.booking_id}`;
            } else {
                alert("Terjadi kesalahan, silakan coba lagi.");
            }
        }).fail(function(xhr) {
            console.error("Error dari backend:", xhr.responseText);
            alert("Gagal menyimpan pemesanan, coba lagi!");
        });
    });

    // Batalkan pilihan
    $("#cancelSelection").click(function() {
        $(".seat.selected").removeClass("selected");
        selectedSeats = [];
        updatePriceAndSeats();
    });
});

</script>


</body>
</html>