
// control an output pin with your openESPM server
// https://github.com/dekoch/openESPM

// client inspired by http://blog.nyl.io/esp8266-led-arduino/

// don't forget to connect reset input to pin 16!

// tested with
// https://www.wemos.cc/product/d1-mini.html
// https://www.wemos.cc/product/d1-mini-pro.html

#include <ESP8266WiFi.h>
#include <ArduinoJson.h>


const char* ssid     = "My SSID";  
const char* password = "";

const char* host     = "myhost.com";        // your domain
String path          = "/openespm/";        // your folder
String ID            = "1234567890123";     // device id
const int pin        = 2;                   // LED output pin (remember this pin is "inverted")

#define SLEEPTIME 60  //default sleep time in seconds
#define ATTEMPTS 30



void setup() {  
  pinMode(pin, OUTPUT); 
  pinMode(pin, HIGH);
  Serial.begin(115200);

  delay(10);
  Serial.println("");
  Serial.println("");
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  int intAttempts = 0;
  while ((WiFi.status() != WL_CONNECTED) && (intAttempts <= ATTEMPTS))
  {
    delay(500);
    Serial.print(".");
    
    intAttempts++;
  }

  if (intAttempts >= ATTEMPTS)
  {
    SleepMinutes(SLEEPTIME);
  }

  Serial.println("WiFi connected");  
  Serial.println("IP address: " + WiFi.localIP());
}

void loop() {  
  Serial.print("connecting to ");
  Serial.println(host);
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort))
  {
    Serial.println("connection failed");
    SleepMinutes(SLEEPTIME);
    return;
  } 

  client.print(String("GET ") + path + "request.php?" +
                                        "id=" + ID + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: keep-alive\r\n\r\n");

  delay(500); // wait for server to respond

  // read response
  String section="header";
  while(client.available())
  {
    String line = client.readStringUntil('\r');
    // Serial.print(line);
    // we’ll parse the HTML body here
    if (section=="header")
    { 
      // headers..
      Serial.print(".");
      if (line=="\n")
      {
        // skips the empty space at the beginning 
        section="json";
      }
    }
    else if (section=="json")
    {
      // print the good stuff
      section="ignore";
      String result = line.substring(1);

      // Parse JSON
      int size = result.length() + 1;
      char json[size];
      result.toCharArray(json, size);
      StaticJsonBuffer<200> jsonBuffer;
      JsonObject& json_parsed = jsonBuffer.parseObject(json);
      if (!json_parsed.success())
      {
        Serial.println("parseObject() failed");
        SleepMinutes(SLEEPTIME);
        return;
      }

      // Make the decision to turn off or on the LED
      if (strcmp(json_parsed["switch"], "on") == 0)
      {
        digitalWrite(pin, HIGH); 
        Serial.println("LED ON");
      }
      else
      {
        digitalWrite(pin, LOW);
        Serial.println("led off");
      }
    }
  }
  Serial.print("closing connection. ");
}


void SleepMinutes(int seconds)
{
  Serial.print("sleep ");
  Serial.print(seconds);
  Serial.println(" seconds");
  
  ESP.deepSleep(seconds * 1000000, WAKE_RF_DEFAULT);
  delay(100);
}
