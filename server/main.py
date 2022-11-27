# Prototype of backend script which communicates with
# 1) Our blackbox HW which reads data from Dexcom G6 sensor
# 2) Frontend app which can register/delete patients
#
# Communication is done via MQTT, all data are stored in SQL DB


import paho.mqtt.client as mqtt
import json
from mysql.connector import connect

def read_db_pw(pw_path="/tmp/pw")
	with open(pw_path, "r") as f:
		return f.read().strip()

def receive_message(client, userdata, message):
    # create new patient in db
    # based on data provided by front end
    def register_patient():
        rec_json = json.load(message.payload)
        sql_insert = "INSERT INTO patients (ID) VALUES (%s)"
        cursor.execute(sql_insert, (rec_json["pat"],))
        client.subscribe(f"CGM/{rec_json['pat']}")
    # patient is no longer monitored
    # unsubscribe MQTT and remove data from db
    def remove_patient():
        rec_json = json.load(message.payload)
        sql_delete_pat = "DELETE FROM patients WHERE ID = '{rec_json['pat']}'"
        sql_delete_meas = "DELETE FROM measurements WHERE PatientId = '{rec_json['pat']}'"
        cursor.execute(sql_delete_pat)
        cursor.execute(sql_delete_meas)
        db.commit()
        client.unsubscribe(f"CGM/{rec_json['pat']}")
    # send data based on request
    def send_data():
        rec_json = json.load(message.payload)
        sql_select = f"SELECT mmol_l FROM measurements WHERE PatientID='{rec_json['pat']}'"
        cursor.execute(sql_select)
        gluco_data = cursor.fetchall()
        payload = [m[0] for m in gluco_data]
        client.publish("frontend/glucol_data", payload=json.dump({"data": payload})
    # read data from MQTT message
    # write glucose value into db
    def read_data():
        sql_insert = "INSERT INTO measurements (PatientID, measure_time, mmol_l) VALUES (%s, %s, %s)"
        rec_json = json.load(message.payload)
        print(rec_json)
        vals = (pat[0], rec_json["timestamp"].strftime("%Y-%m-%d %H:%M:%S"), round(float(rec_json["glucose"]) / 18, 1))
        print(vals)
        cursor.execute(sql_insert, vals)
        db.commit()

    if "frontend/register" in message.topic:
        register_patient()
    elif "frontend/getData" in message.topic:
        send_data()
    elif "frontend/remove" in message.topic:
        remove_patient()
    elif "CGM" in message.topic:
        read_data()
    else:
        raise ArgumentException("Unknown message.")


db = connect(host="localhost",
             user="ehh_backend",
             password=read_db_pw,
             database="EHH")
cursor = db.cursor()

client = mqtt.Client("ehh_backend")
client.connect("127.0.0.1", 1883)

client.on_message = receive_message
client.subscribe("$SYS/#")

client.loop_forever()


