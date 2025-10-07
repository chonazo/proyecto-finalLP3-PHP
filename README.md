# 📌 SysWeb - Sistema Web en PHP (MVC + PDO + MySQL)

Este proyecto es un **sistema web básico** desarrollado en **PHP nativo** utilizando el **patrón MVC**, **PDO** para la conexión a base de datos y **Bootstrap + AdminLTE** para el diseño.  
Incluye un **módulo de autenticación de usuarios** con login/logout, manejo de sesiones, permisos de acceso y un **panel de administración (Dashboard)**.


## 🚀 Características principales
```python
- 🔑 Inicio de sesión con validación de usuario/contraseña (MD5 en la BD).
- 👥 Manejo de sesiones seguras con cierre de sesión (`logout`).
- 🛡️ Permisos de acceso por roles (ejemplo: `super_admin`, otros roles).
- 🗂️ Estructura **MVC** clara: separación de controladores, modelos y vistas.
- 🎨 Interfaz con **Bootstrap 3**, **Font Awesome** y **AdminLTE**.
- 📊 Dashboard inicial con bienvenida al usuario y bloques de acción.
- 📂 Menú lateral dinámico según permisos del usuario.
```
---
####🚨 Importante para tener en cuenta no cambiar el formato
```python
- 👥 El index.php en la raíz es el router principal: construye los links, inicializa los controladores y las alertas, también inicializa sesión y conexión a BD.

- 🗂️ En la carpeta core/View.php es el render: capturador único de vistas.

- 📌 Las alertas se manejan construyendo los enlaces con el index.php -> ruteador alert= || $_GET[alert]

- ✅ Ejemplo de link con alertas: header("Location: index.php?controller=Login&action=login&alert=2");
```
---
## ⚙️ Requisitos
```bash
PHP >= 8.0.30
MySQL
Extensión PDO habilitada
Servidor local como XAMPP
Navegador moderno (Chrome, Firefox, Edge)
```

---

### 🛠️ Instalación
```python
   Clonar o descargar el repositorio en tu servidor local:
   https://github.com/chonazo/proyecto-finalLP3-PHP.git
```
######    1. **Configurar la base de datos** en `config/conexion.php`:
  ```python
  php
   $server   = "localhost";
   $username = "root";
   $password = "1234";
   $database = "sysweb";
```

######   2. **Importar la base de datos**  
 ```python
- Crea la base de datos `sysweb` en MySQL.
- Importa el archivo SQL (pendiente incluirlo en `/database/sysweb.sql`).

:fa-long-arrow-right: Ejemplo en terminal:

mysql -u root -p sysweb < database/sysweb.sql
```
  ######  3. **Iniciar el servidor local**:
```python
-  Si usas PHP directamente:

     php -S localhost:8000

- O bien, iniciar Apache desde XAMPP.
```
   ######  5. **Acceder al sistema**:

	  http://localhost/sysweb
---

👤 Usuarios de prueba

Asegúrate de tener un usuario activo en la tabla `usuarios`:

| username | password (MD5) | permisos_acceso | estado  |
|----------|----------------|-----------------|---------|
| admin    | 21232f297a57a5a743894a0e4a801fc3 | super_admin | Activo |

