///wyświetlenie wyników z bazy dht///

<?php
//  bazą danych MySQL
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "pomiar";

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Nie udało się połączyć z bazą danych MySQL: " . $conn->connect_error);

// zamknij połączenie z bazą danych MySQL
$conn->close();
}

//  ostatnie odczyty temperatury i wilgotności z bazy danych MySQL
$sql = "SELECT * FROM dht11 ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// wyświetl wyniki
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "Data i godzina: " . $row["date"]. "<br>";
    echo "Temperatura: " . $row["temp"]. " &deg;C<br>";
    echo "Wilgotność: " . $row["hum"]. " %<br>";
  }
} else {
  echo "Brak pomiarów.";
}

// zamknij połączenie z bazą danych MySQL
$conn->close();
?>