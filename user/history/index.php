<?php
include("../../conn.php");
include '../assets/css/main.html';

session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../home/index.php");
    exit();
}

function formatName($name)
{
    $parts = explode(' ', $name);
    if (count($parts) === 1) {
        return $name;
    }

    $lastName = array_pop($parts);
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper($part[0]) . '. ';
    }

    return $lastName . ' / ' . rtrim($initials);
}

$user = $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>

    <!-- CSS -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/history/history.css" rel="stylesheet">


</head>

<body>
    <?php
    include '../navbar.php'
    ?>

    <section class="upcoming-flight">
        <div class="container header_upcoming">
            <h1 class="header1" style="color: white;">Upcoming Flights</h1>
        </div>

        <?php
        $stmt = $conn->prepare("SELECT u.nama AS name, f.code AS flight_number, a.code AS from_code, a.city AS from_city, b.code AS to_code, b.city AS to_city, f.departure_date AS departure_date, ft.seat AS seat, f.departure_time AS departure_time 
                                    FROM `flight_transaction` ft 
                                    JOIN `flight` f ON (ft.id_flight = f.id) 
                                    JOIN `user` u ON (ft.id_user = u.id) 
                                    JOIN `airport` a ON (f.from = a.id)
                                    JOIN `airport` b ON (f.to = b.id)
                                    WHERE (u.email = ? OR u.username = ?) AND f.status = 0
                                    ORDER BY ft.id DESC");
        $stmt->bind_param('ss', $user, $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = formatName($row['name']);
                $date = date('d M Y', strtotime($row['departure_date']));
                $time = date('H:i', strtotime($row['departure_time']));
        ?>

                <div class="ticket">
                    <div id="banner">
                        <div id="topbanner"></div>
                        <span id="mainbanner">
                            <i class="fa-solid fa-plane-departure"></i>
                            <b>CDE AIRLINES</b>
                        </span>
                        <span id="tearoffbanner">
                            <b>BOARDING PASS</b>
                        </span>
                    </div>
                    <div id="barcode">
                        <img src="../assets/img/barcode.jpg" alt="">
                    </div>
                    <div id="data">
                        <div id="maindata">
                            <div class="box">
                                <span class="header">
                                    Passenger Name
                                </span>
                                <span class="body">
                                    <b><?php echo $name ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    Flight Number
                                </span>
                                <span class="body">
                                    <b><?php echo $row['flight_number'] ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    From
                                </span>
                                <span class="body">
                                    <b><?php echo $row['from_city'] . " (" . $row['from_code'] . ")" ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    To
                                </span>
                                <span class="body">
                                    <b><?php echo $row['to_city'] . " (" . $row['to_code'] . ")" ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    Date
                                </span>
                                <span class="body">
                                    <b><?php echo $date ?></b>
                                </span>
                            </div>
                            <div class="box">
                            </div>
                            <div class="box">
                                <span class="header">
                                    Seat
                                </span>
                                <span class="body">
                                    <b><?php echo $row['seat'] ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    Departure Time
                                </span>
                                <span class="body">
                                    <b><?php echo $time ?></b>
                                </span>
                            </div>

                            <div id="tearoffdata">
                                <div class="box">
                                    <span class="header">
                                        Passenger Name
                                    </span>
                                    <span class="body">
                                        <b><?php echo $name ?></b>
                                    </span>
                                </div>
                                <div class="box">
                                    <span class="header">
                                        Flight Number
                                    </span>
                                    <span class="body">
                                        <b><?php echo $row['flight_number'] ?></b>
                                    </span>
                                </div>
                                <div class="box">
                                    <span class="header">
                                        Date
                                    </span>
                                    <span class="body">
                                        <b><?php echo $date ?></b>
                                    </span>
                                </div>
                                <div class="box seat">
                                    <span class="header">
                                        Seat
                                    </span>
                                    <span class="body">
                                        <b><?php echo $row['seat'] ?></b>
                                    </span>
                                </div>
                                <div class="box">
                                    <span class="header">
                                        Class
                                    </span>
                                    <span class="body">
                                        <b>Economy</b>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="holes">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>

        <?php
            }
        } else {
            echo "<div class='container list-ticket'>
            <div class='notifications-container text2'>
                <div class='alert'>
                    <div class='flex'>
                        <div class='flex-shrink-0'>
                            <i class='fa-solid fa-triangle-exclamation' style='color: #f3d568;'></i>
                        </div>
                        <div class='alert-prompt-wrap'>
                            <p>
                                You don't have any upcoming flights.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        }

        $stmt->close();
        ?>
    </section>

    <section class="past-flight">
        <div class="container header_past">
            <h1 class="header1" style="color: white;">Past Flights</h1>
        </div>

        <?php
        $stmt = $conn->prepare("SELECT u.nama AS name, f.code AS flight_number, a.code AS from_code, a.city AS from_city, b.code AS to_code, b.city AS to_city, f.departure_date AS departure_date, ft.seat AS seat, f.departure_time AS departure_time 
                                    FROM `flight_transaction` ft 
                                    JOIN `flight` f ON (ft.id_flight = f.id) 
                                    JOIN `user` u ON (ft.id_user = u.id) 
                                    JOIN `airport` a ON (f.from = a.id)
                                    JOIN `airport` b ON (f.to = b.id)
                                    WHERE (u.email = ? OR u.username = ?) AND f.status = 1
                                    ORDER BY ft.id DESC");
        $stmt->bind_param('ss', $user, $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = formatName($row['name']);
                $date = date('d M Y', strtotime($row['departure_date']));
                $time = date('H:i', strtotime($row['departure_time']));
        ?>

                <div class="ticket">
                    <div id="banner" style="border-top: 4vw solid gray;">
                        <div id="topbanner"></div>
                        <span id="mainbanner">
                            <i class="fa-solid fa-plane-departure"></i>
                            <b>CDE AIRLINES</b>
                        </span>
                        <span id="tearoffbanner">
                            <b>BOARDING PASS</b>
                        </span>
                    </div>
                    <div id="barcode">
                        <img src="../assets/img/barcode.jpg" alt="">
                    </div>
                    <div id="data">
                        <div id="maindata">
                            <div class="box">
                                <span class="header">
                                    Passenger Name
                                </span>
                                <span class="body">
                                    <b><?php echo $name ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    Flight Number
                                </span>
                                <span class="body">
                                    <b><?php echo $row['flight_number'] ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    From
                                </span>
                                <span class="body">
                                    <b><?php echo $row['from_city'] . " (" . $row['from_code'] . ")" ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    To
                                </span>
                                <span class="body">
                                    <b><?php echo $row['to_city'] . " (" . $row['to_code'] . ")" ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    Date
                                </span>
                                <span class="body">
                                    <b><?php echo $date ?></b>
                                </span>
                            </div>
                            <div class="box">
                            </div>
                            <div class="box">
                                <span class="header">
                                    Seat
                                </span>
                                <span class="body">
                                    <b><?php echo $row['seat'] ?></b>
                                </span>
                            </div>
                            <div class="box">
                                <span class="header">
                                    Departure Time
                                </span>
                                <span class="body">
                                    <b><?php echo $time ?></b>
                                </span>
                            </div>

                            <div id="tearoffdata">
                                <div class="box">
                                    <span class="header">
                                        Passenger Name
                                    </span>
                                    <span class="body">
                                        <b><?php echo $name ?></b>
                                    </span>
                                </div>
                                <div class="box">
                                    <span class="header">
                                        Flight Number
                                    </span>
                                    <span class="body">
                                        <b><?php echo $row['flight_number'] ?></b>
                                    </span>
                                </div>
                                <div class="box">
                                    <span class="header">
                                        Date
                                    </span>
                                    <span class="body">
                                        <b><?php echo $date ?></b>
                                    </span>
                                </div>
                                <div class="box seat">
                                    <span class="header">
                                        Seat
                                    </span>
                                    <span class="body">
                                        <b><?php echo $row['seat'] ?></b>
                                    </span>
                                </div>
                                <div class="box">
                                    <span class="header">
                                        Class
                                    </span>
                                    <span class="body">
                                        <b>Economy</b>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="holes">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>

        <?php
            }
        } else {
            echo "<div class='container list-ticket'>
            <div class='notifications-container text2'>
                <div class='alert'>
                    <div class='flex'>
                        <div class='flex-shrink-0'>
                            <i class='fa-solid fa-triangle-exclamation' style='color: #f3d568;'></i>
                        </div>
                        <div class='alert-prompt-wrap'>
                            <p>
                                You don't have any past flights.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        }

        $stmt->close();
        ?>
    </section>


    <?php
    include "../footer.php";
    ?>
</body>

</html>