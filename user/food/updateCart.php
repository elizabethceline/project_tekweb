<?php
include("../../conn.php");

session_start();
$user = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["foodId"]) && isset($_POST["type"])) {
        $foodId = $_POST["foodId"];
        $type = $_POST["type"];

        $checkSql = "SELECT `quantity` FROM `cart` WHERE `id_food` = $foodId AND `id_user` = (SELECT `id` FROM `user` WHERE `email` = '$user' OR `username` = '$user')";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            // Food already in the cart, update the quantity
            $currentQuantity = $checkResult->fetch_assoc()["quantity"];

            if ($type === "add") {
                if (isset($_POST["quantity"])) {
                    $quantity = $_POST["quantity"];
                    $updateSql = "UPDATE `cart` SET `quantity` = $currentQuantity + $quantity WHERE `id_food` = $foodId AND `id_user` = (SELECT `id` FROM `user` WHERE `email` = '$user' OR `username` = '$user')";
                } else {
                    $updateSql = "UPDATE `cart` SET `quantity` = $currentQuantity + 1 WHERE `id_food` = $foodId AND `id_user` = (SELECT `id` FROM `user` WHERE `email` = '$user' OR `username` = '$user')";
                }
            } elseif ($type === "min") {
                $updateSql = "UPDATE `cart` SET `quantity` = $currentQuantity - 1 WHERE `id_food` = $foodId AND `id_user` = (SELECT `id` FROM `user` WHERE `email` = '$user' OR `username` = '$user')";
            }

            $conn->query($updateSql);

            $sql = "DELETE FROM cart WHERE quantity = 0;";
            $conn->query($sql);
        } else {
            $quantity = $_POST["quantity"];
            $insertSql = "INSERT INTO `cart` (`id_user`, `id_food`, `quantity`) VALUES ((SELECT `id` FROM `user` WHERE `email` = '$user' OR `username` = '$user'), $foodId, $quantity)";
            $conn->query($insertSql);
        }

        $sql = "SELECT f.name AS name, f.id AS idFood, c.quantity AS quantity, f.price AS price from `cart` c JOIN `food` f ON (c.id_food = f.id) JOIN `user` u ON (c.id_user = u.id) WHERE u.email = '$user' || u.username = '$user'";
        $result = $conn->query($sql);
        $total = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $price = $row["price"] * $row["quantity"];
                $total += $price;
                $price = number_format($price, 2, ',', '.');
                echo '        <div class="card card2 mt-4">
                <div class="row">
                    <div class="col-md-8 cart-col">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    <h4><b>Your Cart</b></h4>
                                </div>
                            </div>
                        </div>';
                $sql = "SELECT f.name AS name, f.id AS idFood, c.quantity AS quantity, f.price AS price from `cart` c JOIN `food` f ON (c.id_food = f.id) JOIN `user` u ON (c.id_user = u.id) WHERE u.email = '$user' || u.username = '$user'";
                $result = $conn->query($sql);
                $total = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $price = $row["price"] * $row["quantity"];
                        $total += $price;
                        $price = number_format($price, 2, ',', '.');
                        echo '<div class="row">
                                <div class="row main align-items-center">
                                    <div class="col-2"><img class="img-fluid" src="img/path"></div>
                                    <div class="col">
                                        <div class="row name-row">' . $row["name"] . '</div>
                                    </div>
                                    <div class="col">
                                        <a href="#" class="min-quanti" data-food-id="' . $row["idFood"] . '">-</a>
                                        <a href="#" class="border" id="quantity">' . $row["quantity"] . '</a>
                                        <a href="#" class="plus-quanti" data-food-id="' . $row["idFood"] . '">+</a>
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
                            <p>CHOOSE FLIGHT</p>
                            <select class="choose-flight">';
                $sql = "SELECT * FROM `flight_transaction` ft
                                    JOIN `user` u ON (ft.id_user = u.id)
                                    JOIN `flight` f ON (ft.id_flight = f.id)
                                    WHERE (u.email = '$user' OR u.username = '$user') AND f.status = 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option class="text-muted" value="' . $row["code"] . '">' . $row["code"] . '</option>';
                    }
                } else {
                    echo '<option class="text-muted disabled">No flights available</option>';
                }
                echo '
                            </select>
                        </form>
                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col">TOTAL PRICE</div>';
                $total = number_format($total, 2, ',', '.');
                echo '<div class="col text-right">Rp' . $total . '</div>
                        </div>
                        <div class="row" style="text-align: center;">
                            <button class="btn btn-primary checkout-btn">CHECKOUT</button>
                        </div>
                    </div>
                </div>
    
            </div>';
            }
        } else {
            echo '<div class="card card2 mt-4">
            <div class="row">
                <div class="col-md-8 cart-col">
                    <div class="title">
                        <div class="row">
                            <div class="col">
                                <h4><b>Your Cart</b></h4>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="row main align-items-center">
                                <div class="col">
                                    <div class="row name-row"></div>
                                </div>
                                <div class="col">
                                    
                                </div>
                                <div class="col"></div>
                            </div>
                        </div>

                </div>
                <div class="col-md-4 summary">
                    <div>
                        <h5><b>Summary</b></h5>
                    </div>
                    <hr>
                    <form>
                        <p>CHOOSE FLIGHT</p>
                        <select>';
            $sql = "SELECT * FROM `flight_transaction` ft
                                JOIN `user` u ON (ft.id_user = u.id)
                                JOIN `flight` f ON (ft.id_flight = f.id)
                                WHERE (u.email = '$user' OR u.username = '$user') AND f.status = 0";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option class="text-muted">' . $row["code"] . '</option>';
                }
            } else {
                echo '<option class="text-muted disabled">No flights available</option>';
            }
            echo '</select>
                    </form>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <div class="col text-right">Rp0,00</div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <button class="btn btn-primary checkout-btn">CHECKOUT</button>
                    </div>
                </div>
            </div>

        </div>';
        }
    } else {
        http_response_code(400);
        echo "Bad Request: Missing foodId or type parameter";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed: Only POST requests are allowed";
}

$conn->close();
