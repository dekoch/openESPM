
// code to read a SHT3x sensor and send the values to an openESPM server
// https://github.com/dekoch/openESPM

// don't forget to connect reset to pin 16!

// tested with
// https://www.wemos.cc/product/d1-mini.html
// https://www.wemos.cc/product/d1-mini-pro.html
// https://www.wemos.cc/product/sht30-shield.html

#include <ArduinoJson.h>
#include <WEMOS_SHT3X.h>  //https://github.com/wemos/WEMOS_SHT3x_Arduino_Library
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


SHT3X sht30(0x45);
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
  espm.hello("HTLog-SHT3x", "1.0");
}

void loop()
{
  sht30.get();
  Serial.print("Temperature in Celsius : ");
  Serial.println(sht30.cTemp);
  Serial.print("Temperature in Fahrenheit : ");
  Serial.println(sht30.fTemp);
  Serial.print("Relative Humidity : ");
  Serial.println(sht30.humidity);

  String response = espm.ESPMRequest("ctemp=" + String(sht30.cTemp) +
                                     "&ftemp=" + String(sht30.fTemp) + 
                                     "&humidity=" + String(sht30.humidity));
  
  if(response != "")
  {
      // Parse JSON
      int size = response.length() + 1;
      char json[size];
      response.toCharArray(json, size);
      StaticJsonBuffer<200> jsonBuffer;
      JsonObject& json_parsed = jsonBuffer.parseObject(json);
      if(!json_parsed.success())
      {
        Serial.println("parseObject() failed");
        espm.DeepSleepSeconds(SLEEPTIME);
        return;
      }

      int intInterval = json_parsed["interval"];
      
      espm.DeepSleepSeconds(intInterval);
  }
  else
  {
    espm.DeepSleepSeconds(SLEEPTIME);
  }
}

