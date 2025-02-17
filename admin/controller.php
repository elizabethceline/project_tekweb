<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

function connectDB()
{
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $database = "project_tekweb";

    $conn = mysqli_connect($host, $user, $pwd, $database) or die("Error Connecting");
    return $conn;
}

function closeDB($conn)
{
    mysqli_close($conn);
}

function getFoodData()
{
    $conn = connectDB();
    $query = "SELECT * FROM food";
    return mysqli_query($conn, $query);
}

function getMenuDataById($id)
{
    $conn = connectDB();
    $query = "SELECT * FROM food WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    closeDB($conn);

    return $data;
}

function getAirportName($id)
{
    $conn = connectDB();
    $query = "SELECT name, city FROM airport WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    closeDB($conn);

    return $data['name'] . ", " . $data['city'];
}


function getFlightData()
{
    $conn = connectDB();
    $query = "SELECT * FROM flight";
    return mysqli_query($conn, $query);
}

function getBandara()
{
    $conn = connectDB();
    $query = "SELECT id, name, code FROM airport";
    return mysqli_query($conn, $query);
}

function getTotalPendapatanFlight()
{
    $conn = connectDB();
    $query = "SELECT SUM(f.price) AS total_pendapatan
    FROM flight_transaction ft
    JOIN flight f ON ft.id_flight = f.id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    closeDB($conn);

    return $data['total_pendapatan'];
}

function getTotalPendapatanMakanan()
{
    $conn = connectDB();
    $query = "SELECT SUM(total) AS total_pendapatan
    FROM food_transaction";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    closeDB($conn);

    return $data['total_pendapatan'];
}
