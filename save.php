////akcja po nacisniecu przycisku, sprawdzenie stanu przycisku i sprawdzenie stanu drugiego przełacznika w bazie danych. na koniec wylowanie skryptu python espsend.py, który tworzy json i wysyła do nodemcu///

<?php

// Dane do połączenia z bazą danych
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "pomiar";

// Utworzenie połączenia z bazą danych
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['przekaznik1'])) {
    $przekaznik1 = $_POST['przekaznik1'];
    
    // Pobranie wartości przekaźnika2 z poprzedniego rekordu
    $sql = "SELECT przekaznik2 FROM przekaznik ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $przekaznik2 = $row['przekaznik2'];
    } else {
        $przekaznik2 = null;
    }
    
    // Wysłanie wartości do bazy danych
    $sql = "INSERT INTO przekaznik (przekaznik1, przekaznik2) VALUES ('$przekaznik1', '$przekaznik2')";
    $result = mysqli_query($conn, $sql);
    
    if ($result === TRUE) {
        echo "Wartość przekaźnika1 została pomyślnie zapisana w bazie danych";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['przekaznik2'])) {
    $przekaznik2 = $_POST['przekaznik2'];
    
    // Pobranie wartości przekaźnika1 z poprzedniego rekordu
    $sql = "SELECT przekaznik1 FROM przekaznik ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $przekaznik1 = $row['przekaznik1'];
    } else {
        $przekaznik1 = null;
    }
    
    // Wysłanie wartości do bazy danych
    $sql = "INSERT INTO przekaznik (przekaznik1, przekaznik2) VALUES ('$przekaznik1', '$przekaznik2')";
    $result = mysqli_query($conn, $sql);
    
    if ($result === TRUE) {
        echo "Wartość przekaźnika2 została pomyślnie zapisana w bazie danych";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }

$command = "python espsend.py argument1";
exec($command, $output, $return_response.text);
// $output zawiera wynik wykonania skryptu, a $return_var zawiera kod zakończenia procesu

}


?>
