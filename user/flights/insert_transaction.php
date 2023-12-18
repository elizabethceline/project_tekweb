<?php
include("../../conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["flightId"]) && isset($_POST["seatId"]) && isset($_POST["userId"])) {
        $flightId = $_POST["flightId"];
        $seatId = $_POST["seatId"];
        $userId = $_POST["userId"];

        $stmt = $conn->prepare("SELECT * FROM `flight_transaction` WHERE seat = ? AND id_flight = ?");
        $stmt->bind_param("si", $seatId, $flightId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(["error" => "Seat already booked"]);
            exit();
        } else {
            $sql = "INSERT INTO `flight_transaction` (id, id_flight, id_user, seat) VALUES (null, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iis", $flightId, $userId, $seatId);

            if (mysqli_stmt_execute($stmt)) {
                // Send a success response
                echo json_encode(["success" => "Booking successful"]);
            } else {
                // Send an error response
                echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($conn)]);
            }

            // Exit the script after sending the response
            exit();
        }
    }
}
$stmt->close();
$conn->close();
?>
