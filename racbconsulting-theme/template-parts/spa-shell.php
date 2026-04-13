<?php
/**
 * RACBCONSULTING — template-parts/spa-shell.php
 * Carga todas las secciones del SPA en un solo template
 */
?>

<div class="page active" id="page-home">

  <!-- HERO -->
  <section class="hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-inner">
      <div class="hero-content">
        <div class="hero-badge">
          <span class="dot"></span>
          <span data-i18n="hero-badge">Especialistas en IA para Negocios</span>
        </div>
        <h1 class="hero-title" data-i18n="hero-title" data-i18n-html="1">Te ayudamos a implementar la <em>IA de manera práctica</em> para hacer crecer tu negocio</h1>
        <p class="hero-subtitle" data-i18n="hero-sub">
          Soluciones de Inteligencia Artificial diseñadas específicamente para PYMES y profesionales que quieren resultados reales, no promesas vacías.
        </p>
        <div class="hero-actions">
          <a href="javascript:void(0)" class="btn-primary" onclick="showPage('demo')" data-i18n="hero-btn1">🚀 Solicita una Demo</a>
          <a href="javascript:void(0)" class="btn-outline" onclick="showPage('services')" data-i18n="hero-btn2">Ver Servicios →</a>
        </div>
        <div class="hero-stats">
          <div class="stat">
            <div class="stat-num" data-i18n="stat1-num">+120</div>
            <div class="stat-label" data-i18n="hero-stat1-label">PYMEs atendidas</div>
          </div>
          <div class="stat">
            <div class="stat-num" data-i18n="stat2-num">40%</div>
            <div class="stat-label" data-i18n="hero-stat2-label">Reducción de costos</div>
          </div>
          <div class="stat">
            <div class="stat-num" data-i18n="stat3-num">24/7</div>
            <div class="stat-label" data-i18n="hero-stat3-label">Soporte IA activo</div>
          </div>
        </div>
      </div>
      <div class="hero-visual">
        <div class="hero-card">
          <div class="floating-badge top">
            <span class="green-dot"></span> <span data-i18n="ia-active">IA Activa ahora</span>
          </div>
          <div class="hero-card-header">
            <div class="hero-card-icon">🤖</div>
            <div>
              <div class="hero-card-title" data-i18n="chat-title">Agente GPT RACBCONSULTING</div>
              <div class="hero-card-sub" data-i18n="chat-sub">Asistente IA para tu negocio</div>
            </div>
          </div>
          <div class="ai-chat-messages">
            <div class="msg msg-user" data-i18n="chat-msg1">¿Puedes atender a mis clientes automáticamente?</div>
            <div class="msg msg-ai" data-i18n="chat-reply1">¡Sí! Implementamos un agente GPT personalizado con el conocimiento de tu empresa, disponible 24/7 para responder preguntas, agendar citas y calificar leads.</div>
            <div class="msg msg-user" data-i18n="chat-msg2">¿Cuánto tiempo tarda en estar listo?</div>
            <div class="typing-indicator">
              <span></span><span></span><span></span>
            </div>
          </div>
          <div class="floating-badge bottom" data-i18n="chat-badge">⚡ Respuesta en &lt;2 seg</div>
        </div>
      </div>
    </div>
  </section>

  <!-- BENEFITS -->
  <section class="benefits">
    <div class="container">
      <div class="text-center reveal">
        <span class="section-label" data-i18n="benefits-label">¿Por qué RACBCONSULTING?</span>
        <h2 class="section-title" data-i18n="benefits-title">IA que genera resultados medibles para tu PYME</h2>
        <p class="section-sub" data-i18n="benefits-sub">No vendemos tecnología por la tecnología. Implementamos soluciones de Inteligencia Artificial que resuelven problemas reales y aumentan tus ingresos.</p>
      </div>
      <div class="benefits-grid">
        <div class="benefit-card reveal reveal-delay-1">
          <div class="benefit-icon">⚡</div>
          <h3>Implementación Rápida</h3>
          <p data-i18n="ben1-text">Desde la primera reunión hasta tu solución IA funcionando en producción en menos de 4 semanas. Sin fricciones, sin proyectos interminables.</p>
        </div>
        <div class="benefit-card reveal reveal-delay-2">
          <div class="benefit-icon">📊</div>
          <h3>ROI Comprobable</h3>
          <p data-i18n="ben2-text">Cada solución incluye métricas de seguimiento. Verás exactamente cuánto tiempo ahorras, cuántos leads captas y cuánto crece tu facturación con IA.</p>
        </div>
        <div class="benefit-card reveal reveal-delay-3">
          <div class="benefit-icon">🛡️</div>
          <h3>Soporte Continuo</h3>
          <p data-i18n="ben3-text">No te dejamos solo. Capacitamos a tu equipo, optimizamos tu IA y escalamos contigo. Tenemos planes de soporte para todas las necesidades.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES HIGHLIGHT -->
  <section style="background: var(--white);">
    <div class="container">
      <div class="text-center reveal">
        <span class="section-label" data-i18n="services-label">Nuestros Servicios</span>
        <h2 class="section-title" data-i18n="services-title">Soluciones de IA para cada etapa de tu negocio</h2>
        <p class="section-sub" data-i18n="services-sub">Desde automatizar tu atención al cliente hasta transformar tu web en una máquina de ventas con IA.</p>
      </div>
      <div class="services-grid">
        <div class="service-card reveal reveal-delay-1">
          <div class="service-card-top">
            <div class="service-num">01</div>
            <div class="service-icon-wrap">🌐</div>
            <h3 data-i18n="svc1-title">Desarrollo Web Inteligente con IA</h3>
          </div>
          <div class="service-card-body">
            <p data-i18n="svc1-desc">Sitios web que no solo se ven bien, sino que usan IA para personalizar la experiencia de cada visitante y convertir más.</p>
            <div class="service-tags">
              <span class="tag">WordPress</span>
              <span class="tag">IA Generativa</span>
              <span class="tag">SEO IA</span>
            </div>
            <a href="javascript:void(0)" class="service-link" onclick="showPage('services')" data-i18n="ver-mas">Ver más →</a>
          </div>
        </div>
        <div class="service-card reveal reveal-delay-2">
          <div class="service-card-top">
            <div class="service-num">02</div>
            <div class="service-icon-wrap">💬</div>
            <h3 data-i18n="svc2-title">Chatbots y Agentes GPT</h3>
          </div>
          <div class="service-card-body">
            <p data-i18n="svc2-desc">Agentes GPT entrenados con el conocimiento de tu empresa para atender, vender y calificar leads las 24 horas del día.</p>
            <div class="service-tags">
              <span class="tag">GPT-4</span>
              <span class="tag">WhatsApp</span>
              <span class="tag">Web</span>
            </div>
            <a href="javascript:void(0)" class="service-link" onclick="showPage('services')" data-i18n="ver-mas">Ver más →</a>
          </div>
        </div>
        <div class="service-card reveal reveal-delay-3">
          <div class="service-card-top">
            <div class="service-num">03</div>
            <div class="service-icon-wrap">⚙️</div>
            <h3 data-i18n="svc3-title">Automatización de Procesos</h3>
          </div>
          <div class="service-card-body">
            <p data-i18n="svc3-desc">Elimina tareas repetitivas con flujos IA. Conectamos tus herramientas y automatizamos procesos que hoy hacen manualmente.</p>
            <div class="service-tags">
              <span class="tag">n8n</span>
              <span class="tag">Zapier</span>
              <span class="tag">Make</span>
            </div>
            <a href="javascript:void(0)" class="service-link" onclick="showPage('services')" data-i18n="ver-mas">Ver más →</a>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 3rem;" class="reveal">
        <a href="javascript:void(0)" class="btn-primary" onclick="showPage('services')" style="background: var(--gradient); color: white; display: inline-flex;" data-i18n="services-btn">Ver todos los servicios →</a>
      </div>
    </div>
  </section>

  <!-- PROCESS -->
  <section class="process">
    <div class="container">
      <div class="text-center reveal">
        <span class="section-label" data-i18n="process-label">Nuestro Proceso</span>
        <h2 class="section-title" data-i18n="process-title">De la idea a la IA funcionando en 4 pasos</h2>
      </div>
      <div class="process-steps">
        <div class="process-step reveal reveal-delay-1">
          <div class="step-circle">1</div>
          <h3 data-i18n="step1-title">Diagnóstico Gratuito</h3>
          <p data-i18n="step1-text">Analizamos tu negocio para identificar dónde la IA tiene mayor impacto en menos tiempo.</p>
        </div>
        <div class="process-step reveal reveal-delay-2">
          <div class="step-circle">2</div>
          <h3 data-i18n="step2-title">Diseño de Solución</h3>
          <p data-i18n="step2-text">Diseñamos una hoja de ruta con herramientas específicas, plazos y KPIs de éxito medibles.</p>
        </div>
        <div class="process-step reveal reveal-delay-3">
          <div class="step-circle">3</div>
          <h3 data-i18n="step3-title">Implementación</h3>
          <p data-i18n="step3-text">Desplegamos, probamos e integramos la IA en tu operación con mínima interrupción del negocio.</p>
        </div>
        <div class="process-step reveal" style="transition-delay: 0.4s">
          <div class="step-circle">4</div>
          <h3 data-i18n="step4-title">Optimización</h3>
          <p data-i18n="step4-text">Monitoreamos, ajustamos y mejoramos continuamente para que tu IA siempre entregue los mejores resultados.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testimonials">
    <div class="container">
      <div class="text-center reveal">
        <span class="section-label" data-i18n="test-label">Testimonios</span>
        <h2 class="section-title" data-i18n="test-title">Lo que dicen nuestros clientes</h2>
      </div>
      <div class="testimonials-grid">
        <div class="testimonial-card reveal reveal-delay-1">
          <div class="stars">★★★★★</div>
          <p><span data-i18n="test1-text">"El chatbot IA que RACBCONSULTING implementó en nuestra web aumentó las consultas calificadas en un 180%. Antes respondíamos emails 2 días después, ahora el agente GPT responde al instante."</span></p>
          <div class="testimonial-author">
            <div class="author-avatar">MC</div>
            <div>
              <div class="author-name" data-i18n="auth1-name">María Castro</div>
              <div class="author-role" data-i18n="auth1-role">CEO – Clínica Dental Sonrisa</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card reveal reveal-delay-2">
          <div class="stars">★★★★★</div>
          <p><span data-i18n="test2-text">"La automatización de procesos nos ahorró 3 empleados en tareas administrativas. El ROI fue evidente en el primer mes. Recomiendo RACBCONSULTING sin dudarlo."</span></p>
          <div class="testimonial-author">
            <div class="author-avatar">JR</div>
            <div>
              <div class="author-name" data-i18n="auth2-name">Jorge Reyes</div>
              <div class="author-role" data-i18n="auth2-role">Director – Distribuidora MX Norte</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card reveal reveal-delay-3">
          <div class="stars">★★★★★</div>
          <p><span data-i18n="test3-text">"Pensé que la IA era solo para empresas grandes. RACBCONSULTING me demostró que con su solución de correo corporativo + IA, mi despacho jurídico ahora compite con cualquiera."</span></p>
          <div class="testimonial-author">
            <div class="author-avatar">LP</div>
            <div>
              <div class="author-name" data-i18n="auth3-name">Lic. Laura Pérez</div>
              <div class="author-role" data-i18n="auth3-role">Abogada independiente</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- BLOG PREVIEW -->
  <section>
    <div class="container">
      <div class="text-center reveal">
        <span class="section-label" data-i18n="blog-label">Blog IA</span>
        <h2 class="section-title" data-i18n="blog-title">Aprende a implementar IA en tu negocio</h2>
        <p class="section-sub" data-i18n="blog-sub">Artículos prácticos, sin tecnicismos, escritos para dueños de PYMES que quieren resultados.</p>
      </div>
      <div class="blog-grid">
        <div class="blog-card reveal reveal-delay-1">
          <div class="blog-thumb">
            <div class="blog-thumb-icon">💬</div>
            <span class="blog-category" data-i18n="blog1-cat">Chatbots</span>
          </div>
          <div class="blog-body">
            <div class="blog-date" data-i18n="blog1-date">15 Feb 2025</div>
            <h3 data-i18n="blog1-title">Cómo un chatbot GPT puede triplicar tus ventas en línea</h3>
            <p data-i18n="blog1-excerpt">Descubre cómo implementar un agente GPT en tu sitio web para calificar leads automáticamente...</p>
          </div>
        </div>
        <div class="blog-card reveal reveal-delay-2">
          <div class="blog-thumb">
            <div class="blog-thumb-icon">⚙️</div>
            <span class="blog-category" data-i18n="blog2-cat">Automatización</span>
          </div>
          <div class="blog-body">
            <div class="blog-date" data-i18n="blog2-date">8 Feb 2025</div>
            <h3 data-i18n="blog2-title">5 procesos de tu PYME que puedes automatizar con IA esta semana</h3>
            <p>Desde facturación hasta seguimiento de clientes, aquí están los procesos más fáciles de automatizar...</p>
          </div>
        </div>
        <div class="blog-card reveal reveal-delay-3">
          <div class="blog-thumb">
            <div class="blog-thumb-icon">🌐</div>
            <span class="blog-category" data-i18n="blog3-cat">Web con IA</span>
          </div>
          <div class="blog-body">
            <div class="blog-date" data-i18n="blog3-date">1 Feb 2025</div>
            <h3 data-i18n="blog3-title">WordPress + IA: La combinación que revolucionará tu sitio web en 2025</h3>
            <p data-i18n="blog3-excerpt">Los plugins de IA para WordPress que están cambiando la forma en que las PYMEs generan contenido...</p>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 3rem;" class="reveal">
        <a href="javascript:void(0)" class="btn-primary" onclick="showPage('blog')" style="background: var(--gradient); color: white; display: inline-flex;" data-i18n="blog-btn">Ver todos los artículos →</a>
      </div>
    </div>
  </section>

  <!-- CTA BAND -->
  <div class="cta-band">
    <div class="container">
      <h2 class="reveal">¿Listo para transformar tu negocio con IA?</h2>
      <p class="reveal" data-i18n="cta-sub">Agenda una consultoría gratuita de 30 minutos y descubre cómo la IA puede generar resultados reales para tu PYME.</p>
      <div class="cta-band-btns reveal">
        <a href="javascript:void(0)" class="btn-primary" onclick="showPage('demo')" data-i18n="cta-btn1">🚀 Agenda tu Demo IA</a>
      </div>
    </div>
  </div>

