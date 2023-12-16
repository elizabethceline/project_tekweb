<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <title>Login Page</title>
</head>

<body>
    <div class="container" id="container">

        <!-- Sign-up -->
        <div class="form-container sign-up">
            <form method="post">
                <h1 style="margin-bottom: 1vh;">Create Account</h1>
                <input type="text" placeholder="Name" name="signupName" required>
                <input type="text" placeholder="Username" name="signupUsername" required>
                <input type="email" placeholder="Email" name="signupEmail" required>
                <input type="text" placeholder="Passport No." name="passport" minlength="8" maxlength="8" required>
                <input type="text" placeholder="Phone Number" name="phoneNumber" minlength="10" maxlength="13" required>
                <input type="password" placeholder="Password" name="signupPassword" required>
                <p class="account-text">Already have an account? <a href="#" id="login2">Sign-in</a></p>
                <button>Sign Up</button>
            </form>
        </div>

        <!-- Login -->
        <div class="form-container sign-in">
            <form method="post">
                <h1 style="margin-bottom: 1vh;">Sign In</h1>
                <input type="text" placeholder="Email / Username" id="signEmail" name="email" required>
                <input type="password" placeholder="Password" id="PassEmail" name="password" required>
                <a href="#" id="forget">Forget Your Password?</a>
                <p class="account-text">Don't have an account? <a href="#" id="register2">Sign-up</a></p>
                <button type="submit" id="signin">Sign-in</button>
            </form>
        </div>

        <div class="form-container forget-password">
            <form method="post">
                <h1 style="margin-bottom: 1vh;">Password Recovery</h1>
                <input type="text" placeholder="Email / Username" id="recoverEmail" name="emailRecovery" required>
                <input type="password" placeholder="New Password" id="recoverPass" name="passwordRecovery" required>
                <button type="submit" id="update">Update</button>
            </form>
        </div>

        <!-- Toggle -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome !</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
session_start();
if (isset($_POST["email"]) && isset($_POST["password"])) {
    require_once("../../conn.php");
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT email, password FROM user where email = ? and password=password(?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script> alert('password benar') </script>";
        $_SESSION["email"] = $email;
        if (isset($_SESSION['email'])) {
            header('location: ../home/index.php');
        }
    } else {
        $stmt = $conn->prepare("SELECT username, password FROM user where username = ? and password=password(?)");
        $stmt->bind_param("ss", $username, $password);
        $username = $_POST["email"];
        $password = $_POST["password"];
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script> alert('password benar') </script>";
            $_SESSION["email"] = $username;
            if (isset($_SESSION['email'])) {
                header('location: ../home/index.php');
            }
        } else {
?>
            <script>
                Swal.fire({
                    title: "Password Salah!",
                    text: "Inputkan password yang benar!",
                    icon: "error"
                });
            </script>
        <?php
            session_destroy();
        }
    }
} elseif (isset($_POST["signupName"]) && isset($_POST["signupUsername"]) && isset($_POST["signupEmail"]) && isset($_POST["passport"]) && isset($_POST["phoneNumber"]) && isset($_POST["signupPassword"])) {
    require_once("../../conn.php");
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
        ?>
        <script>
            Swal.fire({
                title: "Username telah dipakai!",
                text: "Inputkan username lain!",
                icon: "error"
            });
        </script>
        <?php
    } else {
        $stmtEmail->bind_param("s", $email);
        $stmtEmail->execute();
        $resultEmail = $stmtEmail->get_result();
        if ($resultEmail->num_rows > 0) {
        ?>
            <script>
                Swal.fire({
                    title: "Email telah dipakai!",
                    text: "Inputkan email lain!",
                    icon: "error"
                });
            </script>
            <?php
        } else {
            $stmtPassport->bind_param("s", $passport);
            $stmtPassport->execute();
            $resultPassport = $stmtPassport->get_result();
            if ($resultPassport->num_rows > 0) {
            ?>
                <script>
                    Swal.fire({
                        title: "Nomor passport sudah dipakai!",
                        text: "Inputkan nomor passport lain!",
                        icon: "error"
                    });
                </script>
            <?php
            } else {
                $stmt->bind_param("ssssss", $username, $password, $nama, $passport, $telp, $email);
                $stmt->execute();
                echo "<script> alert('Akun berhasil dibuat!') </script>";
            ?>
                <script>
                    Swal.fire({
                        title: "Akun berhasil dibuat!",
                        text: "Silahkan login!",
                        icon: "success"
                    });
                </script>
        <?php
            }
        }
    }
} elseif (isset($_POST["emailRecovery"]) && isset($_POST["passwordRecovery"])) {
    require_once("../../conn.php");
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $username = $_POST["emailRecovery"];
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE user SET password = password(?) WHERE username = ?");
        $stmt->bind_param("ss", $password, $username);
        $password = $_POST["passwordRecovery"];
        $stmt->execute();
        ?>
        <script>
            Swal.fire({
                title: "Password berhasil diganti!",
                text: "Silahkan login!",
                icon: "success"
            });
        </script>
        <?php
    } else {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE user SET password = password(?) WHERE email = ?");
            $stmt->bind_param("ss", $password, $username);
            $password = $_POST["passwordRecovery"];
            $stmt->execute();
        ?>
            <script>
                Swal.fire({
                    title: "Password berhasil diganti!",
                    text: "Silahkan login!",
                    icon: "success"
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    title: "Username / email tidak terdaftar dalam database !",
                    text: "Masukkan username / email yang benar!",
                    icon: "error"
                });
            </script>
<?php
        }
    }
}
?>

</html>