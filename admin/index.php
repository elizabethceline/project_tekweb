<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../user/assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin login</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* background-color: white !important; */
        }

        h1 {
            font-size: 3rem;
            font-family: "GothicBold";
        }

        label {
            font-size: 1rem;
            font-family: "GothicBold";
        }

        .container {
            width: 480px;
            max-width: 100%;
            min-height: 320px;
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.35);
        }

        .container button {
            text-transform: uppercase;   
            letter-spacing: 1px;
        }

        .form-control{
            width: 90%;
            border: none;
            border-bottom: solid 1px;
            border-radius: 4px 4px 0 0 ;
        }

        .sign-container {
            display: flex;
            justify-content: center;
        }
    </style>

</head>
<body>
    <div class="container rounded-4 bg-white m-5 p-3">
        <div class="form-container">
            <form method="post">
                <div class="sign-container"><h1 class="my-3">Sign In</h1></div>
                    <div class="row">
                        <div class="col-12 m-3"><label class="m-1">Username</label><input type="text" required class="form-control" placeholder="Username" name="username" required></div>
                        <div class="col-12 m-3"><label class="m-1">Password</label><input type="password" required class="form-control" placeholder="Password" name="password" required></div>
                        <div class="my-3 text-center"><button class="btn btn-dark" type="submit">Sign-in</button></div>
                    </div>
            </form>
        </div>
    </div>

    <?php
        if (isset($_POST['username']) && isset($_POST['password'])) {
            require_once('../conn.php');
            $stmt = $conn->prepare('SELECT * from admin WHERE username = ? AND password = PASSWORD(?)');
            $stmt->bind_param('ss', $username, $password);

            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['username'] = $username;
                if(isset($_SESSION['username'])) {
                    header('Location: addFlight.php');
                }
            } else {
                setcookie('gagal', true, time() + 3600, '/');
                header('Location: index.php');
            }
        } else {
            session_destroy();
        }

        $gagal = '';
        if (isset($_COOKIE['gagal'])) {
            setcookie('gagal', null, time() + 3600, '/');
            $gagal = "<script>
                Swal.fire({
                    heightAuto: false,
                    title: 'Username / Password Salah!',
                    text: 'Inputkan data yang benar!',
                    icon: 'error'
                });
            </script>";
        }

        if (!empty($gagal))
            echo $gagal;
    ?>
</body>
</html>