</div><!-- /home page -->

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
      <a href="javascript:void(0)" class="btn-primary" style="background: var(--gradient); color: white; display: inline-flex;" onclick="showPage('demo')" data-i18n="svc-quote-btn">Solicitar cotización →</a>
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
      <a href="javascript:void(0)" class="btn-primary" style="background: var(--gradient); color: white; display: inline-flex;" onclick="showPage('demo')" data-i18n="svc-quote-btn">Solicitar cotización →</a>
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
      <a href="javascript:void(0)" class="btn-primary" style="background: var(--gradient); color: white; display: inline-flex;" onclick="showPage('demo')" data-i18n="svc-quote-btn">Solicitar cotización →</a>
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
        <a href="javascript:void(0)" class="btn-primary" onclick="showPage('demo')" data-i18n="sp-cta-btn">Agendar Consultoría Gratuita</a>
        <a href="#" class="btn-outline js-wa" data-phone="17865678418" data-text="Hola, quiero información sobre sus servicios de IA">💬 WhatsApp</a>
      </div>
    </div>
  </div>

</div><!-- /services page -->

<div class="page" id="page-cases" style="padding-top: 148px;">

  <div class="services-hero">
    <span class="section-label" style="color: rgba(255,255,255,0.7);">Casos de Éxito</span>
    <h1 data-i18n="cp-title">Resultados reales de PYMEs que ya usan IA con RACBCONSULTING</h1>
    <p data-i18n="cp-sub">No hablamos de promesas. Aquí están los resultados comprobables que hemos logrado para negocios como el tuyo.</p>
  </div>

  <section>
    <div class="container">
      <div class="cases-grid">

        <div class="case-card reveal reveal-delay-1">
          <div class="case-header">
            <div>
              <div class="case-industry" data-i18n="c1-ind">Salud</div>
              <div style="color: white; font-weight: 700; margin-top: 0.5rem;" data-i18n="c1-name">Clínica Dental Sonrisa Plus</div>
            </div>
          </div>
          <div class="case-body">
            <div class="case-flow">
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-prob-label">Problema</div>
                <div class="case-flow-text" data-i18n="c1-prob">50% de llamadas sin respuesta. Recepcionista saturada.</div>
              </div>
              <div class="case-flow-arrow">→</div>
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-sol-label">Solución IA</div>
                <div class="case-flow-text" data-i18n="c1-sol">Agente GPT + agendamiento automático en WhatsApp y web.</div>
              </div>
            </div>
            <div class="case-result">
              <div class="result-num">+180%</div>
              <div class="result-label" data-i18n="c1-result">Citas agendadas automáticamente en el primer mes</div>
            </div>
          </div>
        </div>

        <div class="case-card reveal reveal-delay-2">
          <div class="case-header">
            <div>
              <div class="case-industry" data-i18n="c2-ind">Distribución</div>
              <div style="color: white; font-weight: 700; margin-top: 0.5rem;" data-i18n="c2-name">Distribuidora MX Norte</div>
            </div>
          </div>
          <div class="case-body">
            <div class="case-flow">
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-prob-label">Problema</div>
                <div class="case-flow-text" data-i18n="c2-prob">Seguimiento de pedidos manual, errores frecuentes y retrasos.</div>
              </div>
              <div class="case-flow-arrow">→</div>
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-sol-label">Solución IA</div>
                <div class="case-flow-text" data-i18n="c2-sol">Automatización completa de pedidos y notificaciones con IA.</div>
              </div>
            </div>
            <div class="case-result">
              <div class="result-num">40%</div>
              <div class="result-label" data-i18n="c2-result">Reducción de costos operativos en 60 días</div>
            </div>
          </div>
        </div>

        <div class="case-card reveal reveal-delay-3">
          <div class="case-header">
            <div>
              <div class="case-industry" data-i18n="c3-ind">Legal</div>
              <div style="color: white; font-weight: 700; margin-top: 0.5rem;"><span data-i18n="c3-name">Despacho Pérez & Asociados</span></div>
            </div>
          </div>
          <div class="case-body">
            <div class="case-flow">
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-prob-label">Problema</div>
                <div class="case-flow-text" data-i18n="c3-prob">Imagen poco profesional, sin presencia digital, sin sistema de contacto.</div>
              </div>
              <div class="case-flow-arrow">→</div>
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-sol-label">Solución IA</div>
                <div class="case-flow-text" data-i18n="c3-sol">Web profesional + chatbot GPT + correo corporativo + IA.</div>
              </div>
            </div>
            <div class="case-result">
              <div class="result-num">5x</div>
              <div class="result-label" data-i18n="c3-result">Más consultas orgánicas via Google en 3 meses</div>
            </div>
          </div>
        </div>

        <div class="case-card reveal reveal-delay-1">
          <div class="case-header">
            <div>
              <div class="case-industry" data-i18n="c4-ind">E-commerce</div>
              <div style="color: white; font-weight: 700; margin-top: 0.5rem;" data-i18n="c4-name">TiendaModa.mx</div>
            </div>
          </div>
          <div class="case-body">
            <div class="case-flow">
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-prob-label">Problema</div>
                <div class="case-flow-text" data-i18n="c4-prob">Abandono de carrito del 78%. Sin seguimiento post-visita.</div>
              </div>
              <div class="case-flow-arrow">→</div>
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-sol-label">Solución IA</div>
                <div class="case-flow-text" data-i18n="c4-sol">CRM + IA con flujos de recuperación de carrito y upsell automático.</div>
              </div>
            </div>
            <div class="case-result">
              <div class="result-num">+35%</div>
              <div class="result-label" data-i18n="c4-result">Incremento en ventas totales en 45 días</div>
            </div>
          </div>
        </div>

        <div class="case-card reveal reveal-delay-2">
          <div class="case-header">
            <div>
              <div class="case-industry" data-i18n="c5-ind">Educación</div>
              <div style="color: white; font-weight: 700; margin-top: 0.5rem;" data-i18n="c5-name">Instituto Innova Tech</div>
            </div>
          </div>
          <div class="case-body">
            <div class="case-flow">
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-prob-label">Problema</div>
                <div class="case-flow-text" data-i18n="c5-prob">Proceso de inscripción lento. Leads sin seguimiento estructurado.</div>
              </div>
              <div class="case-flow-arrow">→</div>
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-sol-label">Solución IA</div>
                <div class="case-flow-text" data-i18n="c5-sol">Agente GPT + automatización inscripción + CRM con IA.</div>
              </div>
            </div>
            <div class="case-result">
              <div class="result-num">+90%</div>
              <div class="result-label" data-i18n="c5-result">Tasa de cierre de inscripciones vs año anterior</div>
            </div>
          </div>
        </div>

        <div class="case-card reveal reveal-delay-3">
          <div class="case-header">
            <div>
              <div class="case-industry" data-i18n="c6-ind">Servicios</div>
              <div style="color: white; font-weight: 700; margin-top: 0.5rem;" data-i18n="c6-name">Plomería Rápida 24h</div>
            </div>
          </div>
          <div class="case-body">
            <div class="case-flow">
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-prob-label">Problema</div>
                <div class="case-flow-text" data-i18n="c6-prob">Sin presencia web, todo por recomendación. Crecimiento estancado.</div>
              </div>
              <div class="case-flow-arrow">→</div>
              <div class="case-flow-item">
                <div class="case-flow-label" data-i18n="case-sol-label">Solución IA</div>
                <div class="case-flow-text" data-i18n="c6-sol">Web local SEO + chatbot + Google My Business + IA de cotización.</div>
              </div>
            </div>
            <div class="case-result">
              <div class="result-num">+120</div>
              <div class="result-label" data-i18n="c6-result">Nuevos clientes en los primeros 90 días</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <div class="cta-band">
    <div class="container">
      <h2 data-i18n="cp-cta-title">¿Tu empresa podría ser el próximo caso de éxito?</h2>
      <p data-i18n="cp-cta-sub">Agenda una consultoría y analicemos juntos cómo la IA puede transformar los resultados de tu negocio.</p>
      <div class="cta-band-btns">
        <a href="javascript:void(0)" class="btn-primary" onclick="showPage('demo')" data-i18n="cp-cta-btn">🚀 Quiero resultados como estos</a>
      </div>
    </div>
  </div>

