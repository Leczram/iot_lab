##połączenie z bazą, użycie biblkioteki python connector, json i request####

import mysql.connector
import json
import requests

# nawiązanie połączenia z bazą danych
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="pomiar"
)

# wykonanie zapytania pobierającego ostatni rekord z tabeli "przekaznik"
mycursor = mydb.cursor()
mycursor.execute("SELECT przekaznik1, przekaznik2 FROM przekaznik ORDER BY id DESC LIMIT 1")

# pobranie wyniku zapytania
result = mycursor.fetchone()

# zapisanie wartości z wyniku zapytania do zmiennych
przekaznik1 = result[0]
przekaznik2 = result[1]

# utworzenie słownika z wartościami
dane = {
    "przekaznik1": przekaznik1,
    "przekaznik2": przekaznik2
}

# przekształcenie słownika do formatu JSON
json_dane = json.dumps(dane)

# wysłanie danych do serwera NodeMCU
url = "http://192.168.1.23:80/"
response = requests.post(url, data=json_dane)

# wyświetlenie odpowiedzi serwera
print(response.text)

# zamknięcie połączenia z bazą danych
mycursor.close()
mydb.close()
