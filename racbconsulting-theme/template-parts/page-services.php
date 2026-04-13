<?php
/**
 * RACBCONSULTING — template-parts/page-services.php
 */
?>

<div class="page" id="page-services" style="padding-top: 148px;">

  <div class="services-hero">
    <span class="section-label" style="color: rgba(255,255,255,0.7);">Catálogo de Servicios</span>
    <h1 data-i18n="sp-title">Soluciones de IA para PYMES y Profesionales</h1>
    <p data-i18n="sp-sub">Implementamos tecnología de Inteligencia Artificial adaptada a tu industria, presupuesto y objetivos de negocio.</p>
  </div>

  <section style="background: var(--accent-bg); padding: 3rem 2rem 1rem;">
    <div class="container">
      <div class="services-tabs">
        <button class="service-tab active" onclick="filterService(this, 'web')" data-i18n="tab1">🌐 Web con IA</button>
        <button class="service-tab" onclick="filterService(this, 'chatbot')" data-i18n="tab2">💬 Chatbots GPT</button>
        <button class="service-tab" onclick="filterService(this, 'auto')" data-i18n="tab3">⚙️ Automatización</button>
        <button class="service-tab" onclick="filterService(this, 'email')" data-i18n="tab4">📧 Correo + IA</button>
        <button class="service-tab" onclick="filterService(this, 'crm')" data-i18n="tab5">🔗 CRM + IA</button>
      </div>
    </div>
  </section>

  <!-- SERVICE 1 -->
  <div class="service-detail" id="svc-web">
    <div class="service-detail-text">
      <span class="section-label" data-i18n="sp1-label">Servicio 01</span>
      <h2 data-i18n="sp1-title">Desarrollo Web Inteligente con IA para tu Negocio</h2>
      <p data-i18n="sp1-p1">Tu sitio web debería ser tu mejor vendedor. Creamos sitios web potenciados con Inteligencia Artificial que personalizan la experiencia de cada visitante, generan contenido SEO automáticamente y convierten más visitas en clientes.</p>
      <p data-i18n="sp1-p2">Construidos en WordPress con los últimos plugins de IA, tus páginas aprenden de tus visitantes y mejoran continuamente sin que tengas que hacer nada manual.</p>
      <ul class="feature-list">
        <li><span class="check-icon">✓</span> Diseño responsive mobile-first con UX optimizado por IA</li>
        <li><span class="check-icon">✓</span> Generación automática de contenido SEO con GPT</li>
        <li><span class="check-icon">✓</span> Chatbot integrado para atención 24/7</li>
        <li><span class="check-icon">✓</span> Personalización dinámica de contenido por perfil de usuario</li>
        <li><span class="check-icon">✓</span> Integración con CRM y herramientas de marketing</li>
        <li><span class="check-icon">✓</span> Analytics IA: predicción de comportamiento de visitantes</li>
        <li><span class="check-icon">✓</span> Velocidad de carga optimizada (Core Web Vitals)</li>
        <li><span class="check-icon">✓</span> SEO técnico + schema.org para posicionamiento local</li>
      </ul>
      <a href="#" class="btn-primary" style="background: var(--gradient); color: white; display: inline-flex;" onclick="showPage('demo')" data-i18n="svc-quote-btn">Solicitar cotización →</a>
    </div>
    <div class="service-detail-visual">
      <div class="service-visual-icon">🌐 ✨</div>
      <h3 style="color: var(--secondary); margin-bottom: 0.5rem;" data-i18n="sp1-visual-title">Web que trabaja por ti</h3>
      <p style="font-size: 0.88rem; margin-bottom: 0;" data-i18n="sp1-visual-sub">Con IA integrada, tu sitio se convierte en un activo que genera leads incluso mientras duermes.</p>
      <div class="service-visual-stats">
        <div class="vs-stat">
          <div class="vs-stat-num">3x</div>
          <div class="vs-stat-label" data-i18n="vs1-1">Más conversiones</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">60%</div>
          <div class="vs-stat-label" data-i18n="vs1-2">Menos rebote</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">24/7</div>
          <div class="vs-stat-label" data-i18n="vs1-3">Generación de leads</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">Top 5</div>
          <div class="vs-stat-label" data-i18n="vs1-4">SEO Google</div>
        </div>
      </div>
    </div>
  </div>

  <hr class="section-divider">

  <!-- SERVICE 2 -->
  <div class="service-detail" id="svc-chatbot">
    <div class="service-detail-visual">
      <div class="service-visual-icon">💬 🤖</div>
      <h3 style="color: var(--secondary); margin-bottom: 0.5rem;" data-i18n="sp2-visual-title">Agente GPT para atención</h3>
      <p style="font-size: 0.88rem; margin-bottom: 0;" data-i18n="sp2-visual-sub">Un agente que conoce tu negocio perfectamente y responde como tú lo haría, pero disponible siempre.</p>
      <div class="service-visual-stats">
        <div class="vs-stat">
          <div class="vs-stat-num">80%</div>
          <div class="vs-stat-label" data-i18n="vs2-1">Consultas resueltas sin humano</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">&lt;2s</div>
          <div class="vs-stat-label" data-i18n="vs2-2">Tiempo de respuesta</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">∞</div>
          <div class="vs-stat-label" data-i18n="vs2-3">Conversaciones simultáneas</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">+40%</div>
          <div class="vs-stat-label" data-i18n="vs2-4">Leads calificados</div>
        </div>
      </div>
    </div>
    <div class="service-detail-text">
      <span class="section-label" data-i18n="sp2-label">Servicio 02</span>
      <h2 data-i18n="sp2-title">Chatbots Inteligentes y Agentes GPT para Atención al Cliente</h2>
      <p data-i18n="sp2-p1">Un chatbot inteligente WordPress no es solo una ventana de chat. Es un agente GPT entrenado con la información de tu empresa, capaz de vender, agendar citas, resolver dudas y escalar a humanos cuando es necesario.</p>
      <p data-i18n="sp2-p2">Disponible en tu web, WhatsApp, Instagram y más canales, trabajando 24/7 para que nunca pierdas una oportunidad de negocio.</p>
      <ul class="feature-list">
        <li><span class="check-icon">✓</span> Agente GPT personalizado con tu base de conocimiento</li>
        <li><span class="check-icon">✓</span> Disponible en Web, WhatsApp Business y redes sociales</li>
        <li><span class="check-icon">✓</span> Calificación automática de leads con IA</li>
        <li><span class="check-icon">✓</span> Agendamiento de citas integrado con tu calendario</li>
        <li><span class="check-icon">✓</span> Escalación inteligente a humanos</li>
        <li><span class="check-icon">✓</span> Panel de analytics y conversaciones</li>
        <li><span class="check-icon">✓</span> Integración con CRM y email marketing</li>
        <li><span class="check-icon">✓</span> Soporte multiidioma (español, inglés y más)</li>
      </ul>
      <a href="#" class="btn-primary" style="background: var(--gradient); color: white; display: inline-flex;" onclick="showPage('demo')" data-i18n="svc-quote-btn">Solicitar cotización →</a>
    </div>
  </div>

  <hr class="section-divider">

  <!-- SERVICE 3 -->
  <div class="service-detail" id="svc-auto">
    <div class="service-detail-text">
      <span class="section-label" data-i18n="sp3-label">Servicio 03</span>
      <h2 data-i18n="sp3-title">Automatización de Procesos con IA para PYMES</h2>
      <p data-i18n="sp3-p1">¿Tu equipo pierde horas en tareas repetitivas? La automatización inteligente conecta tus herramientas, elimina procesos manuales y te permite enfocarte en lo que realmente hace crecer tu negocio.</p>
      <p data-i18n="sp3-p2">Usamos n8n, Make y Zapier con capas de IA para crear flujos que antes requerían personal dedicado, ahora funcionan solos.</p>
      <ul class="feature-list">
        <li><span class="check-icon">✓</span> Mapeo y diagnóstico de procesos automatizables</li>
        <li><span class="check-icon">✓</span> Automatización de seguimiento de prospectos y clientes</li>
        <li><span class="check-icon">✓</span> Flujos de facturación y cobranza automática</li>
        <li><span class="check-icon">✓</span> Reportes y dashboards generados por IA</li>
        <li><span class="check-icon">✓</span> Integración entre herramientas (CRM, ERP, contabilidad)</li>
        <li><span class="check-icon">✓</span> Notificaciones inteligentes por email y WhatsApp</li>
        <li><span class="check-icon">✓</span> Clasificación y enrutamiento automático de correos</li>
        <li><span class="check-icon">✓</span> Entrenamiento de tu equipo en los nuevos flujos</li>
      </ul>
      <a href="#" class="btn-primary" style="background: var(--gradient); color: white; display: inline-flex;" onclick="showPage('demo')" data-i18n="svc-quote-btn">Solicitar cotización →</a>
    </div>
    <div class="service-detail-visual">
      <div class="service-visual-icon">⚙️ 🔄</div>
      <h3 style="color: var(--secondary); margin-bottom: 0.5rem;" data-i18n="sp3-visual-title">Flujos que trabajan solos</h3>
      <p style="font-size: 0.88rem; margin-bottom: 0;" data-i18n="sp3-visual-sub">Automatiza las tareas repetitivas y libera a tu equipo para lo que realmente importa.</p>
      <div class="service-visual-stats">
        <div class="vs-stat">
          <div class="vs-stat-num">70%</div>
          <div class="vs-stat-label" data-i18n="vs3-1">Menos tiempo admin</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">0</div>
          <div class="vs-stat-label" data-i18n="vs3-2">Errores manuales</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">3x</div>
          <div class="vs-stat-label" data-i18n="vs3-3">Más productividad</div>
        </div>
        <div class="vs-stat">
          <div class="vs-stat-num">ROI +</div>
          <div class="vs-stat-label" data-i18n="vs3-4">Desde el mes 1</div>
        </div>
      </div>
    </div>
  </div>

  <div class="cta-band">
    <div class="container">
      <h2 data-i18n="sp-cta-title">¿Qué solución necesitas para tu PYME?</h2>
      <p data-i18n="sp-cta-sub">Agenda una consultoría gratuita y te ayudamos a identificar qué servicio de IA tiene mayor impacto para tu negocio.</p>
      <div class="cta-band-btns">
        <a href="#" class="btn-primary" onclick="showPage('demo')" data-i18n="sp-cta-btn">Agendar Consultoría Gratuita</a>
        <a href="#" class="js-wa" data-phone="1234567890" data-text="Hola, quiero información sobre sus servicios de IA" class="btn-outline" target="_blank">💬 WhatsApp</a>
      </div>
    </div>
  </div>

</div><!-- /services page -->
