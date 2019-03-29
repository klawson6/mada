import mysql.connector
import sys
import time
email = sys.argv[1]


mydb = mysql.connector.connect(
  host="devweb2018.cis.strath.ac.uk",
  user="cs317mada",
  passwd="lu3Eengaewis",
  database="cs317mada"
)

mycursor = mydb.cursor()

locations = []
locations.append([55.860101,-4.251861])
locations.append([55.860039,-4.251300])
locations.append([55.859987,-4.250657])
locations.append([55.859915,-4.249917])
locations.append([55.859873,-4.249408])
locations.append([55.859828,-4.248885])
locations.append([55.859798,-4.248429])
locations.append([55.859744,-4.247920])
locations.append([55.859686,-4.247376])
locations.append([55.859638,-4.246834])
locations.append([55.859596,-4.246309])
locations.append([55.859544,-4.245629])
locations.append([55.859477,-4.245221])
locations.append([55.859376,-4.244704])
locations.append([55.859376,-4.244233])
locations.append([55.859355,-4.243884])
locations.append([55.859647,-4.243828])
locations.append([55.859954,-4.243769])
locations.append([55.860299,-4.243722])
locations.append([55.860750,-4.243654])
locations.append([55.860713,-4.243042])
locations.append([55.861012,-4.243097])
locations.append([55.861310,-4.243153])
locations.append([55.861767,-4.243249])
locations.append([55.862025,-4.243292])
locations.append([55.862291,-4.243742])
locations.append([55.862357,-4.244246])
locations.append([55.862439,-4.244927])
locations.append([55.862771,-4.245053])
locations.append([55.862981,-4.244670])
locations.append([55.863005,-4.243954])
locations.append([55.863050,-4.242951])
locations.append([55.863059,-4.242169])
locations.append([55.863073,-4.241440])
locations.append([55.863091,-4.240469])
locations.append([55.863603,-4.239147])
locations.append([55.863725,-4.239413])
locations.append([55.863779,-4.239864])
locations.append([55.863865,-4.240418])
locations.append([55.863937,-4.240970])
locations.append([55.864013,-4.241523])
locations.append([55.864139,-4.242306])
locations.append([55.864275,-4.242974])
locations.append([55.864477,-4.243424])
locations.append([55.864729,-4.243816])
locations.append([55.864900,-4.243580])
locations.append([55.864915,-4.242931])
for location in locations: 
    sql = "UPDATE CurrentRides SET CurrentLat = " + str(location[0]) + ", CurrentLng = " + str(location[1]) + " WHERE Email = '" + email + "';"
    print(sql)
    mycursor.execute(sql)
    mydb.commit()
    time.sleep(0.5)

