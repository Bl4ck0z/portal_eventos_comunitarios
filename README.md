# Portal de Eventos

## Descripción del Proyecto

El **Portal de Eventos** es una aplicación web diseñada para la gestión integral de eventos. Los usuarios pueden registrarse, iniciar sesión, inscribirse en eventos, dejar comentarios y valoraciones, y mucho más. Desarrollado inicialmente en un entorno local, el proyecto ha sido probado exhaustivamente antes de su despliegue final en un servidor mediante cPanel.

## Funcionalidades

- **Página de Inicio**: 
  - Breve descripción del portal.
  - Acceso directo a eventos destacados con enlaces a más detalles y opciones de inscripción.

- **Registro y Autenticación**:
  - Los usuarios pueden crear una cuenta mediante un proceso sencillo de registro.
  - Inicio de sesión seguro para acceder a las funcionalidades personalizadas del portal.

- **Gestión de Eventos**:
  - **Administradores**: Capacitados para crear, editar, actualizar y eliminar eventos.
  - **Usuarios**: Acceso a la visualización de eventos, detalles de los mismos (fecha, ubicación, descripción), e inscripción en los eventos disponibles.

- **Interfaz de Usuario**: 
  - Diseño completamente responsivo, optimizado para dispositivos móviles, tablets y escritorios.
  - Implementación de frameworks CSS (como Bootstrap o Tailwind) para garantizar una experiencia visual moderna y uniforme.

- **Comentarios y Valoraciones**:
  - Los usuarios pueden dejar comentarios y valoraciones después de asistir a un evento.
  - Esta funcionalidad permite generar retroalimentación sobre los eventos organizados.

- **Buscador y Filtros**:
  - Función de búsqueda avanzada para encontrar eventos según criterios como fecha, categoría y ubicación.
  - Sistema de filtros dinámico que facilita la localización de eventos de interés específico.

- **Sección de Contacto**:
  - Formulario de contacto accesible desde el portal para que los usuarios puedan realizar consultas o enviar sugerencias.
  - Envío automático de notificaciones por correo para asegurar una respuesta rápida a las solicitudes.

- **Panel de Usuario**:
  - Cada usuario registrado tiene un panel personal donde puede revisar los eventos a los que está inscrito, cancelar su inscripción, y gestionar su perfil.

- **Sistema de Notificaciones**:
  - Los usuarios reciben notificaciones por correo sobre actualizaciones importantes de los eventos a los que están inscritos, como cambios en la fecha o ubicación.

## Tecnologías Utilizadas

- **Frontend**: 
  - HTML5, CSS3, JavaScript.
  - Frameworks CSS: Bootstrap / Tailwind.
  
- **Backend**: 
  - PHP, MySQL para la gestión de datos.
  
- **Base de Datos**:
  - MySQL para almacenar toda la información relacionada con usuarios, eventos, y comentarios.

- **Control de Versiones**: 
  - Git y GitHub para el manejo del código fuente.

- **Despliegue**: 
  - La aplicación se ha desplegado en un servidor a través de **cPanel**, asegurando un entorno de producción estable y accesible para los usuarios.

## Estructura del Proyecto

