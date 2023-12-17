<?php
$status = session_status();
if ($status == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="header-border" style="z-index: 1000;">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-custom bg-dark bg-opacity-50" style="background: #23314F; backdrop-filter: blur(0.5rem); z-index: 1000;">
        <div class="container-fluid p-4">
            <a class="navbar-brand" href="../home" style="color: white; text-decoration: none; font-family:'GothicBoldItalic'">
                <i class="fa-solid fa-plane-departure fa-xl" style="color: #ffffff;"></i>
                CDE AIRLINES
            </a>

            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>

                <ul class="navbar-nav mb-2 mb-lg-0">

                    <?php ob_start();
                    if (isset($_SESSION['email'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../home/index.php"><i class="fa-solid fa-house" style="color: #ffffff;"></i> Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../flights/index.php" role="page"><i class="fa-solid fa-plane" style="color: #ffffff;"></i> Flights</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../food/index.php" role="page"><i class="fa-solid fa-utensils" style="color: #ffffff;"></i> Meals</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../history/index.php" role="page"><i class="fa-solid fa-credit-card" style="color: #ffffff;"></i> History</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../home/feedback.php" role="page"><i class="fa-solid fa-message" style="color: #ffffff;"></i> Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../home/profile.php"><i class="fa-solid fa-user" style="color: #ffffff;"></i> Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../login/logout.php" role="page"><i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i> Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-house" style="color: #ffffff;"></i> Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../home/feedback.php" role="page"><i class="fa-solid fa-message" style="color: #ffffff;"></i> Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../login/index.php" role="page"><i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i> Login</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- <script>
    let prevScrollPos = window.pageYOffset;
    let navbar = document.getElementById("navbar");

    window.onscroll = function () {
        let currentScrollPos = window.pageYOffset;

        if (prevScrollPos < currentScrollPos) {
            // Scrolling down
            document.querySelector(".header-border").style.top = "-80px";
            navbar.style.top = "-80px";
        } else {
            // Scrolling up
            document.querySelector(".header-border").style.top = "0";
            navbar.style.top = "0";
        }

        prevScrollPos = currentScrollPos;
    }
</script> -->

<!-- <script>
        let prevScrollPos = window.pageYOffset;
        let navbar = document.getElementById("navbar");

        window.onscroll = function () {
            let currentScrollPos = window.pageYOffset;

            if (currentScrollPos === 0) {
                navbar.classList.remove("bg-opacity-100");
                // document.querySelector(".header-border").style.top = "0";
                // navbar.style.top = "0";
            } else {
                navbar.classList.add("bg-opacity-100");
                // document.querySelector(".header-border").style.top = "-80px";
                // navbar.style.top = "-80px";
            }

            prevScrollPos = currentScrollPos;
        }
    </script> -->