<?php
include("../../conn.php");
session_start();
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["flightId"])) {
        $flightId = $_POST["flightId"];

        $stmt = $conn->prepare("SELECT * FROM `flight_transaction` ft JOIN `user` u ON (ft.id_user = u.id) WHERE (email = ? OR username = ?) AND ft.id_flight = ?");
        $stmt->bind_param("ssi", $email, $email, $flightId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            http_response_code(200);
            echo "AlreadyBooked";
            exit();
        }

        echo "<div class='container header_display'>
            <div class='header_heading'>
                <button type='button'><a href='../flights/index.php' class='text2'><i class='fa-solid fa-rotate-left'></i> Back</a></button>
                <h1 class='header1' style='color: white'>2. Choose Seat</h1>
            </div>
        <div class='container seat-box' id='seat-container'>";

        $rows = range('1', '20');
        $columns = range('A', 'F');
        foreach ($rows as $baris) {
            echo '<div class="row">';
            foreach ($columns as $kolom) {
                $seatId = $baris . $kolom;
                $stmt = $conn->prepare("SELECT * FROM `flight_transaction` WHERE seat = ? AND id_flight = ?");
                $stmt->bind_param("si", $seatId, $flightId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="seat unavailable col g-2 mx-2" id="' . $seatId . '">' . $seatId . '</div>';
                    }
                } else {
                    echo '<div class="seat available col g-2 mx-2" id="' . $seatId . '">' . $seatId . '</div>';
                }
            }
            echo '</div>';
        }
        echo "</div></div>";

        echo '<div class="container confirm-seat">
            <h1 class="selected-seat text2 tebel">Seat: -</h1>
            <button type="submit" class="btn btn-primary btn-seat text2 tebel mt-3" style="width: 200px">CONFIRM</button>
        </div>';
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