```bash
├── /assets                         # Recursos estáticos (CSS, JS, imágenes)
│   ├── /css                        # Archivos CSS
│   │   └── styles.css
│   │   └── bootstrap-grid.css.map
│   │   └── bootstrap-grid.min.css
│   │   └── bootstrap-grid.min.css.map
│   │   └── bootstrap-grid.rtl.css
│   │   └── bootstrap-grid.rtl.css.map
│   │   └── bootstrap-grid.rtl.min.css
│   │   └── bootstrap-grid.rtl.min.css.map
│   │   └── bootstrap-reboot.css
│   │   └── bootstrap-reboot.css.map
│   │   └── bootstrap-reboot.min.css
│   │   └── bootstrap-reboot.min.css.map
│   │   └── bootstrap-reboot.rtl.css
│   │   └── bootstrap-reboot.rtl.css.map
│   │   └── bootstrap-reboot.rtl.min.css
│   │   └── bootstrap-reboot.rtl.min.css.map
│   │   └── bootstrap-utilities.css
│   │   └── bootstrap-utilities.css.map
│   │   └── bootstrap-utilities.min.css
│   │   └── bootstrap-utilities.min.css.map
│   │   └── bootstrap-utilities.rtl.css
│   │   └── bootstrap-utilities.rtl.css.map
│   │   └── bootstrap-utilities.rtl.min.css
│   │   └── bootstrap-utilities.rtl.min.css.map
│   │   └── bootstrap.css
│   │   └── bootstrap.css.map
│   │   └── bootstrap.min.css
│   │   └── bootstrap.min.css.map
│   │   └── bootstrap.rtl.css
│   │   └── bootstrap.rtl.css.map
│   │   └── bootstrap.rtl.min.css
│   │   └── bootstrap.rtl.min.css.map
│   ├── /js                         # Archivos JavaScript
│   │   └── scripts.js
│   │   └── bootstrap.bundle.js
│   │   └── bootstrap.bundle.js.map
│   │   └── bootstrap.bundle.min.js
│   │   └── bootstrap.bundle.min.js.map
│   │   └── bootstrap.esm.js
│   │   └── bootstrap.esm.js.map
│   │   └── bootstrap.esm.min.js
│   │   └── bootstrap.esm.min.js.map
│   │   └── bootstrap.js
│   │   └── bootstrap.js.map
│   │   └── bootstrap.min.js
│   │   └── bootstrap.min.js.map
│   └── /images                     # Imágenes del proyecto
│       └── event_background.jpg
│       └── event_placeholder.jpg
├── /config                         # Configuraciones del proyecto
│   ├── config.php                  # Configuración principal
│   └── db_connection.php           # Archivo para la conexión a la base de datos
├── /includes                       # Archivos de inclusión
│   ├── header.php                  # Encabezado común del sitio
│   └── footer.php                  # Pie de página común del sitio
├── /database                       # Base de datos
│   └── portal_eventos_db.sql       # Archivo con la base de datos exportada
├── /src                            # Código fuente del proyecto
│   ├── /controllers                # Controladores
│   │   └── EventController.php
│   ├── /models                     # Modelos de datos (si aplica)
│   └── /views                      # Vistas o páginas del sitio
│       ├── contacto.php
│       ├── contacto_gestion.php
│       ├── evento.php
│       ├── evento_cancelar.php
│       ├── evento_comentar.php
│       ├── evento_crear.php
│       ├── evento_detalles.php
│       ├── evento_eliminar.php
│       ├── evento_gestion.php
│       ├── evento_inscribirse.php
│       ├── evento_lista.php
│       ├── index.php
│       ├── login.php
│       ├── logout.php
│       ├── no_access.php
│       ├── register.php
│       ├── usuario_desabilitar.php
│       ├── usuario_gestion.php
│       └── usuario_habilitar.php
├── /utils                          # Funciones utilitarias (si tienes)
├── /tests                          # Archivos de pruebas (si tienes)
├── package-lock.json               # Archivo de bloqueo de paquetes
├── package.json                    # Dependencias y scripts de Node.js
├── README.md                       # Documentación del proyecto
└── .gitignore                      # Archivos y carpetas a ignorar por Git
```

## Instalación y Configuración

### Requisitos Previos

- Servidor con soporte para PHP y MySQL.
- Opcionalmente, Node.js para gestionar dependencias de frontend.

### Pasos para la Instalación

1. Clonar el repositorio desde GitHub.
2. Configurar la base de datos con el archivo `portal_eventos_db.sql` ubicado en la carpeta `/database`.
3. Modificar los archivos de configuración en `/config/config.php` para adaptarlos a las credenciales de tu servidor.
4. Desplegar el proyecto en el servidor utilizando cPanel u otro método preferido.
5. Abrir el navegador y acceder al sitio para verificar la instalación.

## Contribuciones

Este proyecto es de código abierto. Si deseas contribuir:

1. Haz un **fork** del repositorio.
2. Crea una rama con tu nueva funcionalidad o mejora (`git checkout -b feature/nueva-funcionalidad`).
3. Haz un **pull request** cuando esté listo para revisión.
