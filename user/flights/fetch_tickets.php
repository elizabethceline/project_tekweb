<?php

include("../../conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["airportFrom"]) && isset($_POST["airportTo"]) && isset($_POST["departureDate"])) {
        // Get user input
        $airportFrom = $_POST["airportFrom"];
        $airportTo = $_POST["airportTo"];
        $departureDate = $_POST["departureDate"];

        $stmt = $conn->prepare("SELECT * FROM `airport` WHERE id = ?");
        $stmt->bind_param("i", $airportFrom);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $from_name = $row["name"];
                $from_city = $row["city"];
                $from_code = $row["code"];
            }
        } else {
            echo "no result";
        }

        $stmt = $conn->prepare("SELECT * FROM `airport` WHERE id = ?");
        $stmt->bind_param("i", $airportTo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $to_name = $row["name"];
                $to_city = $row["city"];
                $to_code = $row["code"];
            }
        } else {
            echo "no result";
        }

        $stmt = $conn->prepare("SELECT * FROM `flight` WHERE `from` = ? AND `to` = ? AND `departure_date` = ?");
        $stmt->bind_param("iss", $airportFrom, $airportTo, $departureDate);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='container header_display'>
        <div class='header_heading'>
            <button type='button'><a href='../flights/index.php' class='text2'><i class='fa-solid fa-rotate-left'></i> Back</a></button>
            <h1 class='header1' style='color: white'>1. Choose Flight</h1>
        </div>
        <div class='container display-box' style='text-align: left;'>
            <div class='row'>
                <div class='col-md-4 my-1'>
                    <h1 class='text tebel'><i class='fa-solid fa-plane-departure'></i> From</h1>
                    <h2 class='box-info text3'>" . $from_name . ', ' . $from_city . ' (' . $from_code . ')' . "</h2>
                </div>
                <div class='col-md-4 my-1'>
                    <h1 class='text tebel'><i class='fa-solid fa-plane-arrival'></i> To</h1>
                    <h2 class='box-info text3'>" . $to_name . ', ' . $to_city . ' (' . $to_code . ')' . "</h2>
                </div>
                <div class='col-md-4 my-1'>
                    <h1 class='text tebel'><i class='fa-solid fa-calendar-days'></i> Departure Date</h1>
                    <h2 class='box-info text3'>" . $departureDate . "</h2>
                </div>
            </div>
        </div>
    </div>";

        if ($result->num_rows > 0) {
            echo "<div class='container list-ticket'>
    <div class='accordion accordion-flush' id='accordionExample'>";

            // Display fetched tickets
            $index = 1;
            while ($row = $result->fetch_assoc()) {
                $accordionId = 'collapse' . $index;
                $flightId = $row['id'];

                // Format date
                $departureTime = new DateTime($row['departure_time']);
                $arrivalTime = new DateTime($row['arrive_time']);

                // Format time
                $departureTime = $departureTime->format('H:i');
                $arrivalTime = $arrivalTime->format('H:i');

                $price = number_format($row['price'], 2, ',', '.');

                echo "<div class='accordion-item'>
        <h2 class='accordion-header'>
            <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#$accordionId' aria-expanded='true' aria-controls='#$accordionId' data-flight-id='$flightId'>
                <div class='container'>
                    <div class='row p-2'>
                        <div class='col-3'>
                            <p class='text2'>" . $from_code . "</p>
                        </div>
                        <div class='col-2'> </div>
                        <div class='col-3'>
                            <p class='text2'>" . $to_code . "</p>
                        </div>
                        <div class='col-4'>
                            <p class='text2'>Price</p>
                        </div>
                    </div>
                    <div class='row p-2'>
                        <div class='col-3'>
                            <p class='text2 tebel jauh'>" . $departureTime . "</p>
                        </div>
                        <div class='col-2'>
                            <p class='text2'><i class='fa-solid fa-arrow-right'></i></p>
                        </div>
                        <div class='col-3'>
                            <p class='text2 tebel jauh'>" . $arrivalTime . "</p>
                        </div>
                        <div class='col-4'>
                            <p class='text2 tebel jauh'>Rp" . $price . "</p>
                        </div>
                    </div>
                </div>
            </button>
        </h2>
        <div id='$accordionId' class='accordion-collapse collapse show' data-bs-parent='#accordionExample'>
            <div class='accordion-body'>
                <div class='container'>
                    <div class='row p-2'>
                        <div class='col'>
                            <p class='text2 tebel'>Flight Number</p>
                            <p class='text2'>" . $row['code'] . "</p>
                        </div>
                        <div class='col'>
                            <p class='text2 tebel'>Passenger</p>
                            <p class='text2'>1 person</p>
                        </div>
                        <div class='col'>
                            <p class='text2 tebel'>Departure</p>
                            <p class='text2'>" . $row['departure_date'] . "</p>
                        </div>
                    </div>
                    <div class='row p-2'>
                        <div class='col'>
                            <p class='text2 tebel'>Duration</p>
                            <p class='text2'>" . $row['flight_time'] . "</p>
                        </div>
                        <div class='col'>
                            <p class='text2 tebel'>Class</p>
                            <p class='text2'>Economy</p>
                        </div>
                        <div class='col'>
                            <p class='text2 tebel'>Return</p>
                            <p class='text2'>One Way</p>
                        </div>
                    </div>
                    <div class='row p-2'>
                        <button type='button' class='btn btn-primary btn-book tebel'>Book</button>
                    </div>
                </div>
            </div>
        </div>
    </div>";
                $index++;
            }
            echo "    </div>
    </div>";
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
                            There are no flights available. Please come back later.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
        }
    } else {
        http_response_code(400);
        echo "Bad Request: Missing parameter";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed: Only POST requests are allowed";
}
$stmt->close();
$conn->close();
?>