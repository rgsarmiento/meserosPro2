# MeserosPro2 🍽️

Sistema de gestión de pedidos para meseros desarrollado en Laravel 12, diseñado para conectarse directamente a SQL Server eliminando problemas de sincronización.

## 🌟 Características

- ✅ **Conexión directa a SQL Server** - Sin sincronización, pedidos en tiempo real
- 📱 **Interfaz móvil responsive** - Optimizada para tablets y smartphones
- 🎨 **Diseño moderno** - UI con gradientes, tema oscuro y animaciones
- 👥 **Multi-usuario** - Múltiples meseros pueden trabajar simultáneamente
- 📋 **Historial compartido** - Todos los meseros pueden ver el historial completo
- 🔍 **Filtros inteligentes** - Filtrar historial por mesa
- ⏱️ **Tiempo de ocupación** - Visualiza cuánto tiempo lleva ocupada cada mesa
- 💬 **Observaciones** - Agrega notas especiales a cada producto
- 🎯 **Modal de selección** - Ajusta cantidad y observaciones antes de agregar al pedido

## 📋 Requisitos Previos

- PHP 8.2 o superior
- Laragon (o servidor web con PHP)
- SQL Server
- Extensiones PHP: `pdo_sqlsrv`, `sqlsrv`
- Node.js y npm
- Composer

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/rgsarmiento/meserosPro2.git
cd meserosPro2
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar base de datos

Copia el archivo de configuración de ejemplo:

```bash
copy .env.sqlserver .env
```

Edita el archivo `.env` con tus credenciales de SQL Server:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=NombreDeTuBaseDeDatos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Compilar assets

```bash
npm run build
```

### 6. Iniciar servidor

```bash
php artisan serve
```

Accede a la aplicación en: `http://localhost:8000`

## 📊 Estructura de Base de Datos

El sistema utiliza las siguientes tablas de SQL Server:

- **Usuarios** - Meseros del sistema
- **PuestosConsumo** - Mesas/puestos de consumo
- **Productos** - Catálogo de productos
- **Categorias** - Categorías de productos
- **ComandaOrdenes** - Órdenes/pedidos
- **ComandaOrdenDetalles** - Detalles de cada orden

## 🎯 Flujo de Uso

1. **Login** - Selecciona tu usuario de la lista de meseros
2. **Selección de Mesa** - Elige la mesa para tomar el pedido
3. **Menú** - Navega por categorías y selecciona productos
4. **Agregar Productos** - Click en producto → Modal para cantidad y observaciones
5. **Revisar Pedido** - Click en "Ver Pedido" para revisar el carrito
6. **Enviar** - Confirma y envía el pedido a la cocina
7. **Historial** - Consulta órdenes anteriores filtradas por mesa

## ⚙️ Configuración de Extensiones PHP (SQL Server)

Si no tienes las extensiones de SQL Server instaladas:

1. Descarga los drivers desde: https://github.com/microsoft/msphpsql/releases
2. Busca los archivos para tu versión de PHP (ej: `php_pdo_sqlsrv_82_nts_x64.dll`)
3. Cópialos a la carpeta `ext` de tu instalación de PHP
4. Edita `php.ini` y agrega:
   ```ini
   extension=php_pdo_sqlsrv_82_nts_x64.dll
   extension=php_sqlsrv_82_nts_x64.dll
   ```
5. Reinicia el servidor web

Ver guía completa en: [INSTALL_SQLSRV.md](INSTALL_SQLSRV.md)

## 🎨 Características de Diseño

- **Gradientes modernos** - Indigo, purple, pink
- **Tema oscuro** - Optimizado para uso prolongado
- **Grid responsive** - Hasta 6 columnas en pantallas grandes
- **Animaciones suaves** - Hover effects y transiciones
- **Badges visuales** - Cantidades destacadas con gradientes
- **Estados con colores** - Verde (Libre), Rojo (Ocupada)

## 🔧 Personalización

### Cambiar colores

Edita los archivos en `resources/views/` y modifica las clases de TailwindCSS.

### Agregar campos personalizados

1. Modifica los modelos en `app/Models/`
2. Actualiza los controladores en `app/Http/Controllers/`
3. Ajusta las vistas en `resources/views/`

### Modificar límites

- **Historial**: Cambia `take(100)` en `MeseroController@historial`
- **Productos por categoría**: Ajusta el grid en `menu.blade.php`

## 📱 PWA (Progressive Web App)

La aplicación incluye meta tags PWA para instalación en dispositivos móviles:

- Icono de aplicación
- Tema de color
- Modo standalone

## 🔐 Seguridad

**IMPORTANTE para producción:**

1. Cambia `APP_ENV=production` en `.env`
2. Desactiva `APP_DEBUG=false`
3. Implementa autenticación robusta (usuario/contraseña)
4. Configura SSL/HTTPS
5. Protege las credenciales de base de datos
6. Implementa rate limiting

## 🐛 Solución de Problemas

### No se ven los estilos

```bash
npm run build
# Luego recarga con Ctrl+F5
```

### Error de conexión a SQL Server

- Verifica que las extensiones `pdo_sqlsrv` y `sqlsrv` estén instaladas
- Confirma las credenciales en `.env`
- Asegúrate de que SQL Server esté corriendo

### Productos no aparecen

Verifica que los productos tengan:
- `PrecioVenta > 0`
- `SeVende = true`
- `Activo = true`

## 📝 Changelog

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
- ✅ Precio total en detalles de orden

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
