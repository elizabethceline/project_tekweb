<?php include '../assets/css/main.html' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDE AIRLINES</title>

    <!-- CSS -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/home/img-slider.css" rel="stylesheet">
    <link href="../assets/css/home/about.css" rel="stylesheet">
    <link href="../assets/css/home/holiday.css" rel="stylesheet">
    <link href="../assets/css/home/services.css" rel="stylesheet">

</head>

<body>
    <?php
    include "../navbar.php";
    ?>

    <section class="img-slider">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="2000">
                    <img src="../assets/img/thumbnail_bali.jpg" class="d-block w-100" alt="...">
                    <div class="text-overlay">
                        <h1 class="header1" style="font-family: 'Gothic'; font-size: 3.5rem" data-aos="fade-left" data-aos-duration="1500">WELCOME TO</h1>
                        <h1 class="header2" data-aos="fade-right" data-aos-duration="1500">CDE AIRLINES</h1>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="../assets/img/thumbnail_jpn.jpeg" class="d-block w-100" alt="...">
                    <div class="text-overlay">
                        <h1 class="header1" data-aos="fade-left" data-aos-duration="1500">High-Quality Services</h1>
                        <p class="text" data-aos="fade-right" data-aos-duration="1500">CDE Airlines is dedicated to providing exceptional in-flight services, with attentive and friendly cabin crews catering to the diverse needs of travelers.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="../assets/img/thumbnail_swiss.jpeg" class="d-block w-100" alt="...">
                    <div class="text-overlay">
                        <h1 class="header1" data-aos="fade-left" data-aos-duration="1500">World's Best Airlines</h1>
                        <p class="text" data-aos="fade-right" data-aos-duration="1500">With a focus on punctuality and efficiency, CDE Airlines goes above and beyond to make each flight a positive and memorable experience, solidifying its position as a preferred choice for those seeking quality air travel across the globe.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="about">
        <div class="header_aboutUs">
            <h1 class="header1" style="color: white;" data-aos="zoom-in" data-aos-duration="1500">About Us</h1>
        </div>

        <div class="box-container" data-aos="zoom-in-up" data-aos-duration="1500">
            <div class="box">
                <img src="../assets/img/thumbnail_bali.jpg" alt="" class="about-image">
            </div>
            <div class="box rightBox">
                <h1 class="text1">Who is us?</h1> <br>
                <h1 class="text2" style="text-align: justify; letter-spacing: 0.7px">CDE Airlines stands out as a premier choice for global travel, offering a seamless and delightful experience to passengers exploring destinations around the world. Renowned for its commitment to safety, reliability, and customer satisfaction, CDE Airlines has earned a stellar reputation in the aviation industry. The airline boasts a modern fleet equipped with state-of-the-art technology, ensuring a smooth and comfortable journey for passengers.</h1>
            </div>
        </div>

    </section>

    <section class="holiday" id="holiday">
        <div class="container justify-content-center text-align-center mb-3">
            <div class="header_holiday mt-4" data-aos="fade-right" data-aos-duration="1500">
                <h1 class="header1" style="color: white;">Holidays</h1>
                <h1 class="header3" style="color: white;">Book Your Perfect Vacation</h1>
            </div>

            <div class="container text-center cards gap-3">
                <div class="row g-3">
                    <div class="card col-lg-4 col-md-6 col-sm-6 mx-auto mb-3" data-aos="zoom-in-up" data-aos-duration="1500">
                        <img src="../assets/img/holiday_turki.jpg" alt="" class="portImg rounded mx-auto d-block">
                        <div class="textBox">
                            <h1>Türkiye</h1>
                            <?php
                            if (!isset($_SESSION["email"])) {
                                echo '<a href="../login/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            } else {
                                echo '<a href="../flights/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card col-lg-4 col-md-6 col-sm-6 mx-auto mb-3" data-aos="zoom-in-up" data-aos-duration="1500">
                        <img src="../assets/img/holiday_argentina.png" alt="" class="portImg rounded mx-auto d-block">
                        <div class="textBox">
                            <h1>Argentina</h1>
                            <?php
                            if (!isset($_SESSION["email"])) {
                                echo '<a href="../login/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            } else {
                                echo '<a href="../flights/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card col-lg-4 col-md-6 col-sm-6 mx-auto mb-3" data-aos="zoom-in-up" data-aos-duration="1500"data-aos="fade-right" data-aos-duration="1500">
                        <img src="../assets/img/holiday_china.jpg" alt="" class="portImg rounded mx-auto d-block">
                        <div class="textBox">
                            <h1>China</h1>
                            <?php
                            if (!isset($_SESSION["email"])) {
                                echo '<a href="../login/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            } else {
                                echo '<a href="../flights/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card col-lg-4 col-md-6 col-sm-6 mx-auto mb-3" data-aos="zoom-in-up" data-aos-duration="1500">
                        <img src="../assets/img/holiday_korea.jpg" alt="" class="portImg rounded mx-auto d-block">
                        <div class="textBox">
                            <h1>South Korea</h1>
                            <?php
                            if (!isset($_SESSION["email"])) {
                                echo '<a href="../login/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            } else {
                                echo '<a href="../flights/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card col-lg-4 col-md-6 col-sm-6 mx-auto mb-3" data-aos="zoom-in-up" data-aos-duration="1500">
                        <img src="../assets/img/holiday_sgp.jpg" alt="" class="portImg rounded mx-auto d-block">
                        <div class="textBox">
                            <h1>Singapore</h1>
                            <?php
                            if (!isset($_SESSION["email"])) {
                                echo '<a href="../login/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            } else {
                                echo '<a href="../flights/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card col-lg-4 col-md-6 col-sm-6 mx-auto mb-3" data-aos="zoom-in-up" data-aos-duration="1500">
                        <img src="../assets/img/holiday_aussie.jpg" alt="" class="portImg rounded mx-auto d-block">
                        <div class="textBox">
                            <h1>Australia</h1>
                            <?php
                            if (!isset($_SESSION["email"])) {
                                echo '<a href="../login/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            } else {
                                echo '<a href="../flights/index.php"><button type="button" class="btn btn-light">Book Now!</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container justify-content-center text-align-center mb-3">
            <div class="header_services mt-4">
                <h1 class="header1" style="color: white;" data-aos="zoom-in" data-aos-duration="1500">Our Services</h1>
            </div>

            <div class="container srv-box-container" data-aos="zoom-in-up" data-aos-duration="1500">
                <div class="zoom-effect">
                    <div class="srv-box">
                        <img src="../assets/img/food.jpg" alt="">
                        <div class="srv-box2">
                            <h1 class="header3" data-aos="zoom-in-right" data-aos-duration="1500">The World on Your Plate</h1>
                            <p class="text2" data-aos="zoom-in-right" data-aos-duration="1500">Tour the flavours of the world – and earn miles with every bite. With our huge range of restaurant partners around the world, there’s always another great meal to discover.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php
    include "../footer.php";
    ?>

    <script>
        AOS.init();
    </script>
</body>

</html>