USE justificaciones;
INSERT INTO users (email,password,name)
SELECT distinct CORREO_ALUM,RUT_ALU,NOMBRE_ALUM 
FROM datos_semestre
WHERE NOT EXISTS(SELECT * FROM users WHERE (datos_semestre.CORREO_ALUM=users.email));
