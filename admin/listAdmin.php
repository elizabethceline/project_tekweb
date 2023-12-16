<?php
session_start();
ob_start();
if (isset($_SESSION['username'])) {
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

        <style>
            body {
                background-color: #f7f1f0;
            }

            .container {
                background-color: white;
            }
        </style>

        <title>List User</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <div class="container my-5 p-5">
            <div class="table-responsive">
                <h1 class="my-3">Data Admin</h1>
                <button type="button" class="btn btn-dark my-3" data-bs-toggle="modal" data-bs-target="#addNewUser">Add New Admin</button>
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('../conn.php');

                        $stmt = $conn->prepare("SELECT * FROM admin");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $test = 1;
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $username = $row['username'];
                            echo "<tr> 
                            <td>" . $id . "</td> 
                            <td>" . $username . "</td> 
                            <td> <button class='btn btn-danger' onclick=\"location.href = 'listAdmin.php?username=$username'\">Delete</button> </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Admin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-12"><input class="form-control m-2" type="text" placeholder="Username" name="signupUsername" required></div>
                                <div class="col-12"><input class="form-control m-2" type="password" placeholder="Password" name="signupPassword" required></div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" method="post" class="btn btn-dark">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    if (isset($_GET['username'])) {
        require_once('../conn.php');
        $stmt = $conn->prepare('DELETE FROM admin WHERE username = ?');
        $stmt->bind_param('s', $username);

        $username = $_GET['username'];

        $stmt->execute();
        header('Location: listAdmin.php');
        // setcookie('confirmation-deletion', true, time() + 3600, '/');
        // header('Location: listUser.php');
    }
    if (isset($_POST["signupUsername"]) && isset($_POST["signupPassword"])) {
        require_once("../conn.php");
        $stmt = $conn->prepare("INSERT INTO admin VALUES(NULL, ?, PASSWORD(?))");
        $stmtUsername = $conn->prepare("SELECT username FROM admin WHERE username = ?");

        $stmtUsername->bind_param("s", $username);

        $username = $_POST["signupUsername"];
        $password = $_POST["signupPassword"];

        $stmtUsername->execute();
        $resultUsername = $stmtUsername->get_result();
        if ($resultUsername->num_rows > 0) {
            setcookie('gagal-username', true, time() + 3600, '/');
            header("Location: listAdmin.php");
        } else {
            setcookie('berhasil-akun', true, time() + 3600, '/');
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            header("Location: listAdmin.php");
        }
    }

    // $confirmation = '';
    // if (isset($_COOKIE['confirmation-deletion'])) {
    //     setcookie('confirmation-deletion', false, time() - 3600, '/');

    //     $confirmation = '<script>
    //             Swal.fire({
    //                 heightAuto: false,
    //                 title: "Confirmation",
    //                 text: "Apakah yakin melakukan delete akun ini?",
    //                 icon: "question"
    //             });
    //         </script>';
    // }

    $successAkun = '';
    if (isset($_COOKIE['berhasil-akun'])) {
        setcookie('berhasil-akun', null, time() - 3600, '/');

        $successAkun = '<script>
                    Swal.fire({
                        heightAuto: false,
                        title: "Akun berhasil dibuat!",
                        text: "",
                        icon: "success"
                    });
                </script>';
    }

    $berhasilProfile = '';
    if (isset($_COOKIE['berhasil-profile'])) {
        setcookie('berhasil-profile', null, time() - 3600, '/');
        $berhasilProfile = '<script>
                    Swal.fire({
                        heightAuto: false,
                        title: "Profile berhasil diganti!",
                        text: "Kembali ke list user page",
                        icon: "success"
                    });
                </script>';
    }

    $gagalUsername = '';
    if (isset($_COOKIE['gagal-username'])) {
        setcookie('gagal-username', null, time() - 3600, '/');

        $gagalUsername = '<script>
                    Swal.fire({
                        heightAuto: false,
                        title: "Username telah dipakai!",
                        text: "Inputkan username lain!",
                        icon: "error"
                    });
                </script>';
    }

    if (!empty($gagalUsername))
        echo $gagalUsername;

    if (!empty($successAkun))
        echo $successAkun;

    if (!empty($berhasilProfile))
        echo $berhasilProfile;

    ob_end_flush();
} else {
    header("Location: index.php");
}
    ?>

    <script>
        new DataTable('#example');
    </script>
    </body>

    </html>