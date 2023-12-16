<?php include_once("controller.php") ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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

    .form-control {
        background-color: transparent;
        border: 1px solid #262220;
    }


    .form-control:focus {
        background-color: transparent;
        border: 1px solid #262220;
        box-shadow: none;
    }

    .form-label {
        font-weight: bold;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #fff !important;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 55px;
        display: inline-block;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        padding: 0.5rem;
        font-weight: bold;
    }
</style>

<body>
    <?php include "navbar.php"; ?>


    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-12 col-lg-8">
                <div class="card p-4 my-5">
                    <h3 style="text-align: center" class="font-goblin">Add Flight</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code Flight:</label>
                            <input type="text" name="code" id="code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="from" class="form-label">From:</label>
                            <select name="from" id="from" class="form-control" onchange="updateToDropdown()">
                                <?php
                                $allData = getBandara();
                                while ($data = $allData->fetch_assoc()) {
                                    $bandara = $data['name'];
                                    $kode = $data['code'];
                                    echo "<option>$bandara - $kode</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="to" class="form-label">To:</label>
                            <select name="to" id="to" class="form-control">
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ddate" class="form-label">Departure Date:</label>
                            <input type="date" name="ddate" id="ddate" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="dtime" class="form-label">Departure Time:</label>
                            <input type="time" name="dtime" id="dtime" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="ftime" class="form-label">Flight Time:</label>
                            <input type="text" name="ftime" id="ftime" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" name="price" id="price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button class="add btn" style="width: 100%; background-color:#262220; color:white; margin-top:5px" type="submit" name="add">Add Flight</button>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_POST['add'])) {
                    $code = $_POST['code'];
                    $from = $_POST['from'];
                    $to = $_POST['to'];
                    $ddate = $_POST['ddate'];
                    $dtime = $_POST['dtime'];
                    $ftime = $_POST['ftime'];
                    $price = $_POST['price'];

                    $conn = connectDB();
                    $sql = "INSERT INTO `flight` (`id`, `code`, `from`, `to`, `departure_date`, `departure_time`, `flight_time`, `price`, `status`) VALUES (NULL, '$code', '$from', '$to', '$ddate', '$dtime', '$ftime', '$price',0)";
                    mysqli_query($conn, $sql);
                    closeDB($conn);
                }
                ?>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="font-goblin" style="text-align: center; margin-top: 80px; margin-bottom: 20px;">List Flight
                </h3>
            </div>
        </div>
        <div class="row" style="margin-bottom: 75px;">
            <table id="menu" class="table table-striped table-bordered" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th data-sort="code">Code Flight</th>
                        <th data-sort="from">From</th>
                        <th data-sort="to">To</th>
                        <th data-sort="ddate">Departure Date</th>
                        <th data-sort="dtime">Departure Time</th>
                        <th data-sort="ftime">Flight Time</th>
                        <th data-sort="price">Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $allData = getFlightData();
                    while ($data = $allData->fetch_assoc()) {
                        $id = $data['id'];
                        $price = $data['price'];
                        $status = $data['status'];
                        echo "<tr>
                                <td class='col-1'>" . $data['code'] . "</td>
                                <td>" . $data['from'] . "</td>
                                <td>" . $data["to"] . "</td>
                                <td>" . $data["departure_date"] . " </td>
                                <td>" . $data["departure_time"] . " </td>
                                <td class='col-1'>" . $data["flight_time"] . " </td>
                                <td> Rp." . number_format($price, 0, ',', '.') . "</td>
                                <td class='status-cell'>" . ($status == 0 ? 'Available' : 'Not Available') . "</td>
                                <td>
                                    <form method='post' class='status-form'>
                                        <input type='hidden' name='flight_id' value='$id'>
                                        <button class='change-status-btn btn btn-primary' data-flight-id='$id' data-current-status='$status'>Change</button>
                                    </form>
                                </td>
                                </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
        function updateToDropdown() {
            var fromDropdown = document.getElementById("from");
            var toDropdown = document.getElementById("to");

            toDropdown.innerHTML = fromDropdown.innerHTML;

            var selectedOption = fromDropdown.options[fromDropdown.selectedIndex];
            for (var i = 0; i < toDropdown.options.length; i++) {
                if (toDropdown.options[i].value === selectedOption.value) {
                    toDropdown.remove(i);
                    break;
                }
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#menu').DataTable({
                responsive: true,
                "dom": '<"top"lf>rt<"bottom"ipT>',
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search..."
                }
            });
            $('.dataTables_filter input').css('margin-bottom', '15px');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.change-status-btn').click(function(e) {
                e.preventDefault();

                var button = $(this);
                var form = button.closest('.status-form');
                var flightId = button.data('flight-id');
                var currentStatus = button.data('current-status');

                var newStatus = currentStatus === 0 ? 1 : 0;

                $.ajax({
                    type: 'POST',
                    url: 'update_status_flight.php',
                    data: {
                        flight_id: flightId,
                        new_status: newStatus
                    },
                    success: function(response) {
                        console.log('Status updated successfully.');

                        var statusCell = form.closest('tr').find('.status-cell');
                        statusCell.text(newStatus === 0 ? 'Available' : 'Not Available');

                        button.data('current-status', newStatus);
                    },
                    error: function(error) {
                        console.error('Error updating status:', error);
                    }
                });
            });
        });
    </script>



</body>

</html>