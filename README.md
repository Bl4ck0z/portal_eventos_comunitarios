# Portal de Eventos

## Descripción del Proyecto

Este proyecto es un portal web para la gestión de eventos, donde los usuarios pueden registrarse, iniciar sesión, inscribirse en eventos, dejar comentarios y valoraciones. La aplicación ha sido desarrollada y probada inicialmente en un entorno local y posteriormente se ha subido a un servidor utilizando cPanel.

## Funcionalidades

- **Página de Inicio**: Presenta una breve descripción del portal y acceso a eventos destacados.
- **Registro y Autenticación**: Permite a los usuarios registrarse y acceder a su cuenta.
- **Gestión de Eventos**:
  - Creación, lectura, actualización y eliminación de eventos (solo para administradores).
  - Visualización de detalles del evento (fecha, ubicación, descripción, etc.).
  - Inscripción en eventos por parte de los usuarios.
- **Interfaz de Usuario**: Diseño responsivo y atractivo utilizando frameworks CSS como Bootstrap o Tailwind.
- **Comentarios y Valoraciones**: Los usuarios pueden dejar comentarios y valoraciones sobre los eventos.
- **Buscador y Filtros**: Funcionalidad para buscar eventos por fecha, categoría y ubicación.
- **Sección de Contacto**: Formulario para que los usuarios envíen consultas o sugerencias.

# Portal de Eventos

## Descripción del Proyecto

El **Portal de Eventos** es una aplicación web diseñada para la gestión integral de eventos. Los usuarios pueden registrarse, iniciar sesión, inscribirse en eventos, dejar comentarios y valoraciones, y mucho más. Desarrollado inicialmente en un entorno local, el proyecto ha sido probado exhaustivamente antes de su despliegue final en un servidor mediante cPanel, asegurando su estabilidad y correcto funcionamiento en producción.

Este proyecto está orientado a ofrecer una experiencia de usuario atractiva y responsiva, con funcionalidades avanzadas para la gestión de eventos tanto para administradores como para usuarios regulares.

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
├── /assets                     # Recursos estáticos (CSS, JS, imágenes)
│   ├── /css                    # Archivos CSS
│   │   └── styles.css
│   ├── /js                     # Archivos JavaScript
│   │   └── scripts.js
│   └── /images                 # Imágenes del proyecto
├── /config                     # Configuraciones del proyecto
│   ├── config.php              # Configuración de la conexión a la base de datos
│   └── db_connection.php       # Archivo para la conexión a la base de datos
├── /includes                   # Archivos de inclusión
│   ├── header.php              # Encabezado común del sitio
│   └── footer.php              # Pie de página común del sitio
├── /node_modules               # Dependencias de Node.js (si aplica)
├── /database                   # Base de datos
│   └── portal_eventos_db.sql   # Archivo con la base de datos exportada
├── /src                        # Código fuente del proyecto
│   ├── /controllers            # Controladores que manejan la lógica de negocio
│   ├── /models                 # Modelos para manejar datos (si aplica)
│   └── /views                  # Vistas o páginas del sitio
│       ├── index.php           # Página de inicio
│       ├── registro.php        # Página de registro de usuario
│       ├── login.php           # Página de inicio de sesión
│       ├── eventos.php         # Página principal de eventos
│       ├── eventos_detalle.php # Detalles de eventos
│       ├── contacto.php        # Página de contacto
│       ├── mis_eventos.php     # Página para ver eventos del usuario
│       ├── inscribirse_evento.php # Página para inscribirse a un evento
│       ├── no_access.php       # Página de acceso denegado
│       ├── eliminar_evento.php # Página para eliminar evento
│       ├── eliminar_usuario.php # Página para eliminar usuario
│       └── cancelar_inscripcion.php # Página para cancelar inscripción
├── /utils                      # Funciones utilitarias (si tienes)
├── /tests                      # Archivos de pruebas (si tienes pruebas)
├── package-lock.json            # Archivo de bloqueo de paquetes
├── package.json                 # Dependencias y scripts de Node.js
├── README.md                    # Documentación del proyecto
└── .gitignore                   # Archivos y carpetas a ignorar por Git
