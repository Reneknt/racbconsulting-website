<?php
/**
 * RACBCONSULTING — template-parts/page-home.php
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
          <a href="#" class="btn-primary" onclick="showPage('demo')" data-i18n="hero-btn1">🚀 Solicita una Demo</a>
          <a href="#" class="btn-outline" onclick="showPage('services')" data-i18n="hero-btn2">Ver Servicios →</a>
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
            <a href="#" class="service-link" onclick="showPage('services')" data-i18n="ver-mas">Ver más →</a>
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
            <a href="#" class="service-link" onclick="showPage('services')" data-i18n="ver-mas">Ver más →</a>
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
            <a href="#" class="service-link" onclick="showPage('services')" data-i18n="ver-mas">Ver más →</a>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 3rem;" class="reveal">
        <a href="#" class="btn-primary" onclick="showPage('services')" style="background: var(--gradient); color: white; display: inline-flex;" data-i18n="services-btn">Ver todos los servicios →</a>
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
        <a href="#" class="btn-primary" onclick="showPage('blog')" style="background: var(--gradient); color: white; display: inline-flex;" data-i18n="blog-btn">Ver todos los artículos →</a>
      </div>
    </div>
  </section>

  <!-- CTA BAND -->
  <div class="cta-band">
    <div class="container">
      <h2 class="reveal">¿Listo para transformar tu negocio con IA?</h2>
      <p class="reveal" data-i18n="cta-sub">Agenda una consultoría gratuita de 30 minutos y descubre cómo la IA puede generar resultados reales para tu PYME.</p>
      <div class="cta-band-btns reveal">
        <a href="#" class="btn-primary" onclick="showPage('demo')" data-i18n="cta-btn1">🚀 Agenda tu Demo IA</a>
        <a href="#" class="js-wa" data-phone="1234567890" data-text="Hola, quiero información sobre sus servicios de IA" class="btn-outline" target="_blank" data-i18n="cta-btn2">💬 Habla con un Experto (WhatsApp)</a>
      </div>
    </div>
  </div>

</div><!-- /home page -->
