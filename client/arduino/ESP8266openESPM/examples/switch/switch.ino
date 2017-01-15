
// control a digital output with your openESPM server
// https://github.com/dekoch/openESPM

#include <ESP8266WiFi.h>
#include <ArduinoJson.h>
#include <openESPM.h>

// WiFi settings
char* ssid      = "";  
char* password  = "";
// openESPM server settings
char* host      = "myhost.com";     // your domain
char* path      = "/openespm/";     // your folder
char* ID        = "1234567890123";  // device id
char* key       = "1234567890123";  // private key
const int pin   = 2;                // output pin

#define SLEEPTIME 60  //default sleep time in seconds
#define ATTEMPTS 50


openESPM espm;


void setup()
{
  pinMode(pin, OUTPUT); 
  pinMode(pin, HIGH);
  Serial.begin(115200);
  delay(10);
  Serial.println("");
  Serial.println("");
  
  espm.setupWiFi(ssid, password, ATTEMPTS);
  espm.setupESPM(host, path, ID, key);
  espm.hello("switch", "1.0");
}


void loop()
{
  String response = espm.ESPMRequest("");

  if(response != "")
  {
    // Parse JSON
    int size = response.length() + 1;
    char json[size];
    response.toCharArray(json, size);
    StaticJsonBuffer<200> jsonBuffer;
    JsonObject& json_parsed = jsonBuffer.parseObject(json);
    if (!json_parsed.success())
    {
      Serial.println("parseObject() failed");
      SleepSeconds(SLEEPTIME);  
    }
    
    // Make the decision to turn off or on the LED
    if (strcmp(json_parsed["switch"], "on") == 0)
    {
      digitalWrite(pin, LOW);
      Serial.println("LED ON");
    }
    else
    {
      digitalWrite(pin, HIGH);
      Serial.println("led off");
    }
  }
  else
  {
    SleepSeconds(SLEEPTIME);
  }
}

void SleepSeconds(int seconds)
{
  Serial.print("sleep ");
  Serial.print(seconds);
  Serial.println(" seconds");
  
  delay(seconds * 1000);
}

