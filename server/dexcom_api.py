# this script is not used anymore
# purpose of this deamon was to be able to read data from Dexcom API
# but we can read also data from patients with their own sensor with help of out HW

from pydexcom import Dexcom
from mysql.connector import connect

def read_db_pw(pw_path="/tmp/pw")
	with open(pw_path, "r") as f:
		return f.read().strip()

db = connect(host="localhost",
             user="ehh_backend",
             password=read_db_pw(),
             database="EHH")

cursor = db.cursor()

sql_insert = "INSERT INTO measurements (PatientID, measure_time, mmol_l) VALUES (%s, %s, %s)"

cursor.execute("SELECT * FROM patients")
patients = cursor.fetchall()

for pat in patients:
    dexcom = Dexcom(pat[1], pat[2], ous=True)
    curr_data = dexcom.get_current_glucose_reading()
    vals = (pat[0], curr_data.time.strftime("%Y-%m-%d %H:%M:%S"), curr_data.mmol_l)
    
    print(vals)
    cursor.execute(sql_insert, vals)
    del dexcom

db.commit()

