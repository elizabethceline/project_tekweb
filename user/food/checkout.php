<?php
include("../../conn.php");

session_start();
$user = $_SESSION["email"];

function checkoutFoodTransaction($userId, $flight_number, $foodItems)
{
    global $conn;

    // Insert into food_transaction
    $total = 0;

    foreach ($foodItems as $foodItem) {
        $foodId = $foodItem['id'];
        $quantity = $foodItem['quantity'];

        $sql = "SELECT * FROM food WHERE id = $foodId";
        $resultFood = $conn->query($sql);

        if ($resultFood->num_rows > 0) {
            $foodRow = $resultFood->fetch_assoc();
            $total += $foodRow['price'] * $quantity;
        }
    }

    $sql = "SELECT id FROM flight WHERE code = '$flight_number'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $flightId = $row["id"];
    }

    $sql = "INSERT INTO food_transaction (id_user, id_flight, total) VALUES ($userId, $flightId, $total)";
    $conn->query($sql);

    $foodTransactionId = $conn->insert_id;

    foreach ($foodItems as $foodItem) {
        $foodId = $foodItem['id'];
        $quantity = $foodItem['quantity'];

        $sql = "INSERT INTO food_transaction_details (id_food_transaction, id_food, quantity) VALUES ($foodTransactionId, $foodId, $quantity)";
        $conn->query($sql);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["flight_number"])) {
        $flight_number = $_POST["flight_number"];

        $foodItems = array();

        $sql = "SELECT f.id AS id, c.quantity AS quantity, u.id AS userId FROM cart c
                JOIN food f ON c.id_food = f.id
                JOIN user u ON c.id_user = u.id
                WHERE u.email = '$user' OR u.username = '$user'";
        $resultCart = $conn->query($sql);

        if ($resultCart->num_rows > 0) {
            while ($row = $resultCart->fetch_assoc()) {
                $foodItems[] = array(
                    'id' => $row['id'],
                    'quantity' => $row['quantity']
                );
                $userId = $row["userId"];
            }
        }

        checkoutFoodTransaction($userId, $flight_number, $foodItems, $conn);

        // Delete data setelah checkout
        $delete = "DELETE FROM cart WHERE id_user = (SELECT id FROM `user` WHERE (email = '$user' || username = '$user'))";
        $conn->query($delete);

        $sql = "SELECT ft.timestamp AS time, ft.id AS ftid, f.code AS flight_number, ft.total AS total
        FROM `food_transaction` ft
        JOIN `user` u ON (ft.id_user = u.id)
        JOIN `flight` f ON (ft.id_flight = f.id)
        WHERE (u.email = '$user' OR u.username = '$user')
        ORDER BY ft.id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ft_id = $row["ftid"];
                $total = number_format($row["total"], 2, ',', '.');
                echo '<div class="card card2 mt-4">
                <div class="row">
                    <div class="col-md-8 cart-col">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    <h4><b>Item Details</b></h4>
                                </div>
                                <div class="col align-self-center text-right text-muted">' . $row["time"] . '</div>
                            </div>
                        </div>';
                $sqlitems = "SELECT f.photo as photo, f.name AS name, ftd.quantity AS quanti, f.price AS price
                                FROM `food_transaction_details` ftd
                                JOIN `food_transaction` ft ON (ftd.id_food_transaction = ft.id)
                                JOIN `food` f ON (ftd.id_food = f.id)
                                WHERE ftd.id_food_transaction = '$ft_id'";
                $itemsresult = $conn->query($sqlitems);
                if ($itemsresult->num_rows > 0) {
                    while ($items = $itemsresult->fetch_assoc()) {
                        $price = $items["quanti"] * $items["price"];
                        $price = number_format($price, 2, ',', '.');
                        $photo = $items['photo'];
                        if (strpos($photo, 'http') === false) {
                            $photo = '../../admin/uploads/' . $photo;
                        }
                        echo '<div class="row">
                            <div class="row main align-items-center">
                                <div class="col-2"><img class="img-fluid" src="' . $photo . '"></div>
                                <div class="col">
                                    <div class="row">' . $items["name"] . '</div>
                                </div>
                                <div class="col">
                                ' . $items["quanti"] . '
                                </div>
                                <div class="col">Rp' . $price . '</div>
                            </div>
                        </div>';
                    }
                }
                echo '
                    </div>
                    <div class="col-md-4 summary">
                        <div>
                            <h5><b>Summary</b></h5>
                        </div>
                        <hr>
                        <form>
                            <p>FLIGHT NUMBER</p>
                            <h4><b>' . $row["flight_number"] . '</b></h4>
                        </form>
                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col">TOTAL PRICE</div>
                            <div class="col text-right">Rp' . $total . '</div>
                        </div>
                    </div>
                </div>
            </div>';
            }
        } else {
            echo "<h1>You don't have any order history</h1>";
        }
    } else {
        http_response_code(400);
        echo "Bad Request: Missing flight_number parameter";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed: Only POST requests are allowed";
}

$conn->close();
