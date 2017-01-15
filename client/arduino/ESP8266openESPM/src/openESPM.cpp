
// https://github.com/dekoch/openESPM

#include "openESPM.h"

    
void openESPM::setupWiFi(char* ssid, char* password, int attempts)
{
  _WiFissid = ssid;
  _WiFipassword = password;
  _WiFiAttempts = attempts;
}


void openESPM::setupESPM(char* host, char* path, char* id, char* key)
{
  _ESPMhost = host;
  _ESPMpath = path;
  _ESPMid = id;
  _ESPMkey = key;
}


void openESPM::hello(char* application, char* appver)
{
  String strKey = _ESPMkey;
  byte byLength = strKey.length();
  if(byLength > 6)
  {
    // mask the private key
    strKey.remove(0, byLength - 6);
    for (int i=0; i <= byLength - 6; i++)
    {
      strKey = "*" + strKey;
    }
  }
  
  Serial.println("                         _____ ____  ____  __  __");
  Serial.println("   ___  _ __   ___ _ __ | ____/ ___||  _ \\|  \\/  |");
  Serial.println("  / _ \\| '_ \\ / _ \\ '_ \\|  _| \\___ \\| |_) | |\\/| |");
  Serial.println(" | (_) | |_) |  __/ | | | |___ ___) |  __/| |  | |");
  Serial.println("  \\___/| .__/ \\___|_| |_|_____|____/|_|   |_|  |_|");
  Serial.println("       |_| client v1.0");
  Serial.println("");
  Serial.println("        https://github.com/dekoch/openESPM");
  Serial.println("");
  if(application != "")
  {
    Serial.println("  Application: " + String(application) + " v" + String(appver));
  }
  Serial.println("  Device ID: " + String(_ESPMid) + "  Private Key: " + strKey);
  Serial.println("  Host: " + String(_ESPMhost) + "  Path: " + String(_ESPMpath));
  Serial.println("");
  Serial.println("");
}


bool openESPM::connectWiFi()
{
  if(WiFi.status() != WL_CONNECTED)
  {
    Serial.print("connecting to WiFi: ");
    Serial.println(_WiFissid);
  
    WiFi.begin(_WiFissid, _WiFipassword);
  
    int intAttempts = 0;
    while((WiFi.status() != WL_CONNECTED) && (intAttempts <= _WiFiAttempts))
    {
      delay(200);
      Serial.print(".");
      
      intAttempts++;
    }

    if(intAttempts >= _WiFiAttempts)
    {
      Serial.println(" failed");
      
      return false;
    }

    Serial.println(" connected");  

    return true;
  }

  Serial.print("WiFi connected: ");
  Serial.println(_WiFissid);

  return true;
}


String openESPM::ESPMRequest(String request)
{
  String response = "";
  
  if(connectWiFi() == true)
  {
    HTTPClient http;
    
    Serial.print("connecting to host: ");
    Serial.println(_ESPMhost);        

    // configure target server and url
    http.begin("http://" + String(_ESPMhost) + String(_ESPMpath) +
               "request.php?id=" + String(_ESPMid) + "&key=" + String(_ESPMkey) +
               "&" + request);

    // start connection and send HTTP header
    int httpCode = http.GET();
    
    if(httpCode)
    {
      // HTTP header has been send and Server response header has been handled
      if(httpCode >= 200 && httpCode < 300 )
      {
        response = http.getString();
        response.trim();

        Serial.println("response: " + response);
      }
      else
      {
        Serial.print("HTTP error: ");
        Serial.println(httpCode);

        switch(httpCode)
        {
          case 470:
            Serial.println("ID not set");
            break;

          case 472:
            Serial.println("Device configuration not present");
            break;

          case 474:
            Serial.println("Wrong private key");
            break;

          case 480:
            Serial.println("App not present");
            break;
        }   
      }
    }
    else
    {
      Serial.println("connection failed");
    }
  }

  return response;
}


void openESPM::DeepSleepSeconds(int seconds)
{
  Serial.print("deep sleep ");
  Serial.print(seconds);
  Serial.println(" seconds");
  
  ESP.deepSleep(seconds * 1000000, WAKE_RF_DEFAULT);
  delay(100);
}

