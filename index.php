///wyglad strony///

<!DOCTYPE html>
<html>
<head>
	<title>strona z przyciskiem i danymi z bazy danych</title>
</head>
<body>

	<h1>Zarządzanie przekaźnikami</h1>
<form method="post" action="save.php">
		<label for="przekaznik1">Przekaźnik 1:</label>
		<button type="submit" name="przekaznik1" value="1">Włącz</button>
		<button type="submit" name="przekaznik1" value="0">Wyłącz</button>

		<br>

		<label for="przekaznik2">Przekaźnik 2:</label>
		<button type="submit" name="przekaznik2" value="1">Włącz</button>
		<button type="submit" name="przekaznik2" value="0">Wyłącz</button>
		</form>
		

	
	
	<p><h2>Ostatnie odczyty z czujnika:</h2></p>
<?php include('danedht.php') ?>

</body>
</html>


