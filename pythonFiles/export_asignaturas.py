from operator import itemgetter

import pandas as pd
import numpy as np


file = "/data07_01.xlsx"
data = pd.read_excel( file , sheet_name='SABANA 2022-1 07.01.2022' , skiprows= [1,2])

seccion = data.loc[: ,"Seccion"]
codigo= data.loc[:, "C.Asig." ]
lunes = data.loc[: , "Lun."]
martes = data.loc[:, "Martes"]
miercoles = data.loc[:, "Miér."]
jueves  = data.loc[: , "Jueves"]
viernes = data.loc[:, "Viernes"]
sabado = data.loc[:,"Sábado"]
domingo = data.loc[:, "Domingo"]

length = np.size(codigo)
asignaturas = []

class Asignatura():
    seccion = str
    codigo = str
    lunes = str
    martes = str
    miercoles = str
    jueves =  str
    viernes =  str
    sabado = str
    domingo = str

    def __init__(self,seccion,codigo,lunes,martes,miercoles,jueves,viernes,sabado,domingo):
        self.seccion = seccion
        self.codigo = codigo 
        self.lunes = lunes
        self.martes = martes
        self.miercoles = miercoles
        self.jueves = jueves
        self.viernes = viernes
        self.sabado = sabado
        self.domingo = domingo

    def __repr__(self):
        return str(self.__dict__)

     



for i in range (length): 
    if (i not in asignaturas):
        element=(Asignatura(seccion.iloc[i],
                            codigo.iloc[i],
                            lunes.iloc[i],
                            martes.iloc[i],
                            miercoles.iloc[i],
                            jueves.iloc[i],
                            viernes.iloc[i],
                            sabado.iloc[i],
                            domingo.iloc[i])       
                            )
        asignaturas.append(element)


# dado la section y el codigo, se puede determinar el día en que se tiene clases
# v2 se puede mejorar el rendimiento sólo buscando por la sección
def showDay(section):
    day = []
    orderDays = ["lunes","martes","miercoles","jueves", "viernes", "sabado" , "domingo"]
    for Asignatura in asignaturas:
        if (Asignatura.seccion == section):
            
            if Asignatura.lunes == 'X':
                if ('lunes' not in day):
                    day.append('lunes')     
            
            elif Asignatura.martes == 'X':
                if ('martes' not in day):
                    day.append('martes')     
            
            elif Asignatura.miercoles == 'X':
                if ( 'miercoles' not in day):
                    day.append('miercoles')     
            
            elif Asignatura.jueves == 'X':
                if ( 'jueves' not in day):
                    day.append('jueves')     
            
            elif Asignatura.viernes == 'X':
                if ( 'viernes' not in day):
                    day.append('viernes')     
            
            elif Asignatura.sabado == 'X':
                if ( 'sabado' not in day):
                    day.append('sabado')     
            
            elif Asignatura.domingo == 'X':
                if ( 'doming' not in day):
                    day.append('domingo')  
                       
    day = pd.Categorical(day, categories=orderDays)        
    return day
        



sections = []
total= 0
for Asignatura in asignaturas: 
    sections.append(Asignatura.seccion)
    total+=1

sections = list(set(sections))
# print(np.size(sections))  


finalData = []   
for section in sections:
    days = showDay(section)
    if (len(days)==0):
        days = "no_data"
    else:    
        sep =  ','
        days = sep.join(days)
    finalData.append([section , days])
    

try:
    dataExcel = pd.DataFrame(finalData, columns=['seccion', 'dias']) 
    fileName = 'data_test.xlsx'                   
    dataExcel.to_excel(fileName , index=False , na_rep = "no_data")    
    print('generado de manera correcta')
except Error:
    print('No se ha podido general el archivo' )

