<?php
include("../../conn.php");
include '../assets/css/main.html';

session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../home/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flights</title>

    <!-- CSS -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/flights/search-ticket.css" rel="stylesheet">
    <link href="../assets/css/flights/display-ticket.css" rel="stylesheet">
    <link href="../assets/css/flights/choose-seat.css" rel="stylesheet">

</head>

<body>
    <?php
    include '../navbar.php'
    ?>

    <section class="search-ticket">
        <div class="container header_search">
            <h1 class="header1" style="color: white;">Search Flight</h1>
        </div>

        <div class="container search-box">
            <div class="row">
                <div class="col mx-2 my-1">
                    <h1 class="text tebel"><i class="fa-solid fa-plane-departure"></i> From</h1>
                    <div class="dropdown">
                        <div class="dropdown-main text">
                            <select name="airport_from" id="airport_from">
                                <?php
                                $sql = "SELECT * FROM `airport` ORDER BY id";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $row["id"] ?>"><?php echo $row["city"] . " (" . $row["code"] . ")" ?></option>
                                <?php
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col mx-2 my-1">
                    <h1 class="text tebel"><i class="fa-solid fa-plane-arrival"></i> To</h1>
                    <div class="dropdown">
                        <div class="dropdown-main text">
                            <select name="airport_to" id="airport_to">
                                <?php
                                $sql = "SELECT * FROM `airport` ORDER BY id DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $row["id"] ?>"><?php echo $row["city"] . " (" . $row["code"] . ")" ?></option>
                                <?php
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col mx-2 my-1">
                    <h1 class="text tebel"><i class="fa-solid fa-calendar-days"></i> Departure Date</h1>
                    <div class="dropdown">
                        <div class="dropdown-main text">
                            <input type="date" id="departure_date" name="departure_date" class="depart text2" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <button type="submit" class="btn btn-primary btn-search text2">Search <i class="fa-solid fa-magnifying-glass-arrow-right" style="color: #ffffff;"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class='display-ticket'></section>

    <section class='choose-seat'></section>

    <section class='confirm-booking'></section>

    <?php
    include "../footer.php";
    ?>

    <script>
        function create_custom_dropdowns() {
            $('select').each(function(i, select) {
                if (!$(this).next().hasClass('dropdown-select')) {
                    $(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>');
                    var dropdown = $(this).next();
                    var options = $(select).find('option');
                    var selected = $(this).find('option:selected');
                    dropdown.find('.current').html(selected.data('display-text') || selected.text());
                    options.each(function(j, o) {
                        var display = $(o).data('display-text') || '';
                        dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
                    });
                }
            });

            // Add magnifying glass icon with spacing
            $('.dropdown-select ul').before('<div class="dd-search"><i class="fa-solid fa-magnifying-glass fa-xl"></i><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>');
        }

        // Event listeners

        // Open/close
        $(document).on('click', '.dropdown-select', function(event) {
            if ($(event.target).hasClass('dd-searchbox')) {
                return;
            }
            $('.dropdown-select').not($(this)).removeClass('open');
            $(this).toggleClass('open');
            if ($(this).hasClass('open')) {
                $(this).find('.option').attr('tabindex', 0);
                $(this).find('.selected').focus();
            } else {
                $(this).find('.option').removeAttr('tabindex');
                $(this).focus();
            }
        });

        // Close when clicking outside
        $(document).on('click', function(event) {
            if ($(event.target).closest('.dropdown-select').length === 0) {
                $('.dropdown-select').removeClass('open');
                $('.dropdown-select .option').removeAttr('tabindex');
            }
            event.stopPropagation();
        });

        function filter() {
            var valThis = $('#txtSearchValue').val();
            $('.dropdown-select ul > li').each(function() {
                var text = $(this).text();
                (text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show(): $(this).hide();
            });
        };
        // Search

        // Option click
        $(document).on('click', '.dropdown-select .option', function(event) {
            $(this).closest('.list').find('.selected').removeClass('selected');
            $(this).addClass('selected');
            var text = $(this).data('display-text') || $(this).text();
            $(this).closest('.dropdown-select').find('.current').text(text);
            $(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
        });

        // Keyboard events
        $(document).on('keydown', '.dropdown-select', function(event) {
            var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
            // Space or Enter
            //if (event.keyCode == 32 || event.keyCode == 13) {
            if (event.keyCode == 13) {
                if ($(this).hasClass('open')) {
                    focused_option.trigger('click');
                } else {
                    $(this).trigger('click');
                }
                return false;
                // Down
            } else if (event.keyCode == 40) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    focused_option.next().focus();
                }
                return false;
                // Up
            } else if (event.keyCode == 38) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
                    focused_option.prev().focus();
                }
                return false;
                // Esc
            } else if (event.keyCode == 27) {
                if ($(this).hasClass('open')) {
                    $(this).trigger('click');
                }
                return false;
            }
        });

        $(document).ready(function() {
            create_custom_dropdowns();
            $(".header-border").show();
            $(".search-ticket").show();
            $(".display-ticket").hide();
            $(".footer").show();

            var flightId;
            var seatId;
            var airportFrom;
            var airportTo;

            $(".btn-search").on("click", function() {
                airportFrom = $("#airport_from").val();
                airportTo = $("#airport_to").val();
                departureDate = $("#departure_date").val();

                if (airportFrom === airportTo) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'The departure and destination airports cannot be the same!',
                    });
                    return;
                }

                if (!airportFrom || !airportTo || !departureDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please fill in all the fields!',
                    });
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "fetch_tickets.php",
                    data: {
                        airportFrom: airportFrom,
                        airportTo: airportTo,
                        departureDate: departureDate
                    },
                    success: function(response) {
                        $(".header-border").hide();
                        $(".search-ticket").hide();
                        $(".display-ticket").show();
                        $(".footer").hide();
                        $(".display-ticket").html(response);
                        $('html, body').scrollTop(0);
                    },
                    error: function(error) {
                        console.log("Error:", error);
                    }
                });
            });

            $(".ticket-box").on("click", function() {
                $(this).toggleClass("expanded");
            });

            $(".display-ticket").on("click", ".btn-book", function() {
                flightId = $(this).closest('.accordion-item').find('.accordion-button').data('flight-id');
                $.ajax({
                    type: "POST",
                    url: "choose_seat.php",
                    data: {
                        flightId: flightId
                    },
                    success: function(response) {
                        if (response.trim() === "AlreadyBooked") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "You've already purchased this ticket. Please check for another one!",
                            });
                        } else {
                            $(".header-border").hide();
                            $(".search-ticket").hide();
                            $(".display-ticket").hide();
                            $(".footer").hide();
                            $(".choose-seat").html(response);
                            $('html, body').scrollTop(0);
                        }
                    },
                    error: function(error) {
                        console.log("Error:", error);
                    }
                });
            });

            $(".choose-seat").on("click", ".seat.available", function() {
                clearSelection();
                seatId = $(this).attr("id");
                $(this).addClass("selected");
                $(".selected-seat").text("Seat: " + seatId);
            });

            function clearSelection() {
                $(".seat").removeClass("selected");
                $(".seat.available").addClass("available");
                $(".selected-seat").text("Seat: -");
            }

            $(".choose-seat").on("click", ".btn-seat", function() {
                if (!seatId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select a seat before confirming!',
                    });
                    return;
                }

                Swal.fire({
                        title: "Confirmation",
                        text: "Are you sure you want to choose seat " + seatId + "?",
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
                                url: "confirm_booking.php",
                                data: {
                                    airportFrom: airportFrom,
                                    airportTo: airportTo,
                                    flightId: flightId,
                                    seatId: seatId
                                },
                                success: function(response) {
                                    $(".header-border").hide();
                                    $(".search-ticket").hide();
                                    $(".display-ticket").hide();
                                    $(".choose-seat").hide();
                                    $(".footer").hide();
                                    $(".confirm-booking").html(response);
                                    $('html, body').scrollTop(0);
                                },
                                error: function(error) {
                                    console.log("Error:", error);
                                }
                            });
                        }
                    });
            });

            $(".confirm-booking").on("click", ".btn-confirm", function() {
                var userId = $(this).data('user-id');

                Swal.fire({
                        title: "Confirmation",
                        text: "Are you sure you want to book this flight?",
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
                                url: "insert_transaction.php",
                                data: {
                                    userId: userId,
                                    flightId: flightId,
                                    seatId: seatId
                                },
                                success: function(response) {
                                    response = JSON.parse(response); // Parse the JSON response
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Booking complete!",
                                            text: "You've successfully secured your flight ticket. Have a great journey!",
                                            icon: "success"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = '../history/index.php';
                                            }
                                        });
                                    } else if (response.error) {
                                        // Handle the error case
                                        console.log("Error:", response.error);
                                        Swal.fire({
                                            title: "Error!",
                                            text: response.error,
                                            icon: "error"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'index.php';
                                            }
                                        });
                                    }
                                },
                                error: function(error) {
                                    console.log("Error:", error);
                                }
                            });
                        }

                    });
            });
        });
    </script>

</body>

</html>