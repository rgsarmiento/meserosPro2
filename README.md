# MeserosPro2 - Aplicación Web para Meseros

Aplicación web responsive desarrollada en Laravel 12 que se conecta directamente a la base de datos SQL Server de Nodo para gestión de pedidos en restaurantes.

## Características

- ✅ Conexión directa a SQL Server (sin sincronización)
- ✅ Interfaz Mobile-First optimizada para tablets y móviles
- ✅ Tema oscuro moderno
- ✅ Selección de mesero
- ✅ Gestión de mesas
- ✅ Menú de productos por categorías
- ✅ Carrito de compras interactivo
- ✅ Envío de pedidos en tiempo real a Nodo

## Requisitos Previos

1. **Laragon** instalado y funcionando
2. **PHP 8.2+** con las extensiones:
   - `pdo_sqlsrv`
   - `sqlsrv`
3. **SQL Server** con la base de datos de Nodo
4. **Node.js** (para compilar assets)

## Instalación

### 1. Verificar Extensiones de PHP

Abre el archivo `php.ini` de Laragon y asegúrate de que estas líneas estén descomentadas:

```ini
extension=pdo_sqlsrv
extension=sqlsrv
```

Si no tienes estas extensiones, descárgalas de:
https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server

### 2. Configurar Base de Datos

Copia el archivo `.env.sqlserver` a `.env` y edita los valores:

```bash
copy .env.sqlserver .env
```

Edita `.env` y configura tu conexión a SQL Server:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=NombreDeTuBaseDeDatos
DB_USERNAME=sa
DB_PASSWORD=TuPassword
```

### 3. Generar Application Key

```bash
php artisan key:generate
```

### 4. Compilar Assets

```bash
npm install
npm run build
```

### 5. Iniciar Servidor

Desde Laragon, simplemente accede a:
```
http://meserospro2.test
```

O usa el servidor de desarrollo de Laravel:
```bash
php artisan serve
```

## Estructura de la Base de Datos

La aplicación utiliza las siguientes tablas de SQL Server:

### Lectura (Read-Only)
- `Productos` - Catálogo de productos
- `Categorias` - Categorías de productos
- `PuestosConsumo` - Mesas/Puestos
- `Usuarios` - Meseros/Usuarios

### Escritura
- `ComandaOrdenes` - Órdenes/Pedidos
- `ComandaOrdenDetalles` - Detalles de las órdenes

## Flujo de Uso

1. **Login**: El mesero selecciona su usuario
2. **Selección de Mesa**: Elige la mesa para tomar el pedido
3. **Menú**: Navega por categorías y agrega productos al carrito
4. **Carrito**: Revisa el pedido, ajusta cantidades y agrega observaciones
5. **Envío**: Confirma el pedido que se registra inmediatamente en SQL Server
6. **Nodo**: La aplicación Nodo detecta el nuevo pedido e imprime la comanda

## Ventajas sobre el Sistema Anterior

| Anterior (MySQL) | Actual (SQL Server Directo) |
|-----------------|----------------------------|
| Sincronización cada 5 segundos | Tiempo real |
| Doble base de datos | Una sola fuente de verdad |
| Pérdida de comandas | Sin pérdidas |
| Sincronización manual de precios | Precios siempre actualizados |
| Diseño básico | Interfaz moderna y atractiva |

## Personalización

### Cambiar Colores
Edita `resources/views/layouts/app.blade.php` y las vistas para cambiar los colores del tema.

### Agregar Campos
Si necesitas campos adicionales en las órdenes, modifica:
- `app/Models/Orden.php`
- `app/Models/OrdenDetalle.php`
- `app/Http/Controllers/MeseroController.php`

## Soporte

Para problemas o preguntas, contacta al equipo de desarrollo.

## Licencia

Propiedad de [Tu Empresa]
