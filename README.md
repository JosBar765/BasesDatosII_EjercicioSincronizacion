# Sincronización de Bases de Datos MySQL y PostgreSQL

Sistema web desarrollado en PHP y JavaScript para la sincronización bidireccional de registros entre una base de datos MySQL y PostgreSQL.

El sistema permite:

* Conectarse dinámicamente a MySQL o PostgreSQL
* Insertar empleados
* Actualizar empleados
* Eliminar empleados de manera lógica
* Sincronizar registros entre ambas bases de datos
* Resolver conflictos utilizando la fecha de modificación más reciente

---

# Tecnologías utilizadas

* PHP
* JavaScript
* HTML5
* CSS3
* MySQL
* PostgreSQL
* PDO
* SweetAlert2

---

# Estructura del proyecto

```bash
├── backend
│   ├── accion
│   ├── conexion
│   ├── config
│   └── sync
├── app.js
├── tabla.js
├── index.html
└── style.css
```

---

# Requisitos

Antes de ejecutar el proyecto es necesario tener instalado:

* XAMPP o cualquier servidor Apache con PHP
* MySQL Server
* PostgreSQL
* PHP 8 o superior
* Navegador web moderno

---

# Configuración del proyecto

## 1. Clonar o descargar el proyecto

Colocar el proyecto dentro de la carpeta del servidor web.

Ejemplo en XAMPP:

```bash
C:\xampp\htdocs\sincronizacion
```

---

## 2. Crear las bases de datos

Se deben crear dos bases de datos:

### MySQL

Nombre:

```sql
DB_2
```

### PostgreSQL

Nombre:

```sql
DB_1
```

---

# Crear tabla Empleado

La tabla debe existir en ambas bases de datos con la misma estructura.
Ambos scripts se encuentran dentro de la carpeta `database-scripts/` del repositorio.

---

# Configurar credenciales

Abrir el archivo:

```bash
backend/config/credenciales.php
```

Modificar las credenciales según la configuración local del usuario.

## Ejemplo

```php
//
// MySQL
//
$HOST = "localhost";
$DBNAME = "DB_2";
$USER = "root";
$PASSWORD = "";

//
// PostgreSQL
//
$HOST = "localhost";
$PORT = "5432";
$DBNAME = "DB_1";
$USER = "postgres";
$PASSWORD = "postgre";
```

---

# Habilitar extensiones de PHP

Es necesario habilitar las extensiones PDO para MySQL y PostgreSQL dentro de la configuración de XAMPP.
Primero, hay que ubicarse en el disco local (C:/) y entrar a la carpeta `xampp/`. Luego, entrar a la carpeta `php/`. Y por último, seguir lo siguiente pasos:

Abrir el archivo:

```bash
php.ini
```

Y asegurarse de descomentar:

```ini
extension=pdo_mysql
extension=pdo_pgsql
```

Luego reiniciar Apache.

---

# Ejecutar el proyecto

Iniciar:

* Apache
* MySQL
* PostgreSQL

Después abrir en el navegador:

```bash
http://localhost/sincronizacion
```

---

# Funcionamiento del sistema

## Conexión

El sistema permite conectarse manualmente a:

* MySQL
* PostgreSQL

La conexión activa se muestra mediante un badge en la interfaz.

---

## Operaciones disponibles

* Insertar empleados
* Actualizar empleados
* Eliminar empleados
* Buscar empleados
* Sincronizar bases de datos

---

# Cómo funciona la sincronización

La sincronización es bidireccional.

El sistema:

1. Obtiene todos los registros de MySQL
2. Obtiene todos los registros de PostgreSQL
3. Compara los DPI
4. Inserta registros faltantes
5. Actualiza registros usando la fecha más reciente
6. Elimina físicamente registros si ambos están marcados como eliminados

---

# Validaciones implementadas

El sistema valida:

* DPI de 13 dígitos
* Teléfonos de 8 dígitos
* Campos vacíos
* Números negativos
* DPI duplicados

---

# Notas importantes

* Ambas bases de datos deben tener exactamente la misma estructura.
* La tabla debe llamarse:

  * `Empleado` en MySQL
  * `"Empleado"` en PostgreSQL
* PostgreSQL debe estar ejecutándose en el puerto configurado.
* Si cambian los nombres de las bases de datos, también deben actualizarse en `credenciales.php`.

---

# Posibles errores comunes

## Error de conexión MySQL

Verificar:

* Que MySQL esté iniciado
* Usuario y contraseña correctos
* Nombre de la base de datos

---

## Error de conexión PostgreSQL

Verificar:

* Servicio PostgreSQL iniciado
* Puerto correcto
* Usuario y contraseña correctos

---

## Error PDO

Verificar que las extensiones estén habilitadas:

```ini
extension=pdo_mysql
extension=pdo_pgsql
```

---

# Autor

Desarrollado por Josué Abraham Barrios Ramírez 090-23-4777.
