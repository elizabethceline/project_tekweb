<?php 
include_once("controller.php");

if (isset($_POST['updateMenu'])) {
    $menuId = $_POST['menu_id'];
    $name = $_POST['updateName'];
    $desc = $_POST['updateDescription'];
    $price = $_POST['updatePrice'];
    $photo = $_FILES['updateImage']['name'];

    $targetDir = dirname(__FILE__) . "/uploads/";
    $targetFile = $targetDir . basename($_FILES["updateImage"]["name"]);
    move_uploaded_file($_FILES["updateImage"]["tmp_name"], $targetFile);

    $conn = connectDB();
    if($photo == null) {
        $sql = "UPDATE `food` SET `name`='$name', `description`='$desc', `price`='$price' WHERE `id`='$menuId'";
    } else {
        $sql = "UPDATE `food` SET `name`='$name', `description`='$desc', `price`='$price', `photo`='$photo' WHERE `id`='$menuId'";
    }
    mysqli_query($conn, $sql);
    closeDB($conn);
    header("Location: addMenu.php");
    exit();
}
?>