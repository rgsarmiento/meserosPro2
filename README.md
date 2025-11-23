# MeserosPro2 🍽️

Sistema de gestión de pedidos para meseros desarrollado en Laravel 12, diseñado para conectarse directamente a SQL Server eliminando problemas de sincronización.

## 🌟 Características

- ✅ **Conexión directa a SQL Server** - Sin sincronización, pedidos en tiempo real
- 📱 **Interfaz móvil responsive** - Optimizada para tablets y smartphones
- 🎨 **Diseño moderno** - UI con gradientes, tema oscuro y animaciones
- 👥 **Multi-usuario** - Múltiples meseros pueden trabajar simultáneamente
- 📋 **Historial compartido** - Todos los meseros pueden ver el historial completo
- 🔍 **Filtros inteligentes** - Filtrar historial por mesa y buscar usuarios
- ⏱️ **Tiempo de ocupación** - Visualiza cuánto tiempo lleva ocupada cada mesa
- 💬 **Observaciones** - Agrega notas especiales a cada producto
- 🎯 **Modal de selección** - Ajusta cantidad y observaciones antes de agregar al pedido
- 💰 **Precios personalizados** - Productos con precio $1 permiten ingresar precio personalizado
- 🔔 **Alertas sonoras** - Notificación en cocina cuando llegan nuevos pedidos
- 🚫 **Prevención de duplicados** - Protección contra pedidos duplicados por mala conexión

## 📋 Requisitos Previos

- PHP 8.2 o superior
- Laragon (o servidor web con PHP)
- SQL Server 2016 o superior
- Extensiones PHP: `pdo_sqlsrv`, `sqlsrv`
- Node.js 18+ y npm
- Composer 2.x

## 🚀 Instalación Paso a Paso

### 1. Instalar ODBC Driver for SQL Server

Descarga e instala el driver ODBC desde Microsoft:

