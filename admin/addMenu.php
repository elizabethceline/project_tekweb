<?php include_once("controller.php");
ob_start(); ?>
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

    .image-height {
        height: 70px;
        border-radius: 5px;
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

    .modal-content {
        background-color: #C3A6A0;
    }
</style>

<body>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-12 col-lg-8">
                <div class="card p-4 my-5">
                    <h3 style="text-align: center" class="font-goblin">Add Menu</h3>
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Menu name:</label>
                            <input class="form-control" type="text" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Menu description:</label>
                            <input class="form-control" type="text" name="description" id="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input class="form-control" type="number" name="price" id="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image:</label>
                            <input class="form-control" type="file" name="image" id="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <button class="add btn" style="width: 100%; background-color:#262220; color:white; margin-top:5px" type="submit" name="add">Add Menu</button>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_POST['add'])) {
                    $name = $_POST['name'];
                    $desc = $_POST['description'];
                    $price = $_POST['price'];
                    $photo = $_FILES['image']['name'];

                    $targetDir = dirname(__FILE__) . "/uploads/";
                    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
                    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

                    $conn = connectDB();
                    $sql = "INSERT INTO `food` (`id`, `name`, `description`, `photo`, `price`) VALUES (NULL, '$name', '$desc', '$photo', '$price');";
                    mysqli_query($conn, $sql);
                    closeDB($conn);
                    header("Location: addMenu.php");
                    exit();
                }
                ?>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="font-goblin" style="text-align: center; margin-top: 80px; margin-bottom: 20px;">List Menu
                </h3>
            </div>
        </div>
        <div class="row" style="margin-bottom: 75px;">
            <table id="menu" class="table table-striped table-bordered" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th data-sort="name">Name</th>
                        <th data-sort="description">Description</th>
                        <th data-sort="price">Price</th>
                        <th data-sort="photo">Photo</th>
                        <th>Status</th>
                        <th class="col-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $allData = getFoodData();
                    while ($data = $allData->fetch_assoc()) :
                        $id = $data['id'];
                        $price = $data['price'];
                        $status = $data['status'];
                        $photo = $data['photo'];
                        if (strpos($photo, 'http') === false) {
                            $photo = 'uploads/' . $photo;
                        }
                        echo "<tr>
                                <td>" . $data['name'] . "</td>
                                <td>" . $data['description'] . "</td>
                                <td> Rp." . number_format($price, 0, ',', '.') . "</td>
                                <td> <img class='image-height' src=" . $photo . " </td>
                                <td class='status-cell'>" . ($status == 0 ? 'Available' : 'Not Available') . "</td>
                                <td>";
                    ?>
                        <form method='post' class='status-form'>
                            <input type='hidden' name='menu_id' value='<?= $id ?>'>
                            <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#updateModal<?= $id ?>'>Update</button>
                            <button class='change-status-btn btn btn-primary' data-menu-id='<?= $id ?>' data-current-status='<?= $status ?>'>Change</button>
                        </form>
                        </td>
                        </tr>

                        <div class="modal fade" id="updateModal<?= $id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-goblin" id="updateModalLabel">Update Menu</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" enctype="multipart/form-data" action="update_food.php">
                                        <input type="hidden" id="updateMenuId" name="menu_id" value="<?= $data['id'] ?>">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="updateName" class="form-label">Menu name:</label>
                                                <input class="form-control" type="text" name="updateName" id="updateName" value="<?= $data['name'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="updateDescription" class="form-label">Menu description:</label>
                                                <input class="form-control" type="text" name="updateDescription" id="updateDescription" value="<?= $data['description'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="updatePrice" class="form-label">Price:</label>
                                                <input class="form-control" type="number" name="updatePrice" id="updatePrice" value="<?= $data['price'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="updateImage" class="form-label">Image:</label>
                                                <input class="form-control" type="file" name="updateImage" id="updateImage" value="<?= $photo ?>" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="mb-3">
                                                <button class="btn btn-primary" style="background-color:#262220; color:white; border:none;" type="submit" name="updateMenu">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    ob_end_flush();
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
                var menuId = button.data('menu-id');
                var currentStatus = button.data('current-status');

                var newStatus = currentStatus === 0 ? 1 : 0;

                $.ajax({
                    type: 'POST',
                    url: 'update_status_food.php',
                    data: {
                        menu_id: menuId,
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