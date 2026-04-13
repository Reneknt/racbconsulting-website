<?php
/**
 * RACBCONSULTING — template-parts/page-contact.php
 */
?>

<div class="page" id="page-contact" style="padding-top: 148px;">

  <div class="services-hero">
    <span class="section-label" style="color: rgba(255,255,255,0.7);">Contacto</span>
    <h1 data-i18n="cop-title">Hablemos de tu proyecto</h1>
    <p data-i18n="cop-sub">Estamos listos para ayudarte a dar el primer paso hacia la transformación digital con IA.</p>
  </div>

  <section>
    <div class="container">
      <div class="demo-grid">
        <div>
          <span class="section-label" data-i18n="cop-form-label">Envíanos un mensaje</span>
          <h2 class="section-title" style="font-size: 1.8rem;" data-i18n="cop-form-title">¿Tienes alguna pregunta?</h2>
          <form onsubmit="handleForm(event)" class="js-racb-form" data-form="contact">
            <input type="hidden" name="form_type" value="contact">
            <input type="text" name="website" value="" style="display:none !important" tabindex="-1" autocomplete="off">
            <div class="form-group">
              <label data-i18n="cop-field-name">Nombre *</label>
              <input type="text" name="name" placeholder="Tu nombre completo" required>
            </div>
            <div class="form-group">
              <label data-i18n="cop-field-email">Email *</label>
              <input type="email" name="email" placeholder="correo@empresa.com" required>
            </div>
            <div class="form-group">
              <label data-i18n="cop-field-subject">Asunto</label>
              <input type="text" name="service" placeholder="¿En qué te podemos ayudar?">
            </div>
            <div class="form-group">
              <label data-i18n="cop-field-msg">Mensaje *</label>
              <textarea name="message" placeholder="Escribe tu mensaje aquí..." required></textarea>
            </div>
            <button type="submit" class="btn-submit" data-i18n="cop-btn">Enviar mensaje →</button>
          </form>
        </div>
        <div>
          <span class="section-label" data-i18n="cop-info-label">Nuestros datos</span>
          <h2 class="section-title" style="font-size: 1.8rem;" data-i18n="cop-info-title">Información de contacto</h2>
          <div class="contact-info">
            <div class="contact-info-item">
              <div class="contact-info-icon">📧</div>
              <div>
                <div style="font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem;" data-i18n="cop-email-label">Correo Electrónico</div>
                <div style="font-size: 0.9rem; color: var(--text-light);"><a href="mailto:hello@racbconsulting.com"  >hello@racbconsulting.com</a></div>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon">📱</div>
              <div>
                <div style="font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem;" data-i18n="cop-wa-label">WhatsApp / Teléfono</div>
                <div style="font-size: 0.9rem; color: var(--text-light);">+52 (55) 1234-5678</div>
                <div style="font-size: 0.9rem; color: var(--text-light);" data-i18n="cop-hours">Lunes a Viernes · 9:00 – 19:00h</div>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon">📅</div>
              <div>
                <div style="font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem;" data-i18n="cop-cal-label">Agendar Consultoría</div>
                <div style="font-size: 0.9rem; color: var(--text-light);" data-i18n="cop-cal-sub">Sesiones de 30 min gratuitas</div>
                <a href="https://calendly.com/racb-consulting" target="_blank" style="color: var(--primary); font-size: 0.88rem; font-weight: 600;" data-i18n="cop-cal-link">Abrir Calendly →</a>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon">📍</div>
              <div>
                <div style="font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem;" data-i18n="cop-loc-label">Ubicación</div>
                <div style="font-size: 0.9rem; color: var(--text-light);" data-i18n="cop-loc-text">Servicios disponibles en toda Latinoamérica</div>
                <div style="font-size: 0.9rem; color: var(--text-light);" data-i18n="cop-loc-sub">Consultoría 100% remota y presencial</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div><!-- /contact page -->