**[Download ODBC Driver for SQL Server](https://learn.microsoft.com/en-us/sql/connect/odbc/download-odbc-driver-for-sql-server?view=sql-server-ver17)**

- Descarga la versión más reciente (ODBC Driver 18 for SQL Server)
- Ejecuta el instalador y sigue las instrucciones
- Reinicia tu computadora después de la instalación

### 2. Configurar PHP con extensiones SQL Server

**Opción A: Usar carpeta PHP incluida (Recomendado)**

El proyecto incluye una carpeta `php-8.2.28-nts-Win32-vs16-x64` que ya contiene las DLL necesarias para SQL Server.

1. Copia esta carpeta a `C:\laragon\bin\php\`
2. En Laragon, selecciona esta versión de PHP
3. Reinicia Laragon

**Opción B: Configurar manualmente**

Si prefieres usar tu propia instalación de PHP:

1. Descarga los drivers desde: https://github.com/microsoft/msphpsql/releases
2. Busca los archivos para PHP 8.2 NTS x64:
   - `php_pdo_sqlsrv_82_nts_x64.dll`
   - `php_sqlsrv_82_nts_x64.dll`
3. Cópialos a la carpeta `ext` de tu instalación de PHP
4. Edita `php.ini` y agrega:
   ```ini
   extension=php_pdo_sqlsrv_82_nts_x64.dll
   extension=php_sqlsrv_82_nts_x64.dll
   ```
5. Reinicia el servidor web

### 3. Configurar SQL Server

Abre **SQL Server Configuration Manager** y configura:

1. **Habilitar TCP/IP:**
   - Ve a: SQL Server Network Configuration → Protocols for [TU_INSTANCIA]
   - Haz clic derecho en **TCP/IP** → Enable

2. **Configurar Puerto:**
   - Doble clic en **TCP/IP** → Pestaña **IP Addresses**
   - Desplázate hasta **IPAll**
   - Configura:
     - **TCP Port:** `1433`
     - **TCP Dynamic Ports:** (dejar vacío)

3. **Reiniciar SQL Server:**
   - Ve a: SQL Server Services
   - Clic derecho en **SQL Server ([TU_INSTANCIA])** → Restart

### 4. Clonar el repositorio

```bash
git clone https://github.com/rgsarmiento/meserosPro2.git
cd meserosPro2
```

### 5. Instalar dependencias

```bash
composer install
npm install
```

### 6. Configurar base de datos

Copia el archivo de configuración de ejemplo:

```bash
copy .env.sqlserver .env
```

Edita el archivo `.env` con tus credenciales de SQL Server:

```env
DB_CONNECTION=sqlsrv
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=nodo
DB_USERNAME=sas
DB_PASSWORD=admin
```

### 7. Generar clave de aplicación

```bash
php artisan key:generate
```

### 8. Ejecutar migraciones (Opcional)

Si necesitas crear las tablas desde cero:

```bash
php artisan migrate
```

> **Nota:** Si ya tienes una base de datos existente con las tablas necesarias, puedes omitir este paso.

### 9. Compilar assets

```bash
npm run build
```

### 10. Configurar Apache Virtual Host (Laragon)

Para acceder a la aplicación desde otros dispositivos en la red local:

1. **Abrir configuración de Apache:**
   - Clic derecho en el icono de Laragon
   - Apache → httpd.conf

2. **Agregar Virtual Host:**
   
   Busca la sección de Virtual Hosts y agrega:

   ```apache
   # Virtual hosts
   <VirtualHost *:80>
       DocumentRoot "C:/laragon/www/meserosPro2/public"
       ServerName meserosPro2.local
       <Directory "C:/laragon/www/meserosPro2/public">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

   > **Nota:** Si Apache usa un puerto diferente (ej: 8080), cambia `*:80` por `*:8080`

3. **Guardar y reiniciar Apache:**
   - Guarda el archivo `httpd.conf`
   - En Laragon: Apache → Reload

4. **Acceder a la aplicación:**
   
   - Desde otros dispositivos: `http://[IP_DEL_SERVIDOR]` (ej: `http://192.168.1.100`)

**Alternativa con php artisan serve:**

Si prefieres usar el servidor de desarrollo de Laravel:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Acceso:
- Servidor: `http://localhost:8000`
- Otros dispositivos: `http://[IP_DEL_SERVIDOR]:8000`

## 📊 Estructura de Base de Datos

El sistema utiliza las siguientes tablas de SQL Server:

- **Usuarios** - Meseros del sistema
- **PuestosConsumo** - Mesas/puestos de consumo
- **Productos** - Catálogo de productos
- **Categorias** - Categorías de productos
- **ComandaOrdenes** - Órdenes/pedidos
- **ComandaOrdenDetalles** - Detalles de cada orden

## 🎯 Flujo de Uso

1. **Login** - Selecciona tu usuario de la lista de meseros (con búsqueda por nombre)
2. **Selección de Mesa** - Elige la mesa para tomar el pedido (ordenadas numéricamente)
3. **Menú** - Navega por categorías y busca productos por nombre o código
4. **Agregar Productos** - Click en producto → Modal para cantidad y observaciones
5. **Precios Personalizados** - Productos de $1 permiten ingresar precio personalizado
6. **Revisar Pedido** - Click en "Ver Pedido" para revisar el carrito
7. **Enviar** - Confirma y envía el pedido a la cocina (con protección anti-duplicados)
8. **Cocina** - Vista en tiempo real con alerta sonora para nuevos pedidos
9. **Historial** - Consulta órdenes anteriores filtradas por mesa

## 🎨 Características de Diseño

- **Gradientes modernos** - Indigo, purple, pink, orange
- **Tema oscuro** - Optimizado para uso prolongado
- **Grid responsive** - Hasta 6 columnas en pantallas grandes
- **Animaciones suaves** - Hover effects y transiciones
- **Badges visuales** - Cantidades destacadas con gradientes
- **Estados con colores** - Verde (Libre), Rojo (Ocupada)
- **Modales estilizados** - Mensajes de éxito y advertencia con diseño profesional
- **Iconos intuitivos** - Llama de fuego para cocina, check para éxito, advertencia para errores

## 🔧 Funcionalidades Avanzadas

### Búsqueda Inteligente
- **Login:** Buscar usuarios por nombre
- **Menú:** Buscar productos por nombre, código o categoría (mín. 3 caracteres)

### Precios Personalizados
- Productos con precio $1 muestran campo para ingresar precio personalizado
- Validación de precio válido antes de agregar al carrito

### Protección Anti-Duplicados
- Previene envío múltiple de pedidos por mala conexión
- Timeout de 30 segundos para conexiones lentas
- Indicadores visuales durante el envío

### Alertas en Cocina
- Sonido tipo sirena cuando llegan nuevos pedidos
- Actualización automática cada 10 segundos
- Observaciones destacadas visualmente

### Ordenamiento Natural
- Mesas ordenadas numéricamente (Mesa 1, 2, 3... no 1, 10, 11, 2)
- Productos ordenados alfabéticamente por categoría

## 🐛 Solución de Problemas

### No se ven los estilos

```bash
npm run build
# Luego recarga con Ctrl+F5
```

### Error de conexión a SQL Server

- Verifica que las extensiones `pdo_sqlsrv` y `sqlsrv` estén instaladas
- Confirma que ODBC Driver esté instalado
- Verifica las credenciales en `.env`
- Asegúrate de que SQL Server esté corriendo
- Confirma que TCP/IP esté habilitado en puerto 1433

### Productos no aparecen

Verifica que los productos tengan:
- `PrecioVenta > 0`
- `SeVende = true`
- `Activo = true`

### No se escucha el sonido en cocina

- Haz clic en cualquier parte de la página de cocina al menos una vez (política de autoplay del navegador)
- Verifica que el volumen del dispositivo esté activado

### Pedidos duplicados

- La aplicación ya incluye protección anti-duplicados
- Si persiste, verifica la conexión de red
- Revisa la consola del navegador para errores

## 🔐 Seguridad

**IMPORTANTE para producción:**

1. Cambia `APP_ENV=production` en `.env`
2. Desactiva `APP_DEBUG=false`
3. Configura SSL/HTTPS
4. Protege las credenciales de base de datos
5. Implementa rate limiting
6. Configura firewall para SQL Server

## 📝 Changelog

### v2.0.0 (2025-11-22)

- ✅ Búsqueda de usuarios en login
- ✅ Búsqueda de productos por código
- ✅ Precios personalizados para productos de $1
- ✅ Mensajes de éxito/error estilizados
- ✅ Protección contra pedidos duplicados
- ✅ Alerta sonora en cocina
- ✅ Ordenamiento natural de mesas
- ✅ Mejoras de UI responsive
- ✅ Icono de llama para cocina
- ✅ Total acumulado diferenciado por color

### v1.0.0 (2025-11-21)

- ✅ Conexión directa a SQL Server
- ✅ Interfaz responsive mobile-first
- ✅ Sistema de pedidos con modal
- ✅ Historial compartido entre meseros
- ✅ Filtro por mesa en historial
- ✅ Productos ordenados alfabéticamente
- ✅ Tiempo de ocupación en mesas
- ✅ Observaciones editables
- ✅ Timezone Bogotá (America/Bogota)

## 👨‍💻 Autor

**Robert Sarmiento**

## 📄 Licencia

Este proyecto es privado y propietario.

## 🤝 Contribuciones

Para contribuir al proyecto:

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📞 Soporte

Para soporte o consultas, contacta al administrador del sistema.

---

**MeserosPro2** - Sistema de Gestión de Pedidos para Restaurantes 🍽️
