<?php
session_start();
if (isset($_SESSION['username'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Profile Admin</title>
        <?php
        include('../user/assets/css/main.html');
        ?>

        <style>
            body {
                background-color: #252529;
                height: 100vh;
            }

            .container {
                background-color: white;
                width: 720px;
                max-width: 100%;
                min-height: 320px;
                margin-top: 40px !important;
            }
        </style>
    </head>


    <body>
        <?php include "navbar.php"; ?>
        <div class="container mx-auto rounded-4 bg-white m-3">
            <h2 class='text-center mt-4 pb-5'>Admin Profile</h2>
            <div class="d-flex flex-column align-items-center text-center"><img class="rounded-circle" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <input type="text" class="d-flex align-items-center form-control text-center my-5 w-75" value=<?php echo $_SESSION['username']; ?> disabled>
                <div class="w-75">
                    <form method="post">
                        <input type="password" name="oldPass" class="d-flex align-items-center form-control text-center mb-2" placeholder="Old Password" required>
                        <input type="password" name="newPass" class="d-flex align-items-center form-control text-center mb-4" placeholder="New Password" required>
                        <button type="submit" class="btn btn-dark mb-4">Change password</button>
                    </form>
                    <?php
                    if (isset($_POST["oldPass"]) && isset($_POST["newPass"])) {
                        include_once('../conn.php');

                        $stmt = $conn->prepare('SELECT * from admin WHERE username = ? AND password = PASSWORD(?)');
                        $stmt->bind_param('ss', $username, $password);

                        $username = $_SESSION['username'];
                        $password = $_POST['oldPass'];
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $stmt = $conn->prepare('UPDATE admin SET password = PASSWORD(?) WHERE username = ?');
                            $stmt->bind_param('ss', $password, $username);

                            $password = $_POST['newPass'];
                            $stmt->execute();
                            setcookie('berhasil', true, time() + 3600, '/');
                            header('Location: profile.php');
                        } else {
                            setcookie('gagal', true, time() + 3600, '/');
                            header('Location: profile.php');
                        }
                    }

                    $berhasil = '';
                    if (isset($_COOKIE['berhasil'])) {
                        setcookie('berhasil', null, time() + 3600, '/');
                        $berhasil = "<script>
                                            Swal.fire({
                                                    heightAuto: false,
                                                    title: 'Password berhasil diganti!',
                                                    icon: 'success'
                                            });
                                        </script>";
                    }

                    $gagal = '';
                    if (isset($_COOKIE['gagal'])) {
                        setcookie('gagal', null, time() + 3600, '/');
                        $gagal = "<script>
                                Swal.fire({
                                    heightAuto: false,
                                    title: 'Password Salah!',
                                    text: 'Inputkan password yang benar!',
                                    icon: 'error'
                                });
                            </script>";
                    }

                    if (!empty($berhasil))
                        echo $berhasil;

                    if (!empty($gagal))
                        echo $gagal;
                    ?>
                </div>
            </div>
        </div>
    </body>
<?php
} else {
    header("Location: index.php");
}
?>

    </html>