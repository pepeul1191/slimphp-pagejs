# Slim PHP Boilerplate

Instalar depdendencias:

    $ composer install && bower install

Refrescar composer:

    $ composer dump-autoload -o

Basado en Slim Framework 3 Skeleton Application

## Correr test de carga

Cambiar en 'src/configs/settings.php' el valor de llave 'ambiente_csrf' y 'ambiente_session' a 'inactivo' .

## Crear OAuth en Gmail:

Google no acepta colocar dominio autorizado a localhost. Como solución para el desarrollo local, hay que crear un 'host entry pointing'.

1. Entrar a https://console.developers.google.com/
2. Crear un API y Servicios
3. Crear ID de cliente de OAuth
4. Selecionar 'Aplicacion Web' y regitrar la pagina de redireccion.

Callback URL: http://localhost:8080/user/signin/callback.php?origin=google

---

Fuentes:

+ https://www.slimframework.com/docs/v3/tutorial/first-app.html
+ https://stackoverflow.com/questions/34807616/slim-3-render-method-not-valid
+ https://stackoverflow.com/questions/36993560/pass-arguments-in-slim-di-service
+ https://gist.github.com/akrabat/636a8833695f1e107701
+ https://www.slimframework.com/docs/v3/concepts/middleware.html
+ https://stackoverflow.com/questions/36521233/slim-3-middleware-redirect
+ https://github.com/slimphp/Slim-Skeleton
+ https://github.com/pepeul1191/php-oauth2-github
+ https://developers.google.com/identity/protocols/oauth2/web-server#uri-validation
