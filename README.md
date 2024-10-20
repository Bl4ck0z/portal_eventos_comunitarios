# Portal de Eventos Comunitarios

## Descripción

El **Portal de Eventos Comunitarios** es una aplicación web desarrollada en PHP y MySQL, que permite a los usuarios registrarse, gestionar y asistir a eventos comunitarios. Los administradores tienen privilegios especiales para crear, editar y eliminar eventos, mientras que los usuarios pueden inscribirse a los eventos y gestionar su inscripción.

### Funcionalidades

- **Registro y autenticación de usuarios.**
- **Gestión de eventos**: Creación, edición y eliminación de eventos (solo para administradores).
- **Inscripción de eventos**: Los usuarios pueden inscribirse en eventos y ver en qué eventos están inscritos.
- **Sección de contacto**: Los usuarios pueden enviar mensajes a los administradores.
- **Comentarios y valoraciones**: Los usuarios pueden dejar comentarios y valoraciones sobre los eventos.

## Instalación

### Requisitos

- **XAMPP** (o cualquier servidor local que soporte PHP y MySQL).
- **PHP 7.4 o superior**.
- **MySQL**.

### Pasos para la instalación

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/tu-usuario/portal_eventos_comunitarios.git
Abre el archivo includes/db.php y verifica que las credenciales de conexión sean correctas:
php

$host = 'localhost';
$dbname = 'eventos_db';
$username = 'root';
$password = '';  // Ajusta si tienes una contraseña para MySQL.

Iniciar el servidor local:

Inicia los módulos Apache y MySQL en XAMPP.
Abre un navegador web y navega a http://localhost/portal_eventos_comunitarios.

Estructura del Proyecto
├── assets
│   └─── styles.css
├── images
├── includes
    ├──config.php       #Activos configuracion de la conexion de la base de datos
│   ├── db_connection.php           # Archivo para la conexión a la base de datos
│   ├── header.php       # Encabezado común del sitio
│   ├── footer.php       # Pie de página común del sitio
├── node_modules
    ├──@popperjs
│   ├── bootstrap
    ├──.packege-lock.json
├── portal_eventos_db
│   └── portal_eventos_db   # Archivo con la base de datos exportada
cancelar_inscrioncio.php
contacto.php
eliminar_evento.php
eliminar_usuario.php
eventos_detalle.php
eventos.php
gestionar_eventos.php
hestopmar_usuarios.php
index.php
inscribirse_evento.php
login.php
logout.php
mis_eventos.php
no_access.php
package-lock.json
package.json
Readme.md
registro.php
ver_contacto.php

**Uso**

>>Usuarios Regulares
--Los usuarios pueden registrarse e iniciar sesión.
--Pueden inscribirse a los eventos y gestionar su inscripción.
--Pueden enviar mensajes a través de la página de contacto.

**Administradores**
--Los administradores pueden crear, editar y eliminar eventos.
--Pueden gestionar usuarios y ver los mensajes enviados desde la sección de contacto.

**Importar la Base de Datos**
--Abre phpMyAdmin (http://localhost/phpmyadmin).
--Crea una nueva base de datos llamada eventos_db.
--Ve a la pestaña Importar y selecciona el archivo database.sql que se encuentra en la carpeta database del proyecto.
--Haz clic en Ir para importar la base de datos.
--Contacto
--Para cualquier duda o sugerencia, puedes enviar un mensaje al correo jeremyloraalmonte@gmail.com


### **Instrucciones para usar el archivo README:**

1. **Crea un archivo `README.md`** en la raíz de tu proyecto.
2. **Copia y pega** el contenido que te proporcioné en ese archivo.
3. **Modifica** las partes necesarias, como el enlace del repositorio de GitHub y el correo de contacto.
4. Sube el archivo al repositorio usando los siguientes comandos en la terminal:

   ```bash
   git add README.md
   git commit -m "Añadido archivo README"
   git push

