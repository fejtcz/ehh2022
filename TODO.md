# TODOD:

## Backend
- Napojení na stávající DEXCON API (např: https://github.com/gagebenne/pydexcom )
- Možnost komunikace skrze MQTT pro blackbox
- ukládání dat do DB
- definovat spolupráci s frontendem

## Frontend
- párování pacient vs. jednotka (remote api nebo "blackbox")
- párování blackbox <-> Transmitter a náplast (skrze mqtt)
- vizualizace průběhů, možnost více paciantů na dashboardu
- nastavení treholdů pro alarm
- alarm v případě nedostupnosti aktuálních dat

## ESP32
- otestovat a odladit komunikaci se senzorem
- rozchodit mqtt (odesílání dat + konfigurace)
- definovat strukturu adresy mqtt (něco ve stylu /CGM/MAC_ADRESA/xxx)
- definovat json s daty
