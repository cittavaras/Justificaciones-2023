
import mysql.connector as connection
import pandas as pd
import mysql.connector as sql

import pandas as pd

db_connection = sql.connect(host='206.189.212.81',port=3306, database='justificaciones', 
user='root', password='c1tt')

df = pd.read_sql('SELECT * FROM justificaciones.justifications', con=db_connection)
df.reset_index(level=0, inplace=True)

xx = df.to_json(orient='records')
with open('xx.json', 'w') as f:
    f.write(xx)
