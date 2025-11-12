# Sistema de Aspersiones Sara Palma

## Características Implementadas

### 🔐 Sistema de Autenticación
- **Login diferenciado por tipo de usuario:**
  - **Fincas:** Usuario = IBM, Contraseña = Nombre de finca + IBM
  - **Administrativos/Admin:** Usuario = Cédula, Contraseña = Asignada por admin
- **Mensajes de bienvenida con SweetAlert2:**
  - Primera vez: "Bienvenido [nombre] al sistema de aspersiones de la empresa Sara Palma" (10 segundos)
  - Siguientes veces: "Bienvenido [nombre], qué bueno verte de vuelta por aquí" (6 segundos)
- **Validación de tipos de documento** (CC, CE, TI, RC, PA, NIT, PEP)

### 📊 Dashboard Diferenciado
- **Vista Admin:** Estadísticas generales, gestión completa
- **Vista Finca:** Aspersiones recientes, formularios específicos

### 🌱 Gestión de Aspersiones
- **Formulario dinámico** con validaciones en tiempo real
- **Cálculo automático de semanas** según calendario empresarial
- **Selección de productos por categorías:**
  - Control de Sigatoka
  - Fertilizantes
  - Desfoliadores
  - Control de Plagas
- **Autocompletado** de ingrediente activo y unidades
- **Validaciones:** Solo números donde corresponde, campos obligatorios marcados

### 👥 Gestión de Usuarios (Admin)
- **CRUD completo** con asignación de roles
- **Contraseñas temporales** para administrativos
- **Vista de perfil** no modificable

### 🏢 Gestión de Fincas (Admin)
- **25 fincas precargadas** con sus IBM y hectáreas
- **CRUD completo** de fincas

### 🧪 Gestión de Productos (Admin)
- **Categorización** por tipo de producto
- **CRUD completo** con ingredientes activos

### 📈 Reportes y Exportación
- **Preparado para Excel** y Power BI
- **Consultas por finca** y período

### 🗄️ Base de Datos Normalizada
- **Aplicadas las 3 primeras formas normales**
- **Relaciones bien definidas** entre entidades
- **Integridad referencial** garantizada

## Instalación

1. **Ejecutar el script de configuración:**
   ```bash
   setup.bat
   ```

2. **O manualmente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

## Estructura de la Base de Datos

### Tablas Principales
- `users` - Usuarios del sistema
- `roles` - Roles (admin, administrativo, finca)
- `document_types` - Tipos de documento
- `fincas` - Fincas de la empresa
- `product_categories` - Categorías de productos
- `products` - Productos para aspersión
- `aspersions` - Registro de aspersiones
- `aspersion_products` - Productos utilizados en cada aspersión

## Funcionalidades Técnicas

### Validaciones en Tiempo Real
- **JavaScript** para validación de campos
- **Patrones** para números y letras
- **Confirmaciones** con SweetAlert2

### Navegación Intuitiva
- **Breadcrumbs** visuales en la navegación
- **Indicadores** de sección actual
- **Menús contextuales** según rol

### Seguridad
- **Middleware** de autenticación
- **Middleware** de autorización por roles
- **Validación** de permisos en cada acción

## Próximas Funcionalidades
- Integración con Power BI
- Exportación a Excel
- Calendario empresarial personalizado
- Notificaciones automáticas
- Reportes avanzados

## Tecnologías Utilizadas
- **Laravel 11**
- **Bootstrap 5**
- **SweetAlert2**
- **Font Awesome**
- **SQLite** (configurable a MySQL/PostgreSQL)

## Soporte
Sistema desarrollado para Sara Palma - Gestión de Aspersiones