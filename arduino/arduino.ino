#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include "DHTesp.h"
#include <SPI.h> //biblioteka od protkoloku SPI
#include <Adafruit_GFX.h> //biblioteka graficzna
#include <WiFiClient.h>
#include <Wire.h>
#include <Adafruit_SSD1306.h>
#include <ArduinoJson.h>
#include <ESP8266WebServer.h>



WiFiClient wifiClient;
ESP8266WebServer server(80);

#define SSID "Sara" //nazwa (SSID) sieci wifi
#define SSID_PASSWORD "1276sara1276" //haslo do sieci

#define DHTpin D5//dht
#define przekaznik1_pin D6
#define przekaznik2_pin D7

// Declaration for an SSD1306 display connected to I2C (SDA, SCL pins)

#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 64 // OLED display height, in pixels
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);


DHTesp dht;
void setup() {
  Serial.begin(9600); //inicjalizacja portu szeregowego
  dht.setup(DHTpin, DHTesp::DHT11); //konfig. DHT11

  if(!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) { // Address 0x3D for 128x64
    Serial.println(F("SSD1306 allocation failed"));
    for(;;);
  }

  WiFi.begin(SSID, SSID_PASSWORD); //Wifi podlacznie
  while(WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.println("Proba polaczenia z WiFi");
  }
  Serial.print("IP adres:");
  Serial.println(WiFi.localIP());
  ///ustawinie pinow
pinMode(przekaznik1_pin, OUTPUT);
 pinMode(przekaznik2_pin, OUTPUT);
 ////json
  HTTPClient http;    //Declare object of class HTTPClient



  server.begin();
  #define server_ip = "192.168.1.23"
 #define  server_port = 80

// funkcja obsługi żądania HTTP
handle_http_request(payload)
// parsowanie danych JSON
json_data = sjson.decode(payload)
  
 // włączenie lub wyłączenie przekaźników
  if json_data.przekaznik1 == true then
    gpio.write(przekaznik1_pin, gpio.HIGH)
  else
    gpio.write(przekaznik1_pin, gpio.LOW)
  end
  
  if json_data.przekaznik2 == true then
    gpio.write(przekaznik2_pin, gpio.HIGH)
  else
    gpio.write(przekaznik2_pin, gpio.LOW)
  end
  
 ////odpowiedź serwera
  local response = "HTTP/1.1 200 OK\r\n"
  response = response .. "Content-Type: text/plain\r\n\r\n"
  response = response .. "Dane zostały pomyślnie odebrane przez NodeMCU."
  return response
end

///konfiguracja połączenia WiFi
wifi.setmode(wifi.STATION)
wifi.sta.config("nazwa_sieci", "haslo")

// konfiguracja pinów dla przekaźników
gpio.mode(przekaznik1_pin, gpio.OUTPUT)
gpio.mode(przekaznik2_pin, gpio.OUTPUT)

// inicjalizacja serwera HTTP
svr = net.createServer(net.TCP)
svr:listen(server_port, function(conn)
  conn:on("receive", function(conn, payload)
  // obsługa żądania HTTP
    local response = handle_http_request(payload)
    
   //wysłanie odpowiedzi do klienta
    conn:send(response, function()
      conn:close()
    end)
  end)
end)

}



void loop() 
{
   delay(1000);
   float temp = dht.getTemperature();
   float hum =  dht.getHumidity();
   Serial.print("Temp.:");
   Serial.println(temp,2);
   Serial.print("Wilg.:");
   Serial.println(hum,2);
  Serial.println(WiFi.localIP());

   display.clearDisplay();
   display.setTextColor(WHITE);
  display.setCursor(0, 10);
  display.println("Temperatura:");
   display.print(temp);
   display.setCursor(0, 40);
   display.println("Wilgotnosc:");
   display.print(hum);

   display.display();


   if(WiFi.status() == WL_CONNECTED)
   {
      HTTPClient http;
      String postData = "deviceId=ardu1&temp=" + String(temp,2) +"&hum=" + String(hum,2); //budowanie stringa dla POSTa - UWAGA musimy ustwaić deviceId takie jak w naszej bazie

      http.begin(wifiClient, "http://192.168.1.14/lab/sensordata.php"); //polaczenie do serwera WWW - NALEZY WPISAC PRAWIDLOWY ADRES IP oraz plik PHP, który dodaje dane do bazy!
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");  //naglowek
      int httpCode = http.POST(postData); //wyślij req do srv
      String resp = http.getString(); //odbierz odpowiedz od serwera

      Serial.println(httpCode);
      Serial.println(resp);
      http.end();
   }

   ////
   {
  server.handleClient();
}
   
}
