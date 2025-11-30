# 🎮 Batalla Naval - Juego en Línea

Un juego de batalla naval interactivo desarrollado en **PHP**, **JavaScript** y **MySQL**. Juega contra la CPU en un tablero personalizable con diferentes tamaños y tipos de barcos.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Uso](#-uso)

---

## ✨ Características

✅ **Registro e inicio de sesión** - Cuentas de usuario con contraseñas hasheadas
✅ **Configuración personalizable** - Elige tamaño del tablero (10x10, 15x10, 10x20, 15x15)
✅ **Posicionamiento interactivo** - Coloca tus barcos manualmente
✅ **IA CPU inteligente** - La máquina rastrea objetivos y mejora su estrategia
✅ **Sistema de pistas** - Recibe ayuda durante el juego
✅ **Ranking de jugadores** - Top 3 partidas más rápidas
✅ **Historial de partidas** - Guarda resultado, duración y fecha
✅ **Tiempo real** - Cronómetro durante la partida
✅ **Interfaz responsiva** - Diseño moderno y accesible

---

## 🛠️ Requisitos

- **PHP** 7.4+
- **MySQL** 5.7+
- **Servidor web** (Apache, Nginx)
- **Navegador moderno** (Chrome, Firefox, Edge, Safari)
- Stack recomendado: **WAMP**, **LAMP** o **Docker**

---

## 📥 Instalación

### 1 Clonar o descargar el repositorio

```bash
git clone https://github.com/anabotha/batallaNaval.git
cd batallaNaval
```



### Iniciar servidor

**Con WAMP/XAMPP:**
1. Coloca la carpeta `batallaNaval` en `C:/wamp64/www/` (o `C:/xampp/htdocs/`)
2. Inicia Apache + MySQL
3. Accede a `http://localhost/Final/batallaNaval/index.php`

**Con PHP built-in:**
```bash
cd batallaNaval
php -S localhost:8000
# Accede a http://localhost:8000
```

---

## 🎮 Uso

### 1. Registro / Login
- Accede a `loginView.php`
- Crea una cuenta (nickname único, email válido, fecha nacimiento, contraseña)
- O inicia sesión con credenciales existentes

### 2. Configurar Partida
- Selecciona el tamaño del tablero
- Elige número de cada tipo de barco (submarino, destructor, acorazado, portaviones)

### 3. Posicionar Barcos
- Coloca tus barcos en el tablero 
- Confirma y comienza la partida

### 4. Jugar
- Haz clic en celdas del tablero enemigo para atacar
- Usa **Pista** para recibir ayuda (solo una por partida)
- Observa los turnos alternados: Jugador → CPU
- Gana hundiendo toda la flota enemiga

### 5. Ver Resultado
- Duración de la partida
- Ranking top 5 partidas más rápidas

---

## 🔐 Seguridad

### ✅ Implementado
- ✅ Hash de contraseñas (`password_hash()`)
- ✅ Validación email
- ✅ Prepared statements (parcial)


---

## 🛠️ Notas Técnicas

### Tecnologías
- **Backend:** PHP (POO + procedural)
- **Frontend:** HTML5, CSS3, JavaScript
- **BD:** MySQL con MySQLi
- **Sesiones:** `$_SESSION` + `sessionStorage` del navegador

### Decisiones de Diseño
- **sessionStorage** para datos de juego (flota, posiciones, barcos) - no persiste entre sesiones
- **Cookies** para usuario logueado (temporal)
- **BD** para historial de partidas e información de usuario
- **IA CPU:** Implementa búsqueda de patrones tras primer impacto

---



## 📞 Soporte

- **Issues:** [GitHub Issues](https://github.com/anabotha/batallaNaval/issues)
- **Email:** anabotha@example.com
<!-- - **Documentación:** Ver [ESTRUCTURA.md](ESTRUCTURA.md) -->

---


---

## 👨‍💻 Autor

**Ana Botha** - [@anabotha](https://github.com/anabotha)

---

**Última actualización:** 30/11/2025
**Versión:** 0.2.0 (Beta)