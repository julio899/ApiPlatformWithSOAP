# Web Developer (FullStack) Julio Vinachi

* Recomendaciones  especificacion de ambiente donde se desarrollo
```
PHP 7.4.7 (cli) (built: Jun 12 2020 07:44:05) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
  with Zend OPcache v7.4.7, Copyright (c), by Zend Technologies

npm V6.14.5

@vue/cli 4.4.1

Composer version 1.10.7 2020-06-03 10:03:56


- composer
- node
- vue cli

```

## dependencias e Instalacion
- en la raiz del proyecto Ejecutar

> composer install

- para el ambiente de desarrollo en vue para el frontend hubicado en la carpeta frontend-value

> cd frontend-value/ && npm install



## BD toda realizada implementado el ORM de Symfony

1 - cuando instales `composer install` el proyecto se te generara un archivo **.env**  de environment
    configurar con tus datos de acceso para mysql `DATABASE_URL=mysql://root:AlgunaClaveMia@127.0.0.1:3306/backend899`

    donde backend899  representa el nombre de la bd que yo le quiero colocar

2 - aplicar o crear tabla de entidades
    >php bin/console make:migration


    actualizar las tablas conforme a las entidades escritas y sus relaciones
    >php bin/console doctrine:schema:update --force


## Para correr el backend ubicarse en la raiz y correr

    >php -S 127.0.0.1:8000 -t public/

## ENDPOINS

-   todos visibles desde el controlador principal `DefaultController`

```
  home                 GET      ANY      ANY    /                                    
  register_soap        POST     ANY      ANY    /v1/register                         
  login_soap           POST     ANY      ANY    /v1/login                            
  balance              GET      ANY      ANY    /v1/{wallet}/balance                 
  getcode              POST     ANY      ANY    /v1/{wallet}/getcode                 
  tanssaction          POST     ANY      ANY    /v1/{wallet}/tanssaction             
  deposit              POST     ANY      ANY    /v1/{wallet}/deposit
```

* Siendo los del soap

```
  register_soap        POST     ANY      ANY    /v1/register
  login_soap           POST     ANY      ANY    /v1/login
```