<?php
/**
 * RACBCONSULTING — template-parts/page-demo.php
 */
?>

<div class="page" id="page-demo" style="padding-top: 148px;">

  <div class="services-hero">
    <span class="section-label" style="color: rgba(255,255,255,0.7);">Demo & Cotización</span>
    <h1 data-i18n="dp-title">Agenda tu Demo IA Gratuita</h1>
    <p data-i18n="dp-sub">30 minutos para mostrarte cómo la IA puede transformar tu negocio. Sin compromiso, sin tecnicismos.</p>
  </div>

  <section class="demo-section">
    <div class="container">
      <div class="demo-grid">
        <div>
          <span class="section-label" data-i18n="demo-form-label">Formulario de contacto</span>
          <h2 class="section-title" style="font-size: 1.8rem;" data-i18n="demo-form-title">Cuéntanos sobre tu negocio</h2>
          <p style="margin-bottom: 2rem;" data-i18n="demo-form-sub">Completa el formulario y un consultor de RACBCONSULTING te contactará en menos de 24 horas para entender tus necesidades.</p>
          <form onsubmit="handleForm(event)" class="js-racb-form" data-form="demo">
            <input type="hidden" name="form_type" value="demo">
            <input type="text" name="website" value="" style="display:none !important" tabindex="-1" autocomplete="off">
            <div class="form-group">
              <label data-i18n="field-name">Nombre completo *</label>
              <input type="text" name="name" placeholder="Tu nombre" required>
            </div>
            <div class="form-group">
              <label data-i18n="field-email">Correo electrónico *</label>
              <input type="email" name="email" placeholder="tu@empresa.com" required>
            </div>
            <div class="form-group">
              <label data-i18n="field-company">Empresa</label>
              <input type="text" name="company" placeholder="Nombre de tu empresa">
            </div>
            <div class="form-group">
              <label data-i18n="field-service">Servicio de interés *</label>
              <select name="service" required>
                <option value="" data-i18n="opt-select">Selecciona un servicio...</option>
                <option data-i18n="opt1">Desarrollo Web Inteligente con IA</option>
                <option data-i18n="opt2">Chatbots y Agentes GPT</option>
                <option data-i18n="opt3">Automatización de Procesos</option>
                <option data-i18n="opt4">Correo Corporativo + IA</option>
                <option data-i18n="opt5">Integraciones CRM + IA</option>
                <option data-i18n="opt6">No sé, quiero asesoría</option>
              </select>
            </div>
            <div class="form-group">
              <label data-i18n="field-comments">Comentarios / Descripción de tu necesidad</label>
              <textarea name="message" placeholder="Cuéntanos brevemente tu reto o necesidad..."></textarea>
            </div>
            <button type="submit" class="btn-submit" data-i18n="btn-submit">🚀 Solicitar Demo Gratuita</button>
          </form>
        </div>
        <div>
          <span class="section-label" data-i18n="contact-alt-label">Otras formas de contactarnos</span>
          <h2 class="section-title" style="font-size: 1.8rem;" data-i18n="contact-alt-title">Elige cómo hablar con nosotros</h2>
          <p style="margin-bottom: 2rem;" data-i18n="contact-alt-sub">Contamos con múltiples canales para que elijas el que más te comode.</p>
          <div class="contact-options">
            <a href="#" class="js-wa" data-phone="1234567890" data-text="Hola, quiero información sobre sus servicios de IA" class="contact-option" target="_blank">
              <div class="contact-option-icon icon-wa">💬</div>
              <div>
                <div class="contact-option-title" data-i18n="wa-title">WhatsApp Directo</div>
                <div class="contact-option-sub" data-i18n="wa-sub">Respuesta en minutos · Lunes a Viernes 9–19h</div>
              </div>
            </a>
            <a href="https://calendly.com/racb-consulting" class="contact-option" target="_blank">
              <div class="contact-option-icon icon-calendly">📅</div>
              <div>
                <div class="contact-option-title" data-i18n="cal-title">Agendar en Calendly</div>
                <div class="contact-option-sub" data-i18n="cal-sub">Sesión de 30 min · Elige día y hora según tu disponibilidad</div>
              </div>
            </a>
            <a href="mailto:hello@racbconsulting.com" class="contact-option">
              <div class="contact-option-icon icon-email">📧</div>
              <div>
                <div class="contact-option-title" data-i18n="mail-title">Correo Electrónico</div>
                <div class="contact-option-sub" data-i18n="mail-sub">hello@racbconsulting.com · Respuesta &lt; 24h</div>
              </div>
          </a>
          </div>
          <div style="background: var(--white); border-radius: 12px; padding: 2rem; margin-top: 2rem; border: 1px solid var(--border);">
            <h3 style="color: var(--secondary); font-size: 1rem; margin-bottom: 1rem;" data-i18n="demo-get-title">¿Qué obtienes en tu Demo?</h3>
            <ul class="feature-list">
              <li><span class="check-icon">✓</span> <span data-i18n="demo-get1">Diagnóstico personalizado de tu negocio</span></li>
              <li><span class="check-icon">✓</span> <span data-i18n="demo-get2">Demo en vivo de las soluciones IA aplicadas a tu industria</span></li>
              <li><span class="check-icon">✓</span> <span data-i18n="demo-get3">Propuesta inicial con estimado de ROI</span></li>
              <li><span class="check-icon">✓</span> <span data-i18n="demo-get4">Preguntas y respuestas sin compromiso</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</div><!-- /demo page -->
