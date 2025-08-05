# Dashboard Ciencia de Datos – Laravel

Dashboard interactivo de visualización y análisis basado en tus propias tablas y datos MySQL. Incluye métricas clave, gráficas, mapas, análisis estadístico y un UI/UX moderno tipo SaaS.

---

## Características

- Dashboard responsive, sidebar moderno
- Visualización de KPIs clave (usuarios, préstamos, productos, compañías)
- Gráficas de series de tiempo, barras, pastel y dispersión
- Mapa interactivo con ubicación de usuarios
- Estadísticas y análisis con regresión lineal simple (usando PHP-ML)
- Aprovecha múltiples tablas: usuarios, préstamos, productos, inversiones, prospectos, artículos, garantías, referencias comerciales y más

---

## Requisitos

- PHP >= 8.0
- Composer >= 2.x
- Node.js >= 14 (para compilar assets si lo requieres)
- MySQL >= 5.7 (o compatible)
- Extensiones PHP recomendadas: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `bcmath`
- [php-ml/php-ml](https://github.com/php-ai/php-ml) (para regresiones)

---

## Instalación

1. **Clona el repositorio:**
    ```bash
    git clone https://github.com/TU_USUARIO/datascience-laravel.git
    cd datascience-laravel
    ```

2. **Instala dependencias de Composer:**
    ```bash
    composer install
    ```

3. **Copia y edita el archivo `.env`:**
    ```bash
    cp .env.example .env
    ```
    > **Configura tus credenciales de base de datos MySQL:**
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=costmexico_adminPFCash   # Cambia por el nombre real
    DB_USERNAME=costmexico_adminCash
    DB_PASSWORD=tu_contraseña
    ```

4. **Genera la clave de la aplicación:**
    ```bash
    php artisan key:generate
    ```

5. **Instala dependencias de NPM (opcional, solo si quieres compilar assets):**
    ```bash
    npm install && npm run dev
    ```

6. **Instala PHP-ML para regresión (si no lo tienes):**
    ```bash
    composer require php-ai/php-ml
    ```

7. **Ejecuta las migraciones (solo si lo requieres, en este caso ya tienes la BD cargada):**
    ```bash
    php artisan migrate
    ```
    > Si solo usarás la BD existente, puedes saltar este paso.

8. **Levanta el servidor:**
    ```bash
    php artisan serve
    ```

9. **Abre tu navegador en:**  
    [http://localhost:8000](http://localhost:8000)

---

## Notas

- El dashboard se conecta y visualiza automáticamente la información de tus tablas existentes.
- Si cambias la estructura de la base de datos, asegúrate de actualizar los modelos Eloquent.
- Para personalizar visualizaciones/agregar nuevas métricas, edita el controlador `DataScienceController.php` y la vista `dashboard.blade.php`.
- Incluye soporte para Leaflet.js (mapas) y Chart.js (gráficas).

---

## Estructura principal del proyecto

