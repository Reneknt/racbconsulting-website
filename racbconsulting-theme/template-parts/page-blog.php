<?php
/**
 * RACBCONSULTING — template-parts/page-blog.php
 */
?>

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
