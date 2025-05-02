PARTE 1: CREAR API CON TOKEN DE LOGIN Y ROLES
PASO 1:
Creamos nuestro proyecto. Para ello, desde la cmd con la direccion de nuestra carpeta ejecutaremos el comando:
    composer create-project laravel/laravel UF4-PR
    cd UF4-PR

Con esto se nos creará una nueva carpeta dentro de esta que contendrá nuestra
aplicación.

PASO 2:
Ahora deberemos insatal Sanctum. 
Ejecutaremos los comando:
    composer require laravel/sanctum
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate

Y actualizaremos el archivo Kernel.php de app/Http, añadiendo 'api'

PASO 3:
Como en esta ocasión estaremos reutilizando la tabla users que nos crea automaticamente laravel, solo deberemos de añadir la columna 'role'.
Lo podemos hacer con el siguiente comando:
    php artisan make:migration add_role_to_users_table
en el archivo de migracion que se nos ha creado actualizaremos con la información de la columna nueva. Y ejecutaremos el comando:
    php artisan migrate
Para actualizar en nuestra BBDD

PASO 4:
Crearemos ahora nuestra tabla de productos. 
Empezaremos ejecutando el comando:
    php artisan make:model Product -mcr
De esta forma se nos creará un nuevo modelo Product en app/Models.
Lo ajustaremos con las columnas que queremos que tenga desde su archivo de migración. Y una vez configurado ejecutaremos el comando:
    php artisan migrate

Con esto tendríamos la migracion de la tabla users y products listas para replicarlas en nuestra BBDD  

PASO 5:
Crearemos las rutas para login y registros de usuarios y también nos crearemos un controlador para la autentificacion, que nos genere el token. 
Ejecutaremos el comando:
    php artisan make:controller AuthController

Y actualizaremos el archivo con la información correcta.

PASO 6: 
Actualizaremos el archivo database/seeders/DatabaseSeeder.php con la informaicón para actualizar el rol del usuario de usuari a administrador y ejecutaremos el comando:
    php artisan db:seed

PASO 7:
Añadiremos las rutas para las funciones de productos a nuestro api.php
Como hay algunas rutas a las que solo deben poder acceder los admins, crearemos el middlewhare AdminMiddleWare con el comando:
    php artisan make:middleware AdminMiddleware

Lo actualizaremos con la comprobación del rol y lo añadiremos al kernel.php

PASO 8:
Para validar que la información de productos recibida es correcta usaremos FormRequest. Ejecutaremos el siguiente comando para crearnos nuestro form:
    php artisan make:request ProductRequest

Con esto se nos creará la carpeta Requests dentro de  app/Http con el archivo ProductRequest.php.
Configuraremos en el las validaciones correspondientes 

PASO 9: 
Por ultimo, para terminar con la parte 1 del proyecto, deberemos configurar Swagger, para documentar todas las llamadas. 
Empezaremos configurandolo en nuestro proyecto con los siguientes comandos:
    composer require "darkaonline/l5-swagger"
    php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

Y añadiremos la configuración también en ProductController para poder acceder desde localhost:8000/api/documentation

PARTE 2: CREAR VISTAS Y FRONTEND
PASO 10:
Comenzaremos  instalando las dependencias necesarias, en este caso con estos dos comandos:
    npm install
    npm install vue@3 axios

Una vez instaladas todas configuraremos el archivo vite.cong.js y el archivo resources/js/app.js

PASO 11:
Deberemos crear el componenet .vue productesTable. Los crearemos dentro de resources/js/components

Y crearemos tambien las vistas .blade.php para login y el componente anterior. Estas las crearemos dentro de resources/views

PASO 12:
Deberemos importar el componente aixos en app.js para poder realizar la autentificacion con token.

PASO 13:
Por ultimo debemos configurar las rutas en web.api

PASO 14:
Levantaremos el servicio ejecutando las comandas:
    npm run dev
    php artisan serve