###### 👉 **Nota:** `21232f297a57a5a743894a0e4a801fc3` corresponde a la contraseña **admin** en MD5.
---
```python
sysweb/
├── config/                     # Configuraciones del sistema
│   └── conexion.php            # Configuración de la conexión a la base de datos MySQL
├── controllers/                # Controladores del patrón MVC
│   ├── ChangeUserController.php # Controlador para cambio de contraseña
│   ├── DashboardController.php  # Controlador para el panel de administración
│   ├── LoginController.php      # Controlador para autenticación de usuarios
│   ├── MainController.php       # Controlador principal para la lógica general
│   └── [Otros controladores]    # Controladores para módulos como Usuarios, Departamentos, Productos, etc.
├── core/                       # Núcleo del sistema
│   └── View.php                # Clase para renderizado de vistas
├── database/                   # Archivos relacionados con la base de datos
│   └── sysweb.sql              # Script SQL para crear la base de datos (pendiente de incluir)
├── models/                     # Modelos del patrón MVC
│   ├── User.php                # Modelo para gestión de usuarios
│   ├── Departamento.php        # Modelo para gestión de departamentos
│   ├── Ciudad.php              # Modelo para gestión de ciudades
│   ├── Producto.php            # Modelo para gestión de productos
│   ├── Proveedor.php           # Modelo para gestión de proveedores
│   ├── Cliente.php             # Modelo para gestión de clientes
│   ├── Deposito.php            # Modelo para gestión de depósitos
│   ├── UMedida.php             # Modelo para unidades de medida
│   ├── TProducto.php           # Modelo para tipos de producto
│   └── [Otros modelos]         # Modelos adicionales para otros módulos
├── public/                     # Recursos públicos (CSS, JS, imágenes, etc.)
│   ├── css/                    # Estilos personalizados
│   ├── js/                     # Scripts JavaScript personalizados
│   ├── img/                    # Imágenes utilizadas en el proyecto
│   ├── bootstrap/              # Archivos de Bootstrap 3
│   ├── fontawesome/            # Archivos de Font Awesome
│   └── adminlte/               # Archivos de la plantilla AdminLTE
├── views/                      # Vistas del patrón MVC
│   ├── layouts/                # Plantillas base
│   │   ├── main.php            # Plantilla principal del sistema
│   │   ├── top_menu.php        # Menú superior
│   │   └── sidebar_menu.php    # Menú lateral dinámico
│   ├── dashboard/              # Vistas del panel de administración
│   │   └── dashboard.php       # Vista principal del dashboard
│   ├── usuarios/               # Vistas relacionadas con usuarios
│   │   └── CambiarContrasena.php # Vista para cambio de contraseña
│   ├── departamentos/          # Vistas para gestión de departamentos
│   ├── ciudades/               # Vistas para gestión de ciudades
│   ├── productos/              # Vistas para gestión de productos
│   ├── proveedores/            # Vistas para gestión de proveedores
│   ├── clientes/               # Vistas para gestión de clientes
│   ├── depositos/              # Vistas para gestión de depósitos
│   ├── umedidas/               # Vistas para unidades de medida
│   ├── tproductos/             # Vistas para tipos de producto
│   └── login/                  # Vistas para autenticación
│       └── login.php           # Vista para el formulario de login
├── index.php                   # Router principal y punto de entrada del sistema
└── README.md                   # Documentación del proyecto
```
---

## 📅 Cambios realizados en el proyecto

🗓️ 20/09/2025
### 1. Centralización del acceso en index.php
- Se implementó un **middleware de control de acceso**:
  - `LoginController` queda como único acceso público.
  - Si el usuario no ha iniciado sesión, es redirigido automáticamente al login con `alert=3`.
- El router ahora:
  - Verifica la existencia de los controladores solicitados.
  - Valida la sesión activa antes de permitir el acceso a otros módulos.
  - Realiza la instanciación de los controladores de manera práctica y segura.
- De esta forma, todas las acciones del usuario se centralizan en `index.php`, asegurando un único punto de entrada al sistema.

### 2. Implementación del motor de vistas (`core/View.php`)
- Se creó la carpeta `core/` con la clase `View.php`.
- `View::render()` se encarga de:
  - Renderizar la plantilla principal `main.php` (layout base del sistema).
  - Incrustar en el body el contenido dinámico de cada módulo (por ejemplo: `dashboard.php`).
- Se reestructuraron `MainController` y `DashboardController` para usar este mecanismo, eliminando los `require_once` manuales.
- Ahora las vistas reciben datos de forma controlada mediante arrays `$data`, evitando el acceso directo a variables globales como `$_SESSION`.

### 3. Diseño del Dashboard
- Se terminó el diseño de `dashboard.php`:
  - Mensaje de bienvenida al usuario.
  - Bloques de acción generados dinámicamente con bucle (`foreach`), escalables y responsive.
  - Fondo de bloques y estilos de lista personalizados.
  - Footer y enlaces correctamente posicionados. 

