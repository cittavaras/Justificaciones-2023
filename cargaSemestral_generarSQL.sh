#!/bin/sh
cat $1 >> logcarga
if [ -z "$1" ]; then
echo "No file specified"
else
# Convierte el formato de texto origen del archivo a formato UNIX
# Esto permite no tomar en cuenta los saltos de líneas en el procesamiento del AWK
dos2unix $1

# Se agrega el cabecero para la inserción masiva de datos
cabecero='USE `justificaciones`;
TRUNCATE `datos_semestre`;
INSERT INTO `datos_semestre` (`RUT_ALU`, `COD_SECCION`, `NOM_ASIG`, `NOMBRE_ALUM`, `APEP_ALUM`, `APEM_ALUM`, `CORREO_ALUM`, `CONTRASENA_ALUM`, `RECOVERY_ALUM`, `CELULAR`, `COD_CARRERA`, `CARRERA`, `JORNADA`, `RUT_DOC`, `NOMBRE_DOC`, `APEP_DOC`, `CORREO_DOC`, `NOMBRE_COR`, `APEP_COR`, `APEM_COR`, `CORREO_COR`, `CONTRASENA_COR`, `RECOVERY_COR`) VALUES'

# Opción sin comillas aplicados automágicamente
#data=`awk -F, 'NR==1 { next } { print "(''"$1"'',''"$2"'',''"$3"'',''"$4"'',''"$5"'',''"$6"'',''"$7"'','\'\'','\'\'',''"$8"'',''"$9"'',''"$10"'',''"$11"'',''"$12"'',''"$13"'',''"$14"'',''"$16"'',''"$17"'',''"$18"'',''"$19"'',''"$20"'','\'\'','\'\''),"}' $1`

# Opción con comillas aplicados automágicamente
data=`awk -F, 'NR==1 { next } { print "(\x27"$1"\x27,\x27"$2"\x27,\x27"$3"\x27,\x27"$4"\x27,\x27"$5"\x27,\x27"$6"\x27,\x27"$7"\x27,NULL,NULL,\x27"$8"\x27,\x27"$9"\x27,\x27"$10"\x27,\x27"$11"\x27,\x27"$12"\x27,\x27"$13"\x27,\x27"$14"\x27,\x27"$16"\x27,\x27"$17"\x27,\x27"$18"\x27,\x27"$19"\x27,\x27"$20"\x27,NULL,NULL),"}' $1`

logger "${data}"
echo "${cabecero}
${data%?}" > carga.sql
fi

#CAMBIO DE PROCESO A PYTHON
#LEER CSV CON PYTHON
#ANALIZAR Y VALIDAR LOS DATOS POR COLUMNA
#CARGAR CADA FILA DEL CSV Y MYSQL, implica conectar con db mediante python
# NOMB'RE   'NOMBRE,APELLIDO'
