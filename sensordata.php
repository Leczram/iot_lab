///odczytanie sensorów z post i umieszeczenie w bazie//

<?php
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "pomiar";

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Nie udało się połączyć z bazą danych MySQL: " . $conn->connect_error);
}

// pobierz wartości temperatury i wilgotności z Arduino
$temp = $_POST['temp'];
$hum = $_POST['hum'];

// wstaw wartości temperatury i wilgotności do bazy danych MySQL
$sql = "INSERT INTO dht11 (temp, hum) VALUES ('$temp', '$hum')";

if ($conn->query($sql) === TRUE) {
  echo "Pomiar został dodany do bazy danych.";
} else {
  echo "Wystąpił błąd podczas dodawania pomiaru do bazy danych: " . $conn->error;
}

// zamknij połączenie z bazą danych MySQL
$conn->close();
?>