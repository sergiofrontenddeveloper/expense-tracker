# Expense Tracker 💰

¡Bienvenido a **Expense Tracker**! Una aplicación web full-stack diseñada para la gestión de finanzas personales, control de ingresos y gastos, y monitorización de presupuestos mensuales en tiempo real.

Este proyecto ha sido desarrollado como parte de mi progreso en el desarrollo web, aplicando buenas prácticas de arquitectura MVC, bases de datos relacionales y peticiones asíncronas.

---

## 🚀 Características Principales

* **Autenticación Segura:** Registro de usuarios, inicio de sesión y cierre de sesión protegido con el middleware de Laravel.
* **Dashboard Interactivo:** Panel de control con tarjetas de resumen (Balance Total, Gastos, Ingresos y Ahorros) y gráficos visuales dinámicos.
* **Gráficos en Tiempo Real:** Integración de **Chart.js** con gráficos de barras y líneas para comparar la evolución mensual de ingresos frente a gastos.
* **Control de Presupuesto Asíncrono:** Input en la barra de navegación que permite actualizar el límite de gasto mensual mediante **Fetch API (AJAX)** sin recargar la página.
* **Sistema de Notificaciones:** Alertas automáticas integradas en la barra superior para avisar al usuario cuando se acerca o supera su límite mensual.
* **Gestión de Archivos:** Panel para subir, almacenar y descargar archivos o facturas enlazadas a los movimientos financieros.

---

## 🛠️ Stack Tecnológico

* **Backend:** PHP 8.x | Laravel (Arquitectura MVC, Migraciones, Eloquent ORM)
* **Frontend:** Blade Templates | Bootstrap 5 | JavaScript (AJAX / Fetch API)
* **Gráficos:** Chart.js
* **Base de Datos:** MySQL

---

## 📦 Instalación y Configuración en Local

Si deseas clonar el proyecto y probarlo en tu entorno local, sigue estos pasos:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/tu-usuario/nombre-de-tu-repositorio.git](https://github.com/tu-usuario/nombre-de-tu-repositorio.git)
   cd nombre-de-tu-repositorio


## 📦 Instalar dependencias de PHP y Javascript

composer install
npm install && npm run dev


## 📦 Configurar el entorno

cp .env.example .env


## 📦 Generar la clave de la aplicación

php artisan key:generate


## 📦 Ejecutar las migraciones

php artisan migrate


## 📦 Iniciar el servidor local

php artisan serve