</div><!-- /cases page -->

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
            <a href="#" class="contact-option js-wa" data-phone="17865678418" data-text="Hola, quiero información sobre sus servicios de IA">
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

<div class="page" id="page-blog" style="padding-top: 148px;">

  <div class="services-hero">
    <span class="section-label" style="color: rgba(255,255,255,0.7);">Blog de IA para Negocios</span>
    <h1 data-i18n="bp-title">Aprende a implementar IA en tu PYME</h1>
    <p data-i18n="bp-sub">Artículos prácticos sobre chatbots, automatización, IA GPT y más. Sin jerga técnica, con resultados reales.</p>
  </div>

  <section>
    <div class="container">
      <div class="services-tabs" style="margin-bottom: 2rem;">
        <button class="service-tab active" onclick="filterBlog(this, 'all')" data-i18n="bcat-all">Todos</button>
        <button class="service-tab" onclick="filterBlog(this, 'chatbots')" data-i18n="bcat1">💬 Chatbots</button>
        <button class="service-tab" onclick="filterBlog(this, 'auto')" data-i18n="bcat2">⚙️ Automatización</button>
        <button class="service-tab" onclick="filterBlog(this, 'gpt')" data-i18n="bcat3">🤖 IA GPT</button>
        <button class="service-tab" onclick="filterBlog(this, 'web')" data-i18n="bcat4">🌐 Web con IA</button>
      </div>
      <div class="blog-grid">
        <div class="blog-card" data-category="chatbots">
          <div class="blog-thumb" style="background: linear-gradient(135deg, #9B2F6F, #c44a94);">
            <div class="blog-thumb-icon">💬</div>
            <span class="blog-category" data-i18n="blog1-cat">Chatbots</span>
          </div>
          <div class="blog-body">
            <div class="blog-date" data-i18n="blog1-date">15 Feb 2025</div>
            <h3 data-i18n="blog1-title">Cómo un chatbot GPT puede triplicar tus ventas en línea</h3>
            <p data-i18n="bp1-excerpt">Descubre cómo implementar un agente GPT en tu sitio web para calificar leads automáticamente y nunca perder una oportunidad de venta.</p>
          </div>
        </div>
        <div class="blog-card" data-category="auto">
          <div class="blog-thumb" style="background: linear-gradient(135deg, #7a2458, #9B2F6F);">
            <div class="blog-thumb-icon">⚙️</div>
            <span class="blog-category" data-i18n="blog2-cat">Automatización</span>
          </div>
          <div class="blog-body">
            <div class="blog-date" data-i18n="blog2-date">8 Feb 2025</div>
            <h3 data-i18n="blog2-title">5 procesos de tu PYME que puedes automatizar con IA esta semana</h3>
            <p data-i18n="blog2-excerpt">Desde facturación hasta seguimiento de clientes, aquí están los procesos más fáciles de automatizar con herramientas accesibles.</p>
          </div>
        </div>
        <div class="blog-card" data-category="web">
          <div class="blog-thumb" style="background: linear-gradient(135deg, #4a1535, #7a2458);">
            <div class="blog-thumb-icon">🌐</div>
            <span class="blog-category" data-i18n="blog3-cat">Web con IA</span>
          </div>
          <div class="blog-body">
            <div class="blog-date" data-i18n="blog3-date">1 Feb 2025</div>
            <h3 data-i18n="blog3-title">WordPress + IA: La combinación que revolucionará tu sitio web en 2025</h3>
            <p data-i18n="bp3-excerpt">Los mejores plugins de IA para WordPress que están cambiando la forma en que las PYMEs generan contenido y captan leads.</p>
          </div>
        </div>
        <div class="blog-card" data-category="gpt">
          <div class="blog-thumb" style="background: linear-gradient(135deg, #9B2F6F, #4a1535);">
            <div class="blog-thumb-icon">🤖</div>
            <span class="blog-category">IA GPT</span>
          </div>
          <div class="blog-body">
            <div class="blog-date">25 Ene 2025</div>
            <h3 data-i18n="bp4-title">Qué es un Agente GPT y cómo puede reemplazar tareas humanas en tu empresa</h3>
            <p data-i18n="bp4-excerpt">Explicación práctica de los agentes GPT y casos de uso reales para negocios de todos los tamaños en Latinoamérica.</p>
          </div>
        </div>
        <div class="blog-card" data-category="auto">
          <div class="blog-thumb" style="background: linear-gradient(135deg, #c44a94, #9B2F6F);">
            <div class="blog-thumb-icon">📧</div>
            <span class="blog-category">Automatización</span>
          </div>
          <div class="blog-body">
            <div class="blog-date">18 Ene 2025</div>
            <h3 data-i18n="bp5-title">Correo corporativo con IA: Cómo tu bandeja de entrada puede trabajar sola</h3>
            <p data-i18n="bp5-excerpt">Implementa filtros inteligentes, respuestas automáticas y clasificación IA para procesar correos en segundos en lugar de horas.</p>
          </div>
        </div>
        <div class="blog-card" data-category="gpt">
          <div class="blog-thumb" style="background: linear-gradient(135deg, #7a2458, #c44a94);">
            <div class="blog-thumb-icon">🔗</div>
            <span class="blog-category">IA GPT</span>
          </div>
          <div class="blog-body">
            <div class="blog-date">10 Ene 2025</div>
            <h3 data-i18n="bp6-title">CRM + IA: La fórmula para no perder ningún cliente jamás</h3>
            <p data-i18n="bp6-excerpt">Cómo integrar Inteligencia Artificial en tu CRM para predecir qué clientes están listos para comprar y cuáles en riesgo de irse.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

