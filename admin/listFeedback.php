<?php
session_start();
if (isset($_SESSION['username'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
        include('../user/assets/css/main.html');
        ?>

        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


        <!-- Sweet Alert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>List Feedback</title>

        <style>
            body {
                background-color: #f7f1f0;
            }

            .container {
                background-color: white;
            }

            .form-select {
                width: 50%;
            }
        </style>

        <script>
            $(document).ready(function() {
                $("#chooseButton").on("click", function() {
                    $topik = $("#topikList").val();
                    location.href = 'listFeedback.php?topik=' + $topik;
                })
            });
        </script>

        <?php

        ?>

    </head>

    <body>
        <?php include "navbar.php"; ?>
        <div class="container my-5 p-5">
            <div class="table-responsive">
                <h1>Data Feedback</h1>
                <div class=""><label class="mb-2">Topik</label>
                    <select name="" id="topikList" class="form-select">
                        <option value="" selected>Choose</option>
                        <option value="Kenyamanan Pesawat">Kenyamanan Pesawat</option>
                        <option value="Rasa makanan">Rasa makanan</option>
                        <option value="Service">Service</option>
                    </select>
                </div>
                <div class="my-3"><button class="btn btn-dark" id="chooseButton">Choose</button></div>
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Topik</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['topik']) && $_GET['topik'] != "All") {
                            include_once('../conn.php');
                        ?>
                            <script>
                                $(document).ready(function() {
                                    $("#topikList").val("<?php echo $_GET['topik'] ?>").change();
                                    $("option[value='']").remove();
                                    $("#topikList").append(new Option("All", "All"))
                                })
                            </script>
                        <?php
                            $stmt = $conn->prepare('SELECT * FROM feedback WHERE feedback != "" AND topik = "' . $_GET["topik"] . '" ORDER BY topik ASC');

                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                <td>" . $row['topik'] . "</td>
                                <td>" . $row['feedback'] . "</td>
                                </tr>";
                                }
                            }
                        } else {
                            include_once('../conn.php');
                            $stmt = $conn->prepare('SELECT * FROM feedback WHERE FEEDBACK != "" ORDER BY topik ASC');

                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                <td>" . $row['topik'] . "</td>
                                <td>" . $row['feedback'] . "</td>
                                </tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
} else {
    header("Location: index.php");
}
    ?>

    <script>
        new DataTable("#example");
    </script>
    </body>

    </html>