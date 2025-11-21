# Guía de Instalación de Extensiones SQL Server para PHP

## Problema Detectado
Tu instalación de PHP no tiene las extensiones necesarias para conectarse a SQL Server:
- ❌ `pdo_sqlsrv` - No instalada
- ❌ `sqlsrv` - No instalada

## Solución

### Opción 1: Descargar Extensiones Manualmente (Recomendado)

1. **Descarga los drivers de Microsoft**
   - Ve a: https://github.com/microsoft/msphpsql/releases
   - Descarga la última versión (ejemplo: `Windows-8.2.zip` o superior)

2. **Identifica tu versión de PHP**
   - Versión: PHP 8.4.7
   - Arquitectura: x64
   - Thread Safety: NTS (Non-Thread Safe)

3. **Extrae los archivos correctos**
   - Busca en el ZIP los archivos:
     - `php_pdo_sqlsrv_84_nts_x64.dll`
     - `php_sqlsrv_84_nts_x64.dll`
   
4. **Copia los archivos**
   - Copia ambos archivos a: `C:\laragon\bin\php\php-8.4.7-nts-Win32-vs17-x64\ext\`

5. **Edita php.ini**
   - Abre: `C:\laragon\bin\php\php-8.4.7-nts-Win32-vs17-x64\php.ini`
   - Agrega estas líneas al final de la sección de extensiones:
   ```ini
   extension=php_pdo_sqlsrv_84_nts_x64.dll
   extension=php_sqlsrv_84_nts_x64.dll
   ```

6. **Reinicia Laragon**
   - Detén todos los servicios
   - Cierra Laragon
   - Abre Laragon de nuevo
   - Inicia los servicios

### Opción 2: Usar PHP 8.2 (Ya instalado en Laragon)

Si prefieres no instalar las extensiones, puedes cambiar a PHP 8.2 que ya tienes instalado:

1. En Laragon, ve a: **Menú → PHP → Version → php-8.2.28**
2. Reinicia los servicios
3. Descarga las extensiones para PHP 8.2 (mismo proceso que arriba pero con archivos `_82_`)

### Opción 3: Alternativa Temporal - Usar MySQL

Si quieres probar la aplicación rápidamente mientras instalas SQL Server:

1. Crea una base de datos MySQL en Laragon
2. Cambia en `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=meserospro2_test
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Ejecuta las migraciones para crear las tablas
4. Inserta datos de prueba

**NOTA**: Esta opción es solo para pruebas. El objetivo final es usar SQL Server.

## Verificar Instalación

Después de instalar las extensiones, ejecuta:

```bash
php -m | findstr sql
```

Deberías ver:
```
pdo_sqlsrv
sqlsrv
```

## Enlaces Útiles

- Drivers oficiales: https://github.com/microsoft/msphpsql/releases
- Documentación: https://docs.microsoft.com/en-us/sql/connect/php/
- Requisitos del sistema: https://docs.microsoft.com/en-us/sql/connect/php/system-requirements-for-the-php-sql-driver

## ¿Necesitas Ayuda?

Si tienes problemas, avísame y te ayudo con el proceso específico para tu configuración.
