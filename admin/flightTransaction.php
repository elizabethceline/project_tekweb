<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    include('../user/assets/css/main.html');
    ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


    <!-- Sweet Alert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Flight Transaction</title>

    <style>
        body {
            background-color: #f7f1f0;
        }

        .container {
            background-color: white;
        }

        .form-select {
            width: 50%;
        }
    </style>

</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5 p-5">
        <div class="table-responsive">
            <h1>Flight Transaction</h1>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>No. passport</th>
                        <th>Flight Number</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Departure Date</th>
                        <th>Departure Time</th>
                        <th>Seat</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once('../conn.php');
                    $stmt = $conn->prepare('SELECT ft.timestamp AS timestamp, u.nama AS name, u.email AS email, u.no_passport AS passport, f.code AS flight_number, a.code AS from_code, a.city AS from_city, 
                    b.code AS to_code, b.city AS to_city, f.departure_date AS departure_date, f.price AS price,
                    ft.seat AS seat, f.departure_time AS departure_time 

                    FROM `flight_transaction` ft 
                    JOIN `flight` f ON (ft.id_flight = f.id) 
                    JOIN `user` u ON (ft.id_user = u.id) 
                    JOIN `airport` a ON (f.from = a.id)
                    JOIN `airport` b ON (f.to = b.id)');

                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row['timestamp'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['passport'] . "</td>
                            <td>" . $row['flight_number'] . "</td>
                            <td>" . $row['from_code'] . "</td>
                            <td>" . $row['to_code'] . "</td>
                            <td>" . date('d M Y', strtotime($row['departure_date'])) . "</td>
                            <td>" . date('H:i', strtotime($row['departure_time'])) . "</td>
                            <td>" . $row['seat'] . "</td>
                            <td> Rp" . number_format($row['price'], 2, ',', '.') . "</td>
                                </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        new DataTable("#example");
    </script>
</body>

</html>