<?php
    session_start();
    if (isset($_SESSION["email"])) {
        require_once("../../conn.php");
        $username = $_SESSION["email"];
        // echo $username;

    include '../assets/css/main.html';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Sweet Alert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../assets/css/main.css" rel="stylesheet">
    <title>User Profile</title>

    <style>
        body {
            margin-top: 100px;
        }

        .hline {
            width: 90%;
            border-bottom: 2px solid grey;
            margin: 3vh;
        }

        .container {
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.35);
        }

        #change-password{
            display: none;
        }
    </style>
    <script>
        $(document).ready(function(){
            $("#myAccountButton").on("click", function(){
                $("#changePassButton").removeClass("btn-secondary");
                $("#changePassButton").addClass("btn-dark");
                $("#changePassButton").prop("disabled", false);
                $("#myAccountButton").prop("disabled", true);
                $("#change-password").hide();
                $("#profile").show();
            })

            $("#changePassButton").on("click", function(){
                $("#myAccountButton").removeClass("btn-secondary");
                $("#myAccountButton").addClass("btn-dark");
                $("#myAccountButton").prop("disabled", false);
                $("#changePassButton").prop("disabled", true);
                $("#profile").hide();
                $("#change-password").show();
            })
        })
    </script>
</head>
<body>
    <?php
        include("../navbar.php");
    ?>
    <div class="container rounded-4 mt-5">
        <div class="row">
            <div class="col-md-4 col-lg-3 bg-white border rounded-start-4">
                <div class="d-flex flex-column align-items-center text-center p-3 py-3"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <span class="font-weight-bold">
                        <?php
                            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0){
                                while ($row = $result->fetch_assoc()){
                                    echo $row['nama'];
                                
                        ?>
                    </span>
                    <span class="text-black-50">
                        <?php
                                    echo $row['email'];
                        ?>
                    </span>
                    <div class="hline"></div>
                </div>
                <div class="d-flex flex-column">
                    <span style="color: grey;" class="mx-3">Account</p>
                    <button class="btn btn-secondary d-flex text-right mb-3" style="width: 80%;" id="myAccountButton" disabled>My account</button>
                    <button class="btn btn-dark d-flex text-right mb-3" style="width: 80%;" id="changePassButton">Change password</button>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 bg-white border rounded-end-4" id="profile">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-3">
                        <form method="post">
                            <div class="col-md-12 mt-3"><label class="labels">Name</label><input type="text" name="inputNama" class="form-control" placeholder="Name" value='<?php echo $row['nama'];?>'></div>
                            <div class="col-md-12 mt-3"><label class="labels">Username</label><input type="text" disabled name="inputUsername" class="form-control" placeholder="Username" value=<?php echo $row['username'];?>></div>
                            <div class="col-md-12 mt-3"><label class="labels">Email</label><input type="email" disabled name="inputEmail" class="form-control" placeholder="Email" value=<?php echo $row['email'];?>></div>
                            <div class="col-md-12 mt-3"><label class="labels">Phone number</label><input type="text" name="inputNomorTelp" class="form-control" placeholder="Phone number" value=<?php echo $row['no_telp'];?> minlength="10" maxlength="13"></div>
                            <div class="col-md-12 mt-3"><label class="labels">Passport number</label><input type="text" disabled name="inputNomorPassport" class="form-control" placeholder="Passport number" value=<?php echo $row['no_passport'];?> minlength="8" maxlength="8"></div>
                            <div class="mt-5 text-center"><button class="btn btn-dark profile-button" type="submit" id="changeButton">Change Profile</button></div>
                        </form>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 border rounded-4" id="change-password">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Change Password</h4>
                    </div>
                    <div class="row mt-3">
                        <form method="post">
                            <div class="col-md-12 mt-3"><label class="labels">Old Password</label><input type="password" class="form-control" placeholder="Old Password" value="" name="oldPassword"></div>
                            <div class="col-md-12 mt-3"><label class="labels">New Password</label><input type="password" class="form-control" placeholder="New Password" value="" name="newPassword"></div>
                            <div class="mt-5 text-center"><button class="btn btn-dark profile-button" type="submit">Change Password</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    if (isset($_POST["oldPassword"]) && isset($_POST["newPassword"])){
        $stmt = $conn->prepare("SELECT password FROM user WHERE (username = ? OR email = ?) AND password = PASSWORD(?)");
        $stmt->bind_param("sss", $username, $username, $oldPassword);

        $oldPassword = $_POST["oldPassword"];

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            setcookie('berhasil-pass', true, time() + 3600, '/');
            $stmt = $conn->prepare("UPDATE user SET password = PASSWORD(?) WHERE username = ? OR email = ?");
            $stmt->bind_param("sss", $newPassword, $username, $username);

            $newPassword = $_POST["newPassword"];
            $stmt->execute();
            header('Location: profile.php');
        } else {
            setcookie('gagal', true, time() + 3600, '/');
            header('Location: profile.php');
        }
    } elseif (isset($_POST["inputNama"]) && isset($_POST["inputUsername"]) && isset($_POST["inputEmail"]) && isset($_POST["inputNomorTelp"]) && isset($_POST["inputNomorPassport"])) {
        setcookie('berhasil-profile', true, time() + 3600, '/');
        $stmt = $conn->prepare("UPDATE user SET nama = ?, username = ?, email = ?, no_telp = ?, no_passport = ? WHERE username = ?");
        $stmt->bind_param("ssssss", $nama, $updateUsername, $email, $no_telp, $no_passport, $username);

        $nama = $_POST["inputNama"];
        $updateUsername = $_POST["inputUsername"];
        $email = $_POST["inputEmail"];
        $no_telp = $_POST["inputNomorTelp"];
        $no_passport = $_POST["inputNomorPassport"];

        $stmt->execute();
        $_SESSION["email"] = $_POST["inputUsername"];
        $username = $_SESSION["email"];
        header('Location: profile.php');
    }
} else {
        header("Location: index.php");
        exit();
    }

    $berhasilProfile = '';
    if (isset($_COOKIE['berhasil-profile'])) {
        setcookie('berhasil-profile', null, time() - 3600, '/');
        $berhasilProfile = '<script>
                Swal.fire({
                    title: "Profile berhasil diganti!",
                    text: "Kembali ke profile menu",
                    icon: "success"
                });
            </script>';
    }

    $berhasilPass = '';
    if (isset($_COOKIE['berhasil-pass'])) {
        setcookie('berhasil-pass', null, time() - 3600, '/');
        $berhasilPass = '<script>
                Swal.fire({
                    title: "Password berhasil diganti!",
                    text: "Kembali ke profile menu",
                    icon: "success"
                });
            </script>';
    }

    $gagal = '';
    if (isset($_COOKIE['gagal'])) {
        setcookie('gagal', null, time() - 3600, '/');
        $gagal = '<script>
            Swal.fire({
                title: "Password Salah!",
                text: "Inputkan password yang benar!",
                icon: "error"
            });
        </script>';
    }

    ob_end_flush();
    ?>
    <div>
    <?php
    if (!empty($berhasilProfile))
        echo $berhasilProfile;

    if (!empty($berhasilPass))
        echo $berhasilPass;
?>
    </div>
</body>
</html>