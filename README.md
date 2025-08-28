docker build --pull --rm -f 'Dockerfile' -t 'dockercigniter1:latest' '.'

# Prueba Docker + CodeIgniter 4

Este proyecto es un ejemplo de uso de **CodeIgniter 4** dentro de un entorno Docker, con pruebas automatizadas usando **PHPUnit**.

---

## 🚀 Instalación

### 1. Clonar el repositorio

````bash
git clone https://github.com/Friveros10/prueba_docker_ci.git
cd prueba_docker_ci
### 2. Montar la imagen desde el Dockerfile

### 3. Levantar los servicios con `docker-compose`

Esto iniciará:

- Un contenedor para PHP + Apache.
- Un contenedor para MySQL.

---

### 4. Configurar el archivo `.env`

Asegúrate de tener el archivo `.env` en la raíz del proyecto con la siguiente configuración (o ajusta según tus contenedores):

```ini
database.default.hostname = mysql_db
database.default.database = flowers
database.default.username = root
database.default.password = toor
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

> ⚠️ El nombre del host (`mysql_db`) debe coincidir con el nombre del servicio MySQL en tu archivo `docker-compose.yml`.

---

### 5. Instalar dependencias de Composer

Dentro del contenedor de la aplicación, ejecuta:

````bash
docker exec -it <id_contenedor_app> /bin/bash
composer install
## ✅ Ejecutar pruebas con PHPUnit

Desde dentro del contenedor:

```bash
docker exec -it <id_contenedor_app> /bin/bash
./vendor/bin/phpunit
````

Esto correrá todas las pruebas definidas en la carpeta `/tests`.

---

## 🐳 Consejos adicionales

- Para ver el ID o nombre del contenedor en ejecución:

```bash
docker ps
```

- Para acceder a un contenedor:

```bash
docker exec -it <id_contenedor_app> /bin/bash
## 🧪 Estructura del Proyecto

```

.
├── app/ # Código fuente de CodeIgniter
├── public/ # Document root
├── tests/ # Pruebas unitarias y funcionales
├── Dockerfile
├── docker-compose.yml
├── .env
├── composer.json
└── README.md

## 📄 Licencia

MIT — libre para usar y modificar.
