/mi-proyecto
├── /assets                     # Recursos estáticos (CSS, JS, imágenes)
│   ├── /css                   # Archivos CSS
│   │   └── styles.css
│   ├── /js                    # Archivos JavaScript
│   │   └── scripts.js         # Archivos JS si necesitas
│   └── /images                # Imágenes del proyecto
├── /config                     # Configuraciones del proyecto
│   ├── config.php             # Configuración de la conexión a la base de datos
│   └── db_connection.php      # Archivo para la conexión a la base de datos
├── /includes                   # Archivos de inclusión
│   ├── header.php             # Encabezado común del sitio
│   └── footer.php             # Pie de página común del sitio
├── /node_modules              # Dependencias de Node.js (si aplica)
├── /database                   # Base de datos
│   └── portal_eventos_db.sql   # Archivo con la base de datos exportada
├── /src                        # Código fuente del proyecto
│   ├── /controllers            # Controladores que manejan la lógica de negocio
│   ├── /models                 # Modelos para manejar datos (si aplica)
│   ├── /views                  # Vistas o páginas del sitio
│   │   ├── index.php           # Página de inicio
│   │   ├── registro.php        # Página de registro de usuario
│   │   ├── login.php           # Página de inicio de sesión
│   │   ├── eventos.php         # Página principal de eventos
│   │   ├── eventos_detalle.php # Detalles de eventos
│   │   ├── contacto.php         # Página de contacto
│   │   ├── mis_eventos.php      # Página para ver eventos del usuario
│   │   ├── inscribirse_evento.php # Página para inscribirse a un evento
│   │   ├── no_access.php       # Página de acceso denegado
│   │   ├── eliminar_evento.php  # Página para eliminar evento
│   │   ├── eliminar_usuario.php  # Página para eliminar usuario
│   │   └── cancelar_inscripcion.php # Página para cancelar inscripción
│   └── /utils                  # Funciones utilitarias (si tienes)
├── /tests                      # Archivos de pruebas (si tienes pruebas)
├── package-lock.json           # Archivo de bloqueo de paquetes
├── package.json                # Dependencias y scripts de Node.js
├── README.md                   # Documentación del proyecto
└── .gitignore                  # Archivos y carpetas a ignorar por Git