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
    <title>Meals</title>

    <!-- CSS -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/food/menu.css" rel="stylesheet">
    <link href="../assets/css/food/cart.css" rel="stylesheet">
</head>

<body>
    <?php include '../navbar.php' ?>

    <section class="header-button">
        <div class="header-menu">
            <div class="btn-group" role="group" aria-label="menu-btn" style="width: 80vw;">
                <button type="button" class="btn btn-light cart-btn">Cart</button>
                <button type="button" class="btn btn-light active menu-btn">Our Menu</button>
                <button type="button" class="btn btn-light orders-btn">Orders</button>
            </div>
        </div>
    </section>

    <section class="menu">
        <div class="container mb-4 p-4">
            <div class="row justify-content-center">
                <?php
                $sql = "SELECT * from food WHERE status = 0";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $price = number_format($row['price'], 2, ',', '.');
                        $photo = $row['photo'];
                        if (strpos($photo, 'http') === false) {
                            $photo = '../../admin/uploads/' . $photo;
                        }
                        echo '<div class="col-md-4 mx-auto">
                        <div class="card card1 mt-4 mb-4 border-0">
                        <img src="' . $photo . '"class="card-img-top" alt="' . $row["name"] . '">
                            <div class="card-body p-4">
                                <h4 class="card-title"><b>' . $row["name"] . '</b></h4>
                                <p class="card-text">' . $row["description"] . '</p>
                                <h5 class="card-title">Price: Rp' . $price . '</h5>
                                <label for="quantity">Quantity: </label>
                                <input type="number" name="quantity" class="mt-2" id="quantity' . $row["id"] . '" style="width: 5rem"><br>
                                <a href="#" class="btn btn-primary mt-4 add-cart" data-food-id="' . $row["id"] . '" data-food-quantity-input="#quantity' . $row["id"] . '">Add to Cart</a>
                            </div>
                        </div>
                    </div>';
                    }
                } else {
                    echo '<h2 class="header3 mt-4" style="color: white; text-align: center;">There is no available food. Please come back later </h2>';
                }
                ?>
            </div>
        </div>
    </section>

    <section class="cart">
        <div class="card card2 mt-4">
            <div class="row">
                <div class="col-md-8 cart-col">
                    <div class="title">
                        <div class="row">
                            <div class="col">
                                <h4><b>Your Cart</b></h4>
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT f.photo as photo, f.name AS name, f.id AS idFood, c.quantity AS quantity, f.price AS price from `cart` c JOIN `food` f ON (c.id_food = f.id) JOIN `user` u ON (c.id_user = u.id) WHERE u.email = '$user' || u.username = '$user'";
                    $result = $conn->query($sql);
                    $total = 0;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $price = $row["price"] * $row["quantity"];
                            $total += $price;
                            $price = number_format($price, 2, ',', '.');
                            $photo = $row['photo'];
                            if (strpos($photo, 'http') === false) {
                                $photo = '../../admin/uploads/' . $photo;
                            }
                            echo '<div class="row">
                            <div class="row main align-items-center">
                                <div class="col-2"><img class="img-fluid" src="' . $photo . '"></div>
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
                    ?>

                </div>
                <div class="col-md-4 summary">
                    <div>
                        <h5><b>Summary</b></h5>
                    </div>
                    <hr>
                    <form>
                        <p>CHOOSE FLIGHT</p>
                        <select class="choose-flight">
                            <?php
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
                            ?>
                        </select>
                    </form>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <?php
                        $total = number_format($total, 2, ',', '.');
                        echo '<div class="col text-right">Rp' . $total . '</div>';
                        ?>
                    </div>
                    <div class="row" style="text-align: center;">
                        <button class="btn btn-primary checkout-btn">CHECKOUT</button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="orders">
        <?php
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
            echo "<div class='container list-ticket' mt-4 mb-4>
            <div class='notifications-container text2'>
                <div class='alert'>
                    <div class='flex'>
                        <div class='flex-shrink-0'>
                            <i class='fa-solid fa-triangle-exclamation' style='color: #f3d568;'></i>
                        </div>
                        <div class='alert-prompt-wrap'>
                            <p>
                                You don't have any transaction history.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        }
        ?>

    </section>

    <?php include '../footer.php' ?>

    <script>
        $(document).ready(function() {
            $('.menu').show();
            $('.orders').hide();
            $('.cart').hide();

            $('.btn-light').on('click', function() {
                $('.btn-light').removeClass('active');
                $(this).addClass('active');
            });

            $('.cart').on('click', '.plus-quanti', function() {
                var foodId = $(this).data('food-id');
                var type = "add";

                $.ajax({
                    type: "POST",
                    url: "updateCart.php",
                    data: {
                        foodId: foodId,
                        type: type
                    },
                    success: function(response) {
                        $(".cart").html(response);
                    },
                    error: function(error) {
                        console.log("Error:", error);
                    }
                });
            });

            $('.cart').on('click', '.min-quanti', function() {
                var foodId = $(this).data('food-id');
                var type = "min";

                $.ajax({
                    type: "POST",
                    url: "updateCart.php",
                    data: {
                        foodId: foodId,
                        type: type
                    },
                    success: function(response) {
                        $(".cart").html(response);
                    },
                    error: function(error) {
                        console.log("Error:", error);
                    }
                });
            });

            $('.cart').on('click', '.checkout-btn', function() {
                var flight_number = $(".choose-flight").val();
                var check = $('.name-row').text();

                if (flight_number == "No flights available") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please purchase a flight ticket first!',
                    });
                    return;
                }

                if (!check) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your cart is empty. Please add items before checkout!',
                    });
                    return;
                }

                Swal.fire({
                        title: "Confirmation",
                        text: "Are you sure you want to checkout these items?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes!"
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "checkout.php",
                                success: function(response) {
                                    $('.cart').hide();
                                    $('.menu').hide();
                                    $(".orders").html(response);
                                    $('.cart-btn').removeClass('active');
                                    $('.orders-btn').addClass('active');
                                    $('.orders').show();
                                    $('html, body').scrollTop(0);
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order successful!',
                                        text: 'Your order has been processed successfully!',
                                    });
                                },
                                data: {
                                    flight_number: flight_number
                                },
                                error: function(error) {
                                    console.log("Error:", error);
                                }
                            });
                        }
                    });

            });

            $('.menu').on('click', '.add-cart', function() {
                var foodId = $(this).data('food-id');
                var inputQuantity = $(this).data('food-quantity-input');
                var quantity = $(inputQuantity).val();
                var type = "add";

                if (!quantity || quantity < 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please enter a valid quantity!',
                    });
                    $(inputQuantity).val('');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "updateCart.php",
                    data: {
                        foodId: foodId,
                        quantity: quantity,
                        type: type
                    },
                    success: function(response) {
                        $('.menu').hide();
                        $('.orders').hide();
                        $(".cart").html(response);
                        $('.menu-btn').removeClass('active');
                        $('.cart-btn').addClass('active');
                        $('.cart').show();
                        $('html, body').scrollTop(0);
                        $(inputQuantity).val('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Quantity updated!',
                        });
                    },
                    error: function(error) {
                        console.log("Error:", error);
                    }
                });

            });

            $('.cart-btn').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: "reloadCart.php",
                    success: function(response) {
                        $('.menu').hide();
                        $('.orders').hide();
                        $(".cart").html(response);
                        $('.menu-btn').removeClass('active');
                        $('.cart-btn').addClass('active');
                        $('.cart').show();
                        $('html, body').scrollTop(0);
                    },
                    error: function(error) {
                        console.log("Error:", error);
                    }
                });
            });

            $('.menu-btn').on('click', function() {
                $('.menu').show();
                $('.orders').hide();
                $('.cart').hide();
                $('html, body').scrollTop(0);
            });

            $('.orders-btn').on('click', function() {
                $('.menu').hide();
                $('.orders').show();
                $('.cart').hide();
                $('html, body').scrollTop(0);
            });
        });
    </script>
</body>

</html>