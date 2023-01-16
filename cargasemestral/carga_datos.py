#recordatorio, se necesita ampliar el tamaño con el cual el php puede recibir archivos ya que al ser un EXCEL con bastantes
#columnas el archivo pesa al rededor de 4-6MB por lo que es recomendable cambiarlo a 8MB

import mysql.connector
import pandas as pd
import openpyxl
conexion=mysql.connector.connect(
    host="206.189.212.81", #Host,
    port="3306",
    user="root", #Usuario
    passwd="c1tt", #Contraseña
    database="justificaciones") #Base de datos a utilizar
cursor = conexion.cursor()
i=0
conexion.commit
df = pd.read_excel('/root/Desarrollo/Justificaciones-2023/cargasemestral/archivo-excel.xlsx') #Ubicación del archivo excel, lugar por defecto, se debe completar la dirección completa
df.fillna('', inplace=True) #Se revisan los datos nulos
df=df.drop(columns=['Apellido_Materno_Docente']) #ELiminamos el Apellido_Materno_Docente ya que en la nuestra base de datos no lo incluye
lista = df.values.tolist() #Se convierte los datos en una lista
listado_tupla = tuple(lista) #Se guarda todos los datos en un tuple
cantidad = len(listado_tupla) #Se guarda la cantidad de datos
cursor.execute('TRUNCATE datos_semestre;') #Se eliminan los datos de "datos_semestre"
conexion.commit #Y Junto con un commit se completa la sentencia
if int(cantidad<=0):
    print("Se ha producido un error con el archivo")
    conexion.close()

else:
    while i < len(listado_tupla): #Se realiza un ciclo while recorriendo los datos de la tupla para la inserción de los datos
        cursor.execute('''
        INSERT INTO datos_semestre(`RUT_ALU`, `COD_SECCION`, `NOM_ASIG`, `NOMBRE_ALUM`, `APEP_ALUM`, `APEM_ALUM`, `CORREO_ALUM`, `CELULAR`, `COD_CARRERA`,
        `CARRERA`, `JORNADA`, `RUT_DOC`, `NOMBRE_DOC`, `APEP_DOC`, `CORREO_DOC`, `NOMBRE_COR`, `APEP_COR`, `APEM_COR`, `CORREO_COR`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);''',listado_tupla[i]) #Se reemplazan por los datos de la tupla
        conexion.commit() #Se completa la sentencia SQL
        i=i+1 #Y junton con un contador para que se pueda detener

conexion.close() #Por último se cierra la conexión
#Recordatorio, instalar las siguientes librerias: mysql-connector-python,pandas,openpyxlcargasemestral/validacion.py
