<?php
include("../../conn.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["flightId"]) && isset($_POST["seatId"]) && isset($_POST["userId"])) {
        $flightId = $_POST["flightId"];
        $seatId = $_POST["seatId"];
        $userId = $_POST["userId"];

        $sql = "INSERT INTO `flight_transaction` (id, id_flight, id_user, seat) VALUES (null, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $flightId, $userId, $seatId);

        if (mysqli_stmt_execute($stmt)) {
            header('location: ../history/index.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
$stmt->close();
$conn->close();
?>
