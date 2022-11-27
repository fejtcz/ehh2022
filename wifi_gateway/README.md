## ESP32 DEXCOM Reader
Based on the source code from : https://github.com/TheEpicBigBoss/Dexcom-ESP32-Reader

''' 
Dexcom-ESP32-Reader

This project is very experimental and not intended for use in therapy!

ESP32 that can read Dexcom G5/G6 (glucose, raw, calibration, battery, ...) data.

Developed in the context of my bachelor thesis at the Technical University (TU) of Darmstadt under the supervision of the Telecooperation Lab and Jens Heuschkel.
'''

Actual state: buggy demo

## Pros:
- It can works together with Decxom app ro without it
- The device can works with multiple transmitters
- Used standard interface (MQTT) - simple integration
- It is cheap (aprox. 50€)

## TODO:
- Update all to latest version
- Rewrite from arduino ino to standard code
- Change fixed configs to variable
- Add MQTT function for a remote configuration 
- Add support for multiple glucometers
- Check if sensors starts measuring without the original app
- Read historical data from the transmitter
- Add divider to glucose calculation (real value is glucose/18)