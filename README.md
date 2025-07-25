# Prueba Técnica – Soporte Nivel 2 QA  
Cristian Parrado

## Descripción General

Aplicación web desarrollada en Laravel para validar la integración de servicios SOAP y REST, simulando un entorno real de transacciones y consumo de APIs externas como el clima.  

El sistema permite:

- Realizar pagos simulados con PSE (SOAP)
- Intentar pagos con Bancolombia (REST)
- Consultar el clima de una ciudad (REST pública)

## Tecnologías utilizadas

- PHP 8.x
- Laravel 10.x
- MySQL
- Postman
- Servicios SOAP & REST

## Instalación del proyecto

1. Clonar este repositorio o descomprimir la carpeta del proyecto.
2. Instalar dependencias de Laravel:

   composer install

3. Crear el archivo `.env` y configurar la base de datos:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=realtech_db
    DB_USERNAME=root
    DB_PASSWORD= 

4. Generar la clave de aplicación:

   php artisan key:generate

5. Ejecutar las migraciones:

   php artisan migrate

6. Iniciar el servidor local:

   php artisan serve

7. Abrir en el navegador:  
   http://127.0.0.1:8000

## Funcionalidad del sistema

1. Simulación de Compra

   - Formulario con campos: nombre, email, identificación, producto, monto.
   - Opción para pagar mediante:
     - ✅ PSE (SOAP): integración exitosa. Devuelve ID de transacción y URL de redirección al procesador.
     - ❌ Bancolombia (REST): integración implementada, pero el servicio devuelve error 500 al intentar guardar la transacción. Se validó la clave correctamente.

2. Consulta del Clima (API pública) ✅

   - Formulario con campo de ciudad.
   - Consume la API pública Open-Meteo.
   - Muestra:
     - Temperatura
     - Velocidad y dirección del viento
     - Código del clima

## Pruebas con Postman

Se realizaron pruebas de los tres servicios con Postman.

| Servicio         | Estado     | Detalle                                                                      |
|------------------|------------|------------------------------------------------------------------------------|
| Clima (REST)     | Correcto   | Responde correctamente con datos actuales.                                  |
| Bancolombia REST | Error      | 500 Internal Server Error al guardar la transacción (clave y payload correctos). |
| PSE (SOAP)       | Parcial    | Funciona correctamente en Laravel, pero en Postman devuelve 204 No Content (estructura XML posiblemente incorrecta).

Se incluye archivo .json con la colección exportada de Postman.

## Observaciones QA

- Clave REST: se genera como md5(claveOriginal + codEmpresa + referencia + valorTotal). Se validó con múltiples intentos hasta lograr consistencia.
- SOAP en Laravel: se utiliza SoapClient, el cual arma y envía correctamente el XML requerido, obteniendo respuestas exitosas.
- SOAP en Postman: al intentar enviar el mismo XML manualmente, el servidor responde 204, lo cual indica que la estructura enviada probablemente no cumple con los requisitos del WSDL.

## Archivos entregados

- Código fuente Laravel
- Colección Postman (.json)
- Capturas de pantalla (clima y pago SOAP)
- Archivo README.md

## Autor

Cristian Parrado  
parradocristian07@gmail.com  
Villavicencio, Colombia
