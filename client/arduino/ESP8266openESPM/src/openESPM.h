
// https://github.com/dekoch/openESPM

#ifndef __openESPM_H
#define __openESPM_H

#include "ESP8266WiFi.h"
#include "ESP8266HTTPClient.h"

class openESPM
{  
  public:
    void setupWiFi(char* ssid, char* password, int attempts);
    void setupESPM(char* host, char* path, char* id, char* key);
    void hello(char* application, char* appver);
    bool connectWiFi();
    String ESPMRequest(String request);
    void DeepSleepSeconds(int seconds);

  private:
    char* _WiFissid = "";  
    char* _WiFipassword = "";
    int _WiFiAttempts = 50;
        
    char* _ESPMhost = "";
    char* _ESPMpath = "";
    char* _ESPMid = "";
    char* _ESPMkey = "";
};

#endif
