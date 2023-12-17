<?php include_once("controller.php") ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <?php
    include '../user/assets/css/main.html';
    ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Goblin+One&family=Inter&display=swap" rel="stylesheet">
</head>
<style>
    body {
        background-color: #F7F1F0;
        font-family: 'Inter', sans-serif;
    }

    .font-goblin {
        font-family: 'Goblin One', cursive !important;
    }

    .card {
        background-color: #C3A6A0;
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 20px;
        box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(15px);
    }

    .section {
        margin-bottom: 20px;
    }

    .section h4 {
        margin-bottom: 10px;
    }
</style>


<body>
    <?php include "navbar.php"; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">

                <div class="card my-5 p-4 section">
                    <h4><i class="fa-solid fa-plane"></i> Total Pendapatan dari Penjualan Tiket Pesawat =
                        <?php
                        $p1 = getTotalPendapatanFlight();
                        echo "Rp";
                        if ($p1 == 0) {
                            echo "0</h4>";
                        } else {
                            echo number_format($p1, 0, ',', '.') . "</h4>";
                        }
                        ?>
                </div>

                <div class="card my-5 p-4 section">
                    <h4><i class="fa-solid fa-burger"></i> Total Pendapatan dari Penjualan Makanan =
                        <?php
                        $p2 = getTotalPendapatanMakanan();
                        echo "Rp";
                        if ($p2 == 0) {
                            echo "0</h4>";
                        } else {
                            echo number_format($p2, 0, ',', '.') . "</h4>";
                        }
                        ?>
                </div>

                <div class="card my-5 p-4 section">
                    <h4><i class="fa-solid fa-piggy-bank"></i> Total Pendapatan Keseluruhan =
                        <?php
                        echo "Rp";
                        $p3 = $p1 + $p2;
                        echo number_format($p3, 0, ',', '.') . "</h4>";
                        ?>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</body>

</html>