## Manual de Instalación Local (Configuración del Entorno)

Para desplegar y ejecutar este sistema en un nuevo equipo de desarrollo, sigue los pasos detallados a continuación:

**1. Requisitos Previos y PHP (Versión 8.3.33)**

* Verifica que tengas instalado PHP en tu sistema. Si no cuentas con él, instala la versión **PHP 8.3.33**.
* **Configuración en XAMPP:**
* Renombra la carpeta del PHP anterior en XAMPP a `php_viejo`.
* Asigna el nombre `php` a la carpeta con la nueva versión (PHP 8.3.33).
* Dentro de la nueva carpeta, toma el archivo `php.ini-development` y renombralo como `php.ini`.


* **Modificación de Extensiones en `php.ini`:**
Abre el archivo `php.ini` y remueve el punto y coma (`;`) al inicio de las siguientes extensiones para habilitarlas:
```ini
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_mysql

```


* **Ruta de Extensiones:**
Dentro de `php.ini`, busca la variable `extension_dir` y actualízala con la ruta de tu instalación:
```ini
extension_dir = "C:\xampp\php\ext"

```


* **Variables de Entorno del Sistema:**
Agrega la ruta de PHP a las Variables de Entorno del sistema (PATH) en Windows:
`C:\xampp\php`

---

**2. Instalación de Dependencias y Composer**

* Descarga e instala Composer en el equipo.
* Ejecuta en la terminal de la raíz del proyecto para instalar las librerías:
```bash
composer install

```


* Si tenías Composer instalado previamente con otra versión global, sincroniza las dependencias con la versión actual de PHP ejecutando:
```bash
composer update

```



---

**3. Configuración de Entorno (.env) y Base de Datos**

* Crea el archivo `.env` en la raíz del proyecto (puedes copiar el archivo `.env.example`).
* Genera la clave de la aplicación ejecutando:
```bash
php artisan key:generate

```


* Configura las credenciales de acceso a la base de datos (ya sea conexión local o remota en la nube como Aiven) dentro del archivo `.env`. Por motivos de seguridad, estas credenciales no se suben al repositorio.

---

**4. Ejecución del Proyecto**

* Inicia el servidor de desarrollo local con el comando:
```bash
php artisan serve

```


* Accede al sistema desde tu navegador en `[http://127.0.0.1:8000](http://127.0.0.1:8000)`.

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

* [Simple, fast routing engine](https://laravel.com/docs/routing).
* [Powerful dependency injection container](https://laravel.com/docs/container).
* Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
* Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
* Database agnostic [schema migrations](https://laravel.com/docs/migrations).
* [Robust background job processing](https://laravel.com/docs/queues).
* [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install

```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).