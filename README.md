# Prerrequisitos

1. Tener instalado docker puede descargarse desde aqui: [docker install](https://docs.docker.com/engine/install/)
2. Tener extension open ssl, puede descargarse desde aqui [open ssl](https://www.openssl.org/source/) o para window puedes descargar directamente el excutable [windows](https://slproweb.com/products/Win32OpenSSL.html)

# Ejecutar proyecto en dev

### Ejecutar pasos en orden

1. Clonar repositorio
2. Ir a carpeta del proyecto `cd ./currencyconverter_api`
3. Levantar base de datos

```
docker-compose up -d
```

3. Clonar el archivo `.env.example` y renombarlo `.env.local`
4. Ejecutar

```
composer install
```

5. Ejecutar migraciones

```
php bin/console doctrine:migrations:migrate
```

6. Generar keypair para jwt

```
php bin/console lexik:jwt:generate-keypair
```

7. Levantar proyecto

```
symfony serve
```
