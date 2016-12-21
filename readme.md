# API Restful de la Aplicación PILI

[![dependencies Status](https://david-dm.org/Meyito/Practicas-BACK/status.svg)](https://david-dm.org/Meyito/Practicas-BACK)
[![Github Issues](https://img.shields.io/github/issues/Meyito/Practicas-BACK.svg)](http://github.com/Meyito/Practicas-BACK/issues)

La aplicación fue desarrollada con el Framework [Lumen](http://lumen.laravel.com/docs).

## Requisitos

- php >=5.5.9
- [Composer](https://getcomposer.org/)


## Instalación

### Instalar dependencias 
```
composer install
```

### Variables de entorno y configuración
- Crear archivo .env en la carpeta raiz del proyecto y pegar el contenido del archivo .env.example (Se deben remplazar los valores por los del entorno local)

- Se deben configurar las credenciales de la base de datos en `config/database.php`

### Migraciones de la base de datos
````
php artisan migrate:refresh --seed
````


## Errores Conocidos
- Si al intentar migrar la base de datos aparece un error que indica que alguna clase no fue encontrada ejecutar
````
composer dump-autoload
php artisan migrate:refresh --seed
```
