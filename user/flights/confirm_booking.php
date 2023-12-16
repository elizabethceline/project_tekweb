<?php
include("../../conn.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["flightId"]) && isset($_POST["seatId"]) && isset($_POST["airportFrom"]) && isset($_POST["airportTo"])) {
        $fromId = $_POST["airportFrom"];
        $toId = $_POST["airportTo"];
        $flightId = $_POST["flightId"];
        $seatId = $_POST["seatId"];
        $email = $_SESSION["email"];

        $stmt = $conn->prepare("SELECT * FROM `airport` WHERE id = ?");
        $stmt->bind_param("i", $fromId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $from_name = $row["name"];
                $from_city = $row["city"];
                $from_country = $row["country"];
                $from_code = $row["code"];
            }
        } else {
            echo "no result";
        }

        $stmt = $conn->prepare("SELECT * FROM `airport` WHERE id = ?");
        $stmt->bind_param("i", $toId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $to_name = $row["name"];
                $to_city = $row["city"];
                $to_country = $row["country"];
                $to_code = $row["code"];
            }
        } else {
            echo "no result";
        }

        echo '<div class="container header_display">
        <div class="header_heading">
            <button type="button"><a href="../flights/index.php" class="text2"><i class="fa-solid fa-rotate-left"></i> Back</a></button>
            <h1 class="header1" style="color: white">3. Confirm Booking</h1>
            </div>
            <div class="container display-box" style="text-align: left;">';

        $stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $userId = $row["id"];
                echo '
            <div class="row">
                <div class="col-md-6 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-user"></i> Full Name</h1>
                    <h2 class="box-info text3">' . $row["nama"] . '</h2>
                </div>
                <div class="col-md-6 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-passport"></i> Passport Number</h1>
                    <h2 class="box-info text3">' . $row["no_passport"] . '</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-phone"></i> Phone Number</h1>
                    <h2 class="box-info text3">' . $row["no_telp"] . '</h2>
                </div>
                <div class="col-md-6 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-envelope"></i> E-mail</h1>
                    <h2 class="box-info text3">' . $row["email"] . '</h2>
                </div>
            </div>';
            }
        } else {
            echo 'no result';
        }

        $stmt = $conn->prepare("SELECT * FROM `flight` WHERE id = ?");
        $stmt->bind_param("i", $flightId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $departureTime = new DateTime($row['departure_time']);
                $arrivalTime = new DateTime($row['arrive_time']);
                $departureTime = $departureTime->format('H:i');
                $arrivalTime = $arrivalTime->format('H:i');
                $price = number_format($row['price'], 2, ',', '.');
                echo '
            <div class="row">
                <div class="col-md-6 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-plane-departure"></i> From</h1>
                    <h2 class="box-info text3">' . $from_name . ', ' . $from_city . ', ' . $from_country . ' (' . $from_code . ')' . '</h2>
                </div>
                <div class="col-md-6 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-plane-arrival"></i> To</h1>
                    <h2 class="box-info text3">' . $to_name . ', ' . $to_city . ', ' . $to_country . ' (' . $to_code . ')' . '</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-calendar-days"></i> Departure Date</h1>
                    <h2 class="box-info text3">' . $row["departure_date"] . '</h2>
                </div>
                <div class="col-md-3 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-clock"></i> Flight Time</h1>
                    <h2 class="box-info text3">' . $departureTime . ' - ' . $arrivalTime . '</h2>
                </div>
                <div class="col-md-3 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-couch"></i> Seat Number </h1>
                    <h2 class="box-info text3">' . $seatId . '</h2>
                </div>
                <div class="col-md-3 my-2">
                    <h1 class="text2 tebel"><i class="fa-solid fa-money-check-dollar"></i> Price </h1>
                    <h2 class="box-info text3">Rp' . $price . '</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-2">
                    <button class="btn btn-primary btn-confirm text2" data-user-id="' . $userId . '">Book Now!</button>
                </div>
            </div>
        </div>
    </div>';
            }
        } else {
            echo 'no result';
        }
    } else {
        http_response_code(400);
        echo "Bad Request: Missing flightId parameter";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed: Only POST requests are allowed";
}
$stmt->close();
$conn->close();
