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
    <title>Food Transaction</title>
    <?php include "../user/assets/css/main.html"; ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap jquery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

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

    <?php
    include "../conn.php";
    include "navbar.php";
    ?>
    <div class="container my-5 p-5">
        <div class="table-responsive">
            <h1>Food Transaction</h1>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>E-mail</th>
                        <th>Flight Number</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT ft.timestamp AS time, u.email AS email, ft.id AS ftid, f.code AS flight_number, ft.total AS total
                    FROM `food_transaction` ft
                    JOIN `user` u ON (ft.id_user = u.id)
                    JOIN `flight` f ON (ft.id_flight = f.id)
                    ORDER BY ft.id DESC";

                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $ft_id = $row["ftid"];
                            $total = number_format($row["total"], 2, ',', '.');
                            echo '<tr>
                        <td>' . $row["time"] . '</td>
                        <td>' . $row["email"] . '</td>
                        <td>' . $row["flight_number"] . '</td>
                        <td>Rp' . $total . '</td>
                        <td><button class="btn btn-primary" data-toggle="modal" data-target="#modal' . $ft_id . '">View Details</button></td>
                    </tr>';

                            // Modal 
                            echo '<div class="modal fade" id="modal' . $ft_id . '" tabindex="-1" role="dialog" aria-labelledby="modalTitle' . $ft_id . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitle' . $ft_id . '">Transaction Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">';
                            $sqlitems = "SELECT f.name AS name, ftd.quantity AS quanti, f.price AS price
                                    FROM `food_transaction_details` ftd
                                    JOIN `food_transaction` ft ON (ftd.id_food_transaction = ft.id)
                                    JOIN `food` f ON (ftd.id_food = f.id)
                                    WHERE ftd.id_food_transaction = '$ft_id'";
                            $itemsresult = $conn->query($sqlitems);
                            if ($itemsresult->num_rows > 0) {
                                while ($items = $itemsresult->fetch_assoc()) {
                                    $price = $items["quanti"] * $items["price"];
                                    $price = number_format($price, 2, ',', '.');
                                    echo "<h4>" . $items["quanti"] . "x " . $items["name"] . "</h4>";
                                }
                            }
                            echo '</div>
                            </div>
                        </div>
                    </div>';
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