</div><!-- /blog page -->


<div class="page" id="page-contact" style="padding-top: 148px;">
  <div class="services-hero">
    <span class="section-label" style="color: rgba(255,255,255,0.7);" data-i18n="cop-label">Contacto</span>
    <h1 data-i18n="cop-title">Hablemos de tu proyecto</h1>
    <p data-i18n="cop-sub">Estamos listos para ayudarte a dar el primer paso hacia la transformación digital con IA.</p>
  </div>


<div class="contact-info-item">
  <div class="contact-info-icon">📱</div>
  <div>
    <div style="font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem;" data-i18n="cop-wa-label">
      WhatsApp / Teléfono
    </div>

    <a href="#"
       class="js-wa"
       data-phone="17865678418"
       data-text="Hola, quiero información sobre sus servicios de IA"
       style="font-size: 0.9rem; color: var(--primary); font-weight: 600; text-decoration: underline;">
      +1 (786) 567-8418
    </a>

    <div style="font-size: 0.9rem; color: var(--text-light);" data-i18n="cop-hours">
      Lunes a Viernes · 9:00 – 19:00h
    </div>
  </div>
</div>

  <section>
    <div class="container">
      <div class="demo-grid">
        <div>
          <span class="section-label" data-i18n="cop-form-label">Envíanos un mensaje</span>
          <h2 class="section-title" style="font-size: 1.8rem;" data-i18n="cop-form-title">¿Tienes alguna pregunta?</h2>
          <form onsubmit="handleForm(event)" class="js-racb-form" data-form="demo">
            <input type="hidden" name="form_type" value="demo">
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
                <div style="font-size: 0.9rem; color: var(--text-light);"><a href="mailto:hello@racbconsulting.com">hello@racbconsulting.com</a></div>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon">📱</div>
              <div>
                <div style="font-weight: 700; color: var(--secondary); margin-bottom: 0.25rem;" data-i18n="cop-wa-label">WhatsApp / Teléfono</div>
                <div style="font-size: 0.9rem; color: var(--text-light);">
  <a href="#" class="js-wa" data-phone="17865678418" data-text="Hola, quiero información sobre sus servicios de IA" style="color: var(--primary); font-weight: 600;">
    +1 (786) 567-8418
  </a>