🗓️ 22/09/2025
### 4. Modificación del View.php
- Motor de renderizado 
  - Automáticamente llama a getUserInfo($_SESSION['id_user']) si hay sesión.
  - Captura $user y lo inyecta en todas las vistas (top_menu.php, sidebar_menu.php, etc.).
  - Renderiza la plantilla principal (Main.php) con contenido y menús.
  - Vista solo recibe variables preparadas ($user, $pageTitle, $productos, etc.).
  - Ahora Modelo nunca interactúa con la sesión ni con la vista. 
  - vista nunca toca $pdo ni hace consultas.
 
🗓️ 23/09/2025
### 5. Se agrego modulo Cambiar contraseña
- Se creo view de cambio de contraseña y lógica
  - Se realizo todas sus funciones
  - Se proceso cambio de contraseña
  - Se modifico sidebar_menu.php para agregar ítems nuevos
  - Los querys usan parámetros para evitar inyección sql y las clases siguen un enfoque MVC puro con inyección de dependencia, POO puro.
  - Se modificaron los controllers para que el render View.php se el proveedor de inicio de sesión y variables guardadas
  - Se agregaron ChangeUserController.php en el controlador y Usuarios/CambiarContrasena.php en la vista
	
 🔑 Beneficios de este enfoque
   - Seguridad: ningún controlador privado funciona sin sesión activa.
   - Centralización: toda la lógica de sesión y usuario se maneja en View::render y el router.
   - Reusabilidad: $user y menús están disponibles en todas las vistas automáticamente.
   - Simplicidad en CRUD: solo necesitas pasar $pdo al modelo; las vistas no se complican.
   - Seguimiento: de ahora en mas ya podemos empezar a terminar el proyecto

🗓️ 24/09/2025
### 6. Se agrego funciones de usuarios.
- Gestiones de usuarios
  - Se agregaron funciones básicas de gestión usuarios listados y crud
  - Se agregaron perfiles de usuario y edición 

🗓️ 25/09/2025
### 7. Se agrego funciones de Departamentos y ciudad.
- Gestiones de ciudades y departamentos
  - Se agregaron crud completo y estilos de Departamentos.
  - Se agregaron crud completo y estilos de Ciudad.
  - Se agrego descripciones en footer de Main.php para presentación.
  - Se actualizo vista de estructura en README.dm para mejor posicionamiento.

🗓️ 02/10/2025
### 8. Se agrego funciones de recuperación de contraseñas con PHPMailer.
- Recuperar contraseña olvidada
  - Validación de Email (sendResetLink).
  - Generación de Token y Expiración.
  - Guardado del Token en la BD
  - Envío del Correo (usando EmailHelper)
  - Verificación del Token (showResetForm y resetPassword).
  - Validación de Contraseñas cambiada (longitud, coincidencia) usando md5().

🗓️ 05/10/2025
### 9. Se agrego funciones de CRUD nuevos para compras.
- Se implementaron funciones CRUD completas y reportes de los siguientes módulos:
  - Depósitos
  - Unidades de Medida (UMedidas)
  - Tipos de Producto (TProductos)
  - Productos
  - Proveedores
  - Clientes

🗓️ 07/10/2025
### 10. Se agrego funciones de compras.
- Se implementaron funciones CRUD completas y reportes de compras:
  - Se implemento vista compra
  - Se implemento formulario compra
  - Se implemento modal para guardad
  - Se implemento vista stock e informe 

---

## 📖 Créditos

- 💻 **Desarrollado por:** Jorge Ibarrola (Chono Pesoa).  
- 🎨 Plantilla basada en [AdminLTE](https://adminlte.io).  
- 🗄️ Base de datos: MySQL.  
- 🛠️ Backend: PHP (PDO + MVC).

---

## 📜 Licencia

Este proyecto se distribuye bajo la licencia **MIT**.  
Eres libre de usarlo, modificarlo y adaptarlo para tus propios proyectos 🚀.