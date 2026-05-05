# Docker Usage

## Donde colocar futuros proyectos PHP

El primer proyecto ya quedo organizado en:

- `volumes/app/sistedu`

Apache ahora monta esa carpeta en `/var/www/html`.

Para futuros proyectos PHP, usa una subcarpeta por proyecto dentro de `volumes/app/`.

Ejemplo:

- `volumes/app/proyecto_a`
- `volumes/app/proyecto_b`
- `volumes/app/sistedu`

No conviene mezclar varios proyectos dentro de una sola carpeta porque terminas compartiendo archivos, configuracion y dependencias.

## Donde colocar bases de datos

La persistencia real de MariaDB queda en:

- `volumes/db/`

Ese directorio no se edita manualmente. MariaDB guarda ahi sus archivos internos.

Si quieres guardar respaldos o dumps SQL, usa archivos `.sql` fuera de `volumes/db/`, por ejemplo:

- `ujosemarti_sistem.sql`
- `backups/proyecto_a.sql`

Para este proyecto, el dump principal queda en:

- `backups/ujosemarti_sistem.sql`

## Conexion desde HeidiSQL

Con el `docker-compose.yml` actual, HeidiSQL se conecta asi:

- Host: `127.0.0.1`
- Puerto: `3307`
- Usuario: `sistedu_user`
- Password: `sistedu_pass`
- Base de datos: `ujosemarti_sistem`

Si quieres entrar como root:

- Usuario: `root`
- Password: `root`

## phpMyAdmin

phpMyAdmin queda integrado en el mismo Apache local y se accede en:

- `http://localhost/phpmyadmin`

Puedes entrar con:

- Usuario: `sistedu_user`
- Password: `sistedu_pass`

O con root:

- Usuario: `root`
- Password: `root`

## Notas

- Primero levanta los contenedores con `docker compose up --build`.
- Si el contenedor ya habia sido creado con otra configuracion de volumen, puede que necesites recrearlo.
- El puerto `3307` se usa para evitar conflicto con una instalacion local de MariaDB o MySQL en el host.