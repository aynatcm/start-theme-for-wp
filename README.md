# 🚀 Start Theme for WordPress (by @aynatcm)

> 🎨 Un generador de temas WordPress moderno con Webpack, Sass, Vue y ACF listo para trabajar.

Este CLI te permite crear un nuevo tema WordPress con una sola línea de comando, personalizado con tu nombre, dominio local y autor, usando una estructura profesional preparada para desarrollo moderno.

---

## 🧩 ¿Qué incluye?

✅ Webpack configurado (producción y desarrollo)  
✅ Sass + PostCSS + Autoprefixer  
✅ Vue 3 con setup listo  
✅ ACF Pro ready  
✅ Builder modular (JS/CSS organizados)  
✅ Animaciones, componentes reutilizables  
✅ Compatible con Local by Flywheel  
✅ Permite SVG, desactiva el editor Gutenberg y HTML por defecto

---

## ⚙️ Requisitos

- Node.js `>= 18` (ideal v22)
- Instalación de WordPress ya existente
- LocalWP, Laragon u otro entorno con acceso a `wp-config.php`

---

## 🚀 ¿Cómo usarlo?

### 1. Crear el tema con `npx`
```bash
npx github:aynatcm/start-theme-for-wp
```
Sigue las preguntas del CLI:

Nombre del tema

Dominio local (ej. mitema.local)

Nombre y descripción del autor

👉 El tema se instalará automáticamente dentro de tu carpeta wp-content/themes/.

2. Activa el tema en WordPress
Desde el administrador de WordPress, ve a Apariencia → Temas y activa tu nuevo tema.

3. Inicia el entorno de desarrollo
Desde la carpeta del tema:

bash
```
npm run dev
```
###📄 Licencia
GPL-2.0-or-later
