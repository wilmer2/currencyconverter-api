# Prerrequisitos

1. Tener instalado docker puede descargarse desde aqui: [docker install](https://docs.docker.com/engine/install/)
2. Tener extension open ssl, puede descargarse desde aqui [open ssl](https://www.openssl.org/source/) o para window puedes descargar directamente el excutable [windows](https://slproweb.com/products/Win32OpenSSL.html)

# Ejecutar proyecto dev

1. Clonar respositorio
2. Ejecutar

```
composer install
```

3. Clonar el archivo `.env.example` y renombarlo `.env.local`
4. Levantar base de datos

```
docker-compose up -d
```

5. Ejecutar migraciones

```
php bin/console doctrine:migrations:migrate
```

6. Generar keypair para jwt

```
php bin/console lexik:jwt:generate-keypair
```
