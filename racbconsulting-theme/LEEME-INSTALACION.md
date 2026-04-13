# RACBCONSULTING — Guía de Instalación en WordPress

## Qué contiene este paquete

```
racbconsulting-theme/
├── style.css              ← Hoja de estilos principal del tema
├── functions.php          ← Funciones PHP (menús, scripts, post types, etc.)
├── index.php              ← Template de entrada
├── header.php             ← Cabecera con navegación
├── footer.php             ← Pie de página con redes sociales
├── assets/
│   ├── logo.png           ← Logo del sitio (transparente)
│   └── racb-main.js       ← JavaScript (navegación, filtros, idiomas)
└── template-parts/
    ├── spa-shell.php      ← Todas las secciones en un solo archivo
    ├── page-home.php      ← Sección: Inicio
    ├── page-services.php  ← Sección: Servicios
    ├── page-cases.php     ← Sección: Casos de Éxito
    ├── page-demo.php      ← Sección: Demo / Cotización
    ├── page-blog.php      ← Sección: Blog
    └── page-contact.php   ← Sección: Contacto
```

---

## PASO 1 — Subir el tema a WordPress

1. Comprime la carpeta `racbconsulting-theme/` en un archivo ZIP
2. Ve a **WordPress Admin → Apariencia → Temas → Añadir nuevo → Subir tema**
3. Sube el ZIP y haz clic en **Instalar ahora**
4. Haz clic en **Activar**

---

## PASO 2 — Configurar datos del sitio

1. Ve a **WordPress Admin → RACB Ajustes** (aparece en el menú lateral)
2. Rellena todos los campos:
   - Teléfono y WhatsApp
   - Email de contacto
   - URL de Calendly
   - URLs de todas las redes sociales
3. Guarda los cambios

---

## PASO 3 — Subir el logo

1. Ve a **WordPress Admin → Apariencia → Personalizar → Identidad del sitio**
2. Haz clic en **Seleccionar logo**
3. Sube el archivo `assets/logo.png` desde este paquete
4. Guarda y publica

---

## PASO 4 — Plugins recomendados

Instala estos plugins gratuitos para funcionalidad completa:

| Plugin | Para qué sirve |
|--------|----------------|
| **Rank Math SEO** | SEO optimizado, schema.org automático |
| **WPForms Lite** | Formularios de contacto y demo |
| **Wordfence Security** | Seguridad y firewall |
| **W3 Total Cache** | Caché y velocidad de carga |
| **UpdraftPlus** | Copias de seguridad automáticas |

---

## PASO 5 — Configurar formularios (WPForms)

1. Instala y activa **WPForms Lite**
2. Crea un formulario con estos campos:
   - Nombre completo (requerido)
   - Correo electrónico (requerido)
   - Empresa
   - Servicio de interés (lista desplegable)
   - Mensaje / descripción
3. En **Notificaciones**, pon el email de destino: `hello@racbconsulting.com`
4. Copia el shortcode del formulario (ej: `[wpforms id="1"]`)
5. En el archivo `template-parts/page-demo.php`, busca la etiqueta `<form` y reemplaza el bloque por el shortcode de WPForms

---

## PASO 6 — Verificar el sitio

Abre tu sitio y comprueba:
- [ ] Logo visible en la navegación
- [ ] Los 6 botones de navegación cambian de sección
- [ ] El botón ES/EN traduce todo el contenido
- [ ] Los tabs de Servicios filtran correctamente
- [ ] Los filtros del Blog funcionan
- [ ] El botón de WhatsApp flotante aparece abajo a la derecha
- [ ] El formulario de Demo envía emails
- [ ] El enlace "Privacidad" abre el modal

---

## Notas importantes

- El sitio funciona como **SPA (Single Page Application)**: toda la navegación ocurre en una sola página sin recargas
- Los textos en **data-i18n** se traducen automáticamente al cambiar de idioma
- El año del copyright se actualiza automáticamente cada año
- Las URLs de redes sociales se administran desde **RACB Ajustes** sin tocar código
