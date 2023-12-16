<?php
include_once("controller.php");

if (isset($_POST['flight_id']) && isset($_POST['new_status'])) {
    $fid = $_POST['flight_id'];
    $newStatus = $_POST['new_status'];

    $conn = connectDB();

    $updateQuery = "UPDATE `flight` SET `status`='$newStatus' WHERE `id`='$fid'";
    $result = mysqli_query($conn, $updateQuery);

    closeDB($conn);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>