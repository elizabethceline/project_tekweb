<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("../../conn.php");
    $username = $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        include('../assets/css/main.html');
    ?>
    <title>Feedback</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #252529;
        }

        h4 {
            font-size: 2rem;
            font-family: "GothicBold";
        }

        label {
            font-size: 1rem;
            font-family: "GothicBold";
        }

        .container {
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .form-select, .form-control{
            width: 90%;
        }
    </style>
</head>
<body>
    <?php
        include('../navbar.php');
    ?>
    <div class="container rounded-4 bg-white m-5">
        <div class="form-container">
            <form method="post">
                <div class="m-3">
                    <h4 class="text-right">Feedback</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 m-3" id="test">
                        <label class="labels m-1">Topic</label>
                        <select class="form-select" id="topik" name="topik" required>
                            <option value="" selected>Choose</option>
                            <option value="Kenyamanan pesawat">Kenyamanan pesawat</option>
                            <option value="Rasa makanan">Rasa makanan</option>
                            <option value="Service">Service</option>
                        </select>
                    </div>
                    <div class="col-md-12 m-3">
                        <label class="labels m-1">Feedback</label>
                        <textarea name="feedback" id="" cols="30" rows="10" class="form-control"  required></textarea>
                    </div>
                    <div class="my-5 text-center">
                        <button class="btn btn-dark" type="submit">Send Feedback</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['topik']) && isset($_POST['feedback'])) {
        setcookie('berhasil', true, time() + 3600, '/');
        $stmt = $conn->prepare('INSERT INTO feedback VALUES(NULL, ?, ?, NULL)');
        $stmt->bind_param('ss', $topik, $feedback);

        $topik = $_POST['topik'];
        $feedback = $_POST['feedback'];

        $stmt->execute();
        header('Location: feedback.php');
    } 

    $berhasil = '';
    if (isset($_COOKIE['berhasil'])) {
        setcookie('berhasil', null, time() - 3600, '/');

        $berhasil = '<script>
        Swal.fire({
            heightAuto: false,
            title: "Berhasil Mengirimkan Feedback!",
            text: "Terima kasih telah memberikan feedback!",
            icon: "success"
        });
    </script>';
    }

    echo '<div>' . $berhasil . '</div>';
    ob_end_flush();
    ?>

</body>
</html>