</div>
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

<!-- PRIVACY MODAL -->
<div id="privacy-modal" role="dialog" aria-modal="true" aria-label="Política de Privacidad">
  <div class="privacy-box">
    <button class="privacy-close" onclick="closePrivacy()" aria-label="Cerrar">✕</button>
    <h2>Política de Privacidad</h2>
    <p style="font-size:0.82rem; color:#999; margin-bottom:1rem;">Última actualización: Enero 2026</p>

    <h3>1. Responsable del tratamiento</h3>
    <p>RACBCONSULTING es responsable del tratamiento de los datos personales recabados a través de este sitio web (<a href="mailto:hello@racbconsulting.com">hello@racbconsulting.com</a>).</p>

    <h3>2. Datos que recopilamos</h3>
    <ul>
      <li>Nombre y correo electrónico al enviar formularios de contacto o demo</li>
      <li>Empresa y descripción de necesidades, cuando se proporcionan voluntariamente</li>
      <li>Datos de navegación anónimos (páginas visitadas, tiempo en sitio) vía Google Analytics</li>
    </ul>

    <h3>3. Finalidad del tratamiento</h3>
    <ul>
      <li>Responder a solicitudes de información y cotizaciones</li>
      <li>Agendar y gestionar demostraciones de nuestros servicios</li>
      <li>Enviar comunicaciones comerciales relacionadas con IA para negocios (con consentimiento previo)</li>
      <li>Mejorar la experiencia del sitio web mediante análisis anónimo</li>
    </ul>

    <h3>4. Base legal</h3>
    <p>El tratamiento se basa en el consentimiento del interesado al enviar formularios, y en el interés legítimo de RACBCONSULTING para la gestión comercial.</p>

    <h3>5. Conservación de datos</h3>
    <p>Los datos se conservan mientras exista una relación comercial activa o hasta que el usuario solicite su supresión. Los datos de formularios se conservan un máximo de 3 años.</p>

    <h3>6. Derechos del usuario</h3>
    <p>Puedes ejercer tus derechos de acceso, rectificación, supresión, oposición, portabilidad y limitación escribiendo a <strong><a href="mailto:hello@racbconsulting.com">hello@racbconsulting.com</a></strong> con el asunto "Protección de Datos".</p>

    <h3>7. Cookies</h3>
    <p>Este sitio utiliza cookies analíticas de Google Analytics (anonimizadas) y cookies de funcionalidad. Puedes desactivarlas desde la configuración de tu navegador.</p>

    <h3>8. Compartición de datos</h3>
    <p>No vendemos ni cedemos datos personales a terceros. Podemos compartir datos con proveedores de servicios (Google Workspace, CRM) bajo contratos de confidencialidad.</p>

    <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--border); text-align:center;">
      <button onclick="closePrivacy()" style="background:var(--gradient); color:white; border:none; padding:0.75rem 2rem; border-radius:100px; cursor:pointer; font-family:inherit; font-weight:600; font-size:0.9rem;">Entendido</button>
    </div>
  </div>
</div>



<!-- WhatsApp Floating Button -->
<a href="#" class="wa-float js-wa" data-phone="17865678418"
   data-text="Hola quiero información sobre sus servicios de IA"
   title="Habla con un experto">
  💬
</a>

<!-- SUCCESS TOAST -->
<div id="toast" data-i18n="toast-msg">
  ✅ ¡Mensaje enviado! Te contactaremos pronto.
</div>
