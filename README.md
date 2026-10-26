# 🔐 Inicio de Sesión con XAMPP, PHP, MySQL y Android

Sistema de **registro e inicio de sesión** para una app Android que se comunica
con una API REST en **PHP** y una base de datos **MySQL** ejecutadas localmente con **XAMPP**.

```
┌──────────────┐   JSON / HTTP   ┌───────────────┐   PDO   ┌─────────┐
│ App Android  │ ──────────────► │  API PHP      │ ──────► │  MySQL  │
│ (Java+Volley)│ ◄────────────── │  (XAMPP/Apache)│ ◄────── │         │
└──────────────┘                 └───────────────┘         └─────────┘
```

## 📁 Estructura

```
├── backend/            API en PHP
│   ├── config/db.php   Conexión PDO a MySQL
│   └── api/            register.php, login.php, helpers.php
├── database/schema.sql Script de la base de datos
└── android/            Proyecto Android Studio (Java)
```

## ✅ Requisitos

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)
- [Android Studio](https://developer.android.com/studio) (Hedgehog o superior)
- JDK 17 (incluido con Android Studio)

## 🚀 Instalación

### 1. Base de datos
1. Abre el **XAMPP Control Panel** e inicia **Apache** y **MySQL**.
2. Entra a `http://localhost/phpmyadmin`.
3. Pestaña **Importar** → selecciona `database/schema.sql` → **Continuar**.

### 2. Backend
1. Copia la carpeta `backend` dentro de `C:\xampp\htdocs\` y renómbrala a **`login_android`**
   (en Linux/macOS: `/opt/lampp/htdocs/login_android`).
2. Revisa las credenciales en `config/db.php` (por defecto usuario `root`, sin contraseña).
3. Prueba en el navegador: `http://localhost/login_android/api/login.php`
   → debe responder un JSON con `"Método no permitido"`.

### 3. Android
1. Abre la carpeta `android/` con **Android Studio** y espera la sincronización de Gradle.
2. Ajusta la URL del servidor en
   `app/src/main/java/com/example/loginapp/Constants.java`:
   - **Emulador:** `http://10.0.2.2/login_android/api/` (valor por defecto)
   - **Dispositivo físico:** `http://TU_IP_LOCAL/login_android/api/`
     (ej. `192.168.1.10`; el celular y la PC deben estar en la misma red Wi‑Fi y
     el firewall debe permitir Apache).
3. Ejecuta la app ▶️.

> Si Android Studio no genera el *Gradle Wrapper*, usa **File → Sync Project with Gradle Files**.

## 🔌 Endpoints

| Método | Ruta                | Body JSON                              | Respuesta |
|--------|---------------------|----------------------------------------|-----------|
| POST   | `/api/register.php` | `{"name","email","password"}`          | `{"success":true,"message":"..."}` |
| POST   | `/api/login.php`    | `{"email","password"}`                 | `{"success":true,"user":{id,name,email}}` |

Ejemplo con cURL:

```bash
curl -X POST http://localhost/login_android/api/register.php \
  -H "Content-Type: application/json" \
  -d '{"name":"Ana","email":"ana@mail.com","password":"123456"}'
```

## 🛡️ Seguridad implementada

- Contraseñas con `password_hash()` (bcrypt) y `password_verify()`.
- Consultas preparadas con **PDO** (previene inyección SQL).
- Validación de datos en servidor y en el cliente.

## 🔧 Mejoras sugeridas

- Usar **HTTPS** en producción y quitar `usesCleartextTraffic`.
- Tokens **JWT** para sesiones seguras.
- Recuperación de contraseña por correo.
- Limitar intentos de login (rate limiting).

## 📄 Licencia

MIT — ver [LICENSE](LICENSE).

## ⬆️ Subir a GitHub

```bash
git init
git add .
git commit -m "Proyecto inicial: login con PHP, MySQL y Android"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/android-php-mysql-login.git
git push -u origin main
```
