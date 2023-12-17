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
    <?php
        include('navbar.php');
    ?>
    <div class="container my-5 p-5">
        <div class="table-responsive">
            <h1 class="my-3">Data User</h1>
            <button type="button" class="btn btn-dark my-3" data-bs-toggle="modal" data-bs-target="#addNewUser">Add New User</button>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Nomor Passport</th>
                        <th>Nomor Telepon</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once('../conn.php');

                        $stmt = $conn->prepare("SELECT * FROM user");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $test = 1;
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $username = $row['username'];
                            echo "<tr> 
                            <td>". $id . "</td> 
                            <td>" . $username . "</td> 
                            <td>" . $row['nama'] . "</td>
                            <td>" . $row['no_passport'] . "</td>
                            <td>" . $row['no_telp'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td> <button class='btn btn-primary' onclick=\"location.href = 'listUser.php?id=$id'\">Edit</button>  <button class='btn btn-danger' onclick=\"location.href = 'listUser.php?username=$username'\">Delete</button> </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- Modal -->
    <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-12"><input class="form-control m-2" type="text" placeholder="Name" name="signupName" required></div>
                            <div class="col-12"><input class="form-control m-2" type="text" placeholder="Username" name="signupUsername" required></div>
                            <div class="col-12"><input class="form-control m-2" type="email" placeholder="Email" name="signupEmail" required></div>
                            <div class="col-12"><input class="form-control m-2" type="text" placeholder="Passport No." name="passport" minlength="8" maxlength="8" required></div>
                            <div class="col-12"><input class="form-control m-2" type="text" placeholder="Phone Number" name="phoneNumber" minlength="10" maxlength="13" required></div>
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


    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.href='listUser.php'" ></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="row">
                            <?php
                                if (isset($_GET['id'])) {
                                    $stmt = $conn->prepare('SELECT * FROM user WHERE id = ?');
                                    $stmt->bind_param('s', $id);
                                    $id = $_GET['id'];

                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0){
                                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-12"><label class="mx-2">Name</label><input class="form-control m-2" type="text" placeholder="Name" name="editName" value='<?php echo $row['nama']?>' required></div>
                            <div class="col-12"><label class="mx-2">Username</label><input readonly class="form-control m-2" type="text" placeholder="Username" name="editUsername" value=<?php echo $row['username']?>></div>
                            <div class="col-12"><label class="mx-2">Email</label><input readonly class="form-control m-2" type="email" placeholder="Email" name="editEmail" value=<?php echo $row['email']?>></div>
                            <div class="col-12"><label class="mx-2">Passport number</label><input readonly class="form-control m-2" type="text" placeholder="Passport No." name="editPassport" value='<?php echo $row['no_passport']?>' minlength="8" maxlength="8" required></div>
                            <div class="col-12"><label class="mx-2">Phone number</label><input class="form-control m-2" type="text" placeholder="Phone Number" name="editPhoneNumber" value='<?php echo $row['no_telp']?>' minlength="10" maxlength="13" required></div>
                        </div>
                        <?php
                          }
                        }
                        ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='listUser.php'">Close</button>
                    <button type="submit" method="post" class="btn btn-dark">Save changes</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#editUser").modal('show');
        })   
    </script>
    <?php
    } elseif (isset($_GET['username'])) {
        require_once('../conn.php');
        $stmt = $conn->prepare('DELETE FROM user WHERE username = ?');
        $stmt->bind_param('s', $username);

        $username = $_GET['username'];

        $stmt->execute();
        header('Location: listUser.php');
    }
    if (isset($_POST["signupName"]) && isset($_POST["signupUsername"]) && isset($_POST["signupEmail"]) && isset($_POST["passport"]) && isset($_POST["phoneNumber"]) && isset($_POST["signupPassword"])) {
            require_once("../conn.php");
            $stmt = $conn->prepare("INSERT INTO user VALUES(NULL, ?, PASSWORD(?), ?, ?, ?, ?)");
            $stmtUsername = $conn->prepare("SELECT username FROM user WHERE username = ?");
            $stmtEmail = $conn->prepare("SELECT email FROM user WHERE email = ?");
            $stmtPassport = $conn->prepare("SELECT no_passport FROM user WHERE no_passport = ?");

            $stmtUsername->bind_param("s", $username);

            $username = $_POST["signupUsername"];
            $password = $_POST["signupPassword"];
            $nama = $_POST["signupName"];
            $passport = $_POST["passport"];
            $telp = $_POST["phoneNumber"];
            $email = $_POST["signupEmail"];

            $stmtUsername->execute();
            $resultUsername = $stmtUsername->get_result();
            if ($resultUsername->num_rows > 0) {
                setcookie('gagal-username', true, time() + 3600, '/');
                header("Location: listUser.php");
            } else {
                $stmtEmail->bind_param("s", $email);
                $stmtEmail->execute();
                $resultEmail = $stmtEmail->get_result();
                if ($resultEmail->num_rows > 0) {
                    setcookie('gagal-email', true, time() + 3600, '/');
                    header("Location: listUser.php");
                } else {
                    $stmtPassport->bind_param("s", $passport);
                    $stmtPassport->execute();
                    $resultPassport = $stmtPassport->get_result();
                    if ($resultPassport->num_rows > 0) {
                        setcookie('gagal-passport', true, time() + 3600, '/');
                        header("Location: listUser.php");
                    } else {
                        setcookie('berhasil-akun', true, time() + 3600, '/');
                        $stmt->bind_param("ssssss", $username, $password, $nama, $passport, $telp, $email);
                        $stmt->execute();
                        header("Location: listUser.php");
                    }
                }
            }
        } elseif (isset($_POST["editName"]) && isset($_POST["editUsername"]) && isset($_POST["editEmail"]) && isset($_POST["editPassport"]) && isset($_POST["editPhoneNumber"])) {
            setcookie('berhasil-profile', true, time() + 3600, '/');
            require_once('../conn.php');
            $stmt = $conn->prepare("UPDATE user SET nama = ?, username = ?, email = ?, no_telp = ?, no_passport = ? WHERE id = ?");
            $stmt->bind_param("ssssss", $nama, $updateUsername, $email, $no_telp, $no_passport, $id);

            $nama = $_POST["editName"];
            $updateUsername = $_POST["editUsername"];
            $email = $_POST["editEmail"];
            $no_telp = $_POST["editPhoneNumber"];
            $no_passport = $_POST["editPassport"];
            $id = $_GET['id'];

            $stmt->execute();
            header('Location: listUser.php');
        }

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

        $gagalEmail = '';
        if (isset($_COOKIE['gagal-email'])) {
            setcookie('gagal-email', null, time() - 3600, '/');

            $gagalEmail = '<script>
                    Swal.fire({
                        heightAuto: false,
                        title: "Email telah dipakai!",
                        text: "Inputkan email lain!",
                        icon: "error"
                    });
                </script>';
        }

        $gagalPassport = '';
        if (isset($_COOKIE['gagal-passport'])) {
            setcookie('gagal-passport', null, time() - 3600, '/');

            $gagalPassport = '<script>
                    Swal.fire({
                        heightAuto: false,
                        title: "Nomor passport sudah dipakai!",
                        text: "Inputkan nomor passport lain!",
                        icon: "error"
                    });
                </script>';
        }

        if (!empty($gagalUsername))
            echo $gagalUsername;

        if (!empty($gagalEmail))
            echo $gagalEmail;

        if (!empty($gagalPassport))
            echo $gagalPassport;

        if (!empty($successAkun))
            echo $successAkun;

        if (!empty($berhasilProfile))
            echo $berhasilProfile;

    } else {
        header('Location: index.php');
    }

        ob_end_flush();
    ?>

    <script>
        new DataTable('#example');
    </script>
</body>
</html>