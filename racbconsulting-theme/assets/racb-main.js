/**
 * RACBCONSULTING — Main JavaScript
 * Single Page Application navigation + Bilingual support
 */
(function() {
  'use strict';

  // ===== PAGE NAVIGATION =====
  function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    const page = document.getElementById('page-' + name);
    if (page) page.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
    closeNav();
    setTimeout(initReveal, 100);
  }

  // ===== MOBILE NAV =====
  function toggleNav() {
    const nl = document.getElementById('navLinks');
    if (nl) nl.classList.toggle('open');
  }
  function closeNav() {
    const nl = document.getElementById('navLinks');
    if (nl) nl.classList.remove('open');
  }

  // ===== SERVICE TABS (services page) =====
  function filterService(btn, type) {
    // Update active tab button
    document.querySelectorAll('#page-services .service-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    // Map tab type → section IDs
    const sectionMap = {
      'web':     'svc-web',
      'chatbot': 'svc-chatbot',
      'auto':    'svc-auto',
      'email':   'svc-web',    // Coming soon → show web for now
      'crm':     'svc-chatbot' // Coming soon → show chatbot for now
    };

    // Show/hide service sections with smooth transition
    const allSections = document.querySelectorAll('#page-services .service-detail');
    allSections.forEach(s => {
      s.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
      s.style.opacity = '0';
      s.style.transform = 'translateY(10px)';
      s.style.pointerEvents = 'none';
      setTimeout(() => { s.style.display = 'none'; }, 250);
    });

    const targetId = sectionMap[type] || 'svc-web';
    const targetSection = document.getElementById(targetId);
    if (targetSection) {
      setTimeout(() => {
        allSections.forEach(s => s.style.display = 'none');
        targetSection.style.display = 'grid';
        targetSection.style.opacity = '0';
        targetSection.style.transform = 'translateY(10px)';
        requestAnimationFrame(() => {
          targetSection.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
          targetSection.style.opacity = '1';
          targetSection.style.transform = 'translateY(0)';
          targetSection.style.pointerEvents = 'auto';
        });
      }, 260);
    }
  }

  // ===== BLOG FILTERS =====
  function filterBlog(btn, category) {
    // Update active button
    document.querySelectorAll('#page-blog .service-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    const cards = document.querySelectorAll('#page-blog .blog-card');
    cards.forEach(card => {
      const cat = card.getAttribute('data-category') || '';
      const show = (category === 'all') || (cat === category);
      card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
      if (show) {
        card.style.display = '';
        requestAnimationFrame(() => {
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        });
      } else {
        card.style.opacity = '0';
        card.style.transform = 'translateY(8px)';
        setTimeout(() => { card.style.display = 'none'; }, 200);
      }
    });
  }

  // ===== PRIVACY MODAL =====
  function showPrivacy() {
    const modal = document.getElementById('privacy-modal');
    if (modal) {
      modal.style.display = 'flex';
      requestAnimationFrame(() => modal.classList.add('modal-visible'));
    }
  }
  function closePrivacy() {
    const modal = document.getElementById('privacy-modal');
    if (modal) {
      modal.classList.remove('modal-visible');
      setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
  }

  // ===== ADVISOR CHAT MODAL =====

  const ADVISOR_REPLY = 'Thank you. Based on what you shared, this may require an Executive Diagnostic to identify where execution is breaking and where revenue may be leaking.';
  const MVP_URL = 'https://mvp.racbconsulting.com';

  function openAdvisorModal() {
    const modal = document.getElementById('advisor-modal');
    if (!modal) return;
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
      const input = document.getElementById('advisor-chat-input');
      if (input) input.focus();
    }, 100);
  }

  function closeAdvisorModal() {
    const modal = document.getElementById('advisor-modal');
    if (!modal) return;
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    resetAdvisorChat();
  }

  function resetAdvisorChat() {
    const history = document.getElementById('advisor-chat-history');
    if (!history) return;
    // Rebuild to initial state
    history.innerHTML = `
      <div class="advisor-msg advisor-msg--assistant">
        <p>Welcome. I'm your RACBCONSULTING Executive Advisor. Tell me what is happening inside your operation, and I'll help identify the right next step.</p>
      </div>
      <div id="advisor-quick-prompts" class="advisor-quick-prompts">
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">We are losing leads</button>
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">Scheduling is chaotic</button>
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">Follow-up is inconsistent</button>
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">Operations feel overloaded</button>
      </div>`;
    const input = document.getElementById('advisor-chat-input');
    if (input) input.value = '';
  }

  function appendAdvisorUserMessage(text) {
    const history = document.getElementById('advisor-chat-history');
    if (!history) return;
    const msg = document.createElement('div');
    msg.className = 'advisor-msg advisor-msg--user';
    msg.innerHTML = `<p>${escapeHtml(text)}</p>`;
    history.appendChild(msg);
    scrollAdvisorHistory();
  }

  function appendAdvisorAssistantMessage() {
    const history = document.getElementById('advisor-chat-history');
    if (!history) return;
    const wrap = document.createElement('div');
    wrap.className = 'advisor-msg advisor-msg--assistant';
    wrap.innerHTML = `<p>${ADVISOR_REPLY}</p>`;
    history.appendChild(wrap);
    // TODO: MVP dependency — CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project.
    const cta = document.createElement('a');
    cta.href = MVP_URL;
    cta.target = '_blank';
    cta.rel = 'noopener';
    cta.className = 'advisor-chat-cta';
    cta.textContent = 'Book Executive Diagnostic';
    history.appendChild(cta);
    scrollAdvisorHistory();
  }

  function scrollAdvisorHistory() {
    const history = document.getElementById('advisor-chat-history');
    if (history) history.scrollTop = history.scrollHeight;
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  function sendAdvisorMessage() {
    const input = document.getElementById('advisor-chat-input');
    if (!input) return;
    const text = input.value.trim();
    if (!text) return;
    input.value = '';
    hideAdvisorQuickPrompts();
    appendAdvisorUserMessage(text);
    setTimeout(appendAdvisorAssistantMessage, 600);
  }

  function sendAdvisorPrompt(btn) {
    const text = btn.textContent.trim();
    hideAdvisorQuickPrompts();
    appendAdvisorUserMessage(text);
    setTimeout(appendAdvisorAssistantMessage, 600);
  }

  function hideAdvisorQuickPrompts() {
    const prompts = document.getElementById('advisor-quick-prompts');
    if (prompts) prompts.remove();
  }

  function handleAdvisorKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendAdvisorMessage();
    }
  }

  // ===== FORM HANDLER =====
  async function handleForm(e) {
  e.preventDefault();

  const form = e.target;
  const toast = document.getElementById('toast');

  // Fallback if AJAX not available
  if (typeof racbAjax === 'undefined' || !racbAjax.ajax_url) {
    if (toast) {
      toast.textContent = '✅ ¡Mensaje enviado! Te contactaremos pronto.';
      toast.classList.add('show');
      clearTimeout(window.__racbToastTimer);
      window.__racbToastTimer = setTimeout(() => toast.classList.remove('show'), 3500);
    }
    form.reset();
    return false;
  }

  // Collect form data
  const fd = new FormData(form);
  fd.append('action', 'racb_contact');
  fd.append('nonce', racbAjax.nonce || '');
  fd.append('page', document.querySelector('.page.active')?.id || window.location.pathname);
  fd.append('lang', window.currentLang || (document.documentElement.lang || 'es'));

  // UTM capture (optional)
  const params = new URLSearchParams(window.location.search);
  fd.append('utm_source', params.get('utm_source') || '');
  fd.append('utm_medium', params.get('utm_medium') || '');
  fd.append('utm_campaign', params.get('utm_campaign') || '');

  // UX: disable submit
  const btn = form.querySelector('button[type="submit"]');
  const btnText = btn ? btn.textContent : '';
  if (btn) { btn.disabled = true; btn.textContent = 'Enviando...'; }

  try {
    const res = await fetch(racbAjax.ajax_url, {
      method: 'POST',
      credentials: 'same-origin',
      body: fd
    });
    const data = await res.json();

    const msg = data?.data?.message || (data?.success ? '✅ ¡Mensaje enviado!' : '❌ No se pudo enviar. Intenta de nuevo.');
    if (toast) {
      toast.textContent = msg;
      toast.classList.add('show');
      clearTimeout(window.__racbToastTimer);
      window.__racbToastTimer = setTimeout(() => toast.classList.remove('show'), 4000);
    }

    if (data?.success) form.reset();
  } catch (err) {
    if (toast) {
      toast.textContent = '❌ Error de conexión. Intenta nuevamente.';
      toast.classList.add('show');
      clearTimeout(window.__racbToastTimer);
      window.__racbToastTimer = setTimeout(() => toast.classList.remove('show'), 4000);
    }
  } finally {
    if (btn) { btn.disabled = false; btn.textContent = btnText; }
  }

  return false;
}

  // ===== SCROLL REVEAL =====
  let revealObserver;
  function initReveal() {
    try { if (revealObserver) revealObserver.disconnect(); } catch(e) {}
    revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.08 });

    document.querySelectorAll('.reveal').forEach(el => {
      // avoid re-observing already visible elements
      if (!el.classList.contains('visible')) {
        revealObserver.observe(el);
      }
    });
  }

  // ===== NAV SCROLL SHADOW =====
  window.addEventListener('scroll', () => {
    const nav = document.getElementById('main-nav');
    if (nav) nav.style.boxShadow = window.scrollY > 40
      ? '0 4px 24px rgba(0,0,0,0.10)'
      : '0 2px 16px rgba(0,0,0,0.06)';
  });

  // ===== BILINGUAL SUPPORT =====
  const translations = {
    es: {
      "auth1-name": "María Castro",
      "auth1-role": "CEO – Clínica Dental Sonrisa",
      "auth2-name": "Jorge Reyes",
      "auth2-role": "Director – Distribuidora MX Norte",
      "auth3-name": "Lic. Laura Pérez",
      "auth3-role": "Abogada independiente",
      "bcat-all": "Todos",
      "bcat1": "💬 Chatbots",
      "bcat2": "⚙️ Automatización",
      "bcat3": "🤖 IA GPT",
      "bcat4": "🌐 Web con IA",
      "ben1-text": "Desde la primera reunión hasta tu solución IA funcionando en producción en menos de 4 semanas. Sin fricciones, sin proyectos interminables.",
      "ben2-text": "Cada solución incluye métricas de seguimiento. Verás exactamente cuánto tiempo ahorras, cuántos leads captas y cuánto crece tu facturación con IA.",
      "ben3-text": "No te dejamos solo. Capacitamos a tu equipo, optimizamos tu IA y escalamos contigo. Tenemos planes de soporte para todas las necesidades.",
      "benefits-label": "¿Por qué RACBCONSULTING?",
      "benefits-sub": "No vendemos tecnología por la tecnología. Implementamos soluciones de IA que resuelven problemas reales y aumentan tus ingresos.",
      "benefits-title": "IA que genera resultados medibles para tu PYME",
      "blog-btn": "Ver todos los artículos →",
      "blog-label": "Blog IA",
      "blog-sub": "Artículos prácticos, sin tecnicismos, escritos para dueños de PYMES que quieren resultados.",
      "blog-title": "Aprende a implementar IA en tu negocio",
      "blog1-cat": "Chatbots",
      "blog1-date": "15 Feb 2025",
      "blog1-title": "Cómo un chatbot GPT puede triplicar tus ventas en línea",
      "blog1-excerpt": "Descubre cómo implementar un agente GPT en tu sitio web para calificar leads automáticamente...",
      "blog2-cat": "Automatización",
      "blog2-date": "8 Feb 2025",
      "blog2-title": "5 procesos de tu PYME que puedes automatizar con IA esta semana",
      "blog2-excerpt": "Desde facturación hasta seguimiento de clientes, aquí están los procesos más fáciles de automatizar con herramientas accesibles.",
      "blog3-cat": "Web con IA",
      "blog3-date": "1 Feb 2025",
      "blog3-title": "WordPress + IA: La combinación que revolucionará tu sitio web en 2025",
      "blog3-excerpt": "Los plugins de IA para WordPress que están cambiando la forma en que las PYMEs generan contenido...",
      "bp-sub": "Artículos prácticos sobre chatbots, automatización, IA GPT y más. Sin jerga técnica, con resultados reales.",
      "bp-title": "Aprende a implementar IA en tu PYME",
      "bp1-excerpt": "Descubre cómo implementar un agente GPT en tu sitio web para calificar leads automáticamente y nunca perder una oportunidad de venta.",
      "bp3-excerpt": "Los mejores plugins de IA para WordPress que están cambiando la forma en que las PYMEs generan contenido y captan leads.",
      "bp4-title": "Qué es un Agente GPT y cómo puede reemplazar tareas humanas en tu empresa",
      "bp4-excerpt": "Explicación práctica de los agentes GPT y casos de uso reales para negocios de todos los tamaños en Latinoamérica.",
      "bp5-title": "Correo corporativo con IA: Cómo tu bandeja de entrada puede trabajar sola",
      "bp5-excerpt": "Implementa filtros inteligentes, respuestas automáticas y clasificación IA para procesar correos en segundos en lugar de horas.",
      "bp6-title": "CRM + IA: La fórmula para no perder ningún cliente jamás",
      "bp6-excerpt": "Cómo integrar Inteligencia Artificial en tu CRM para predecir qué clientes están listos para comprar y cuáles en riesgo de irse.",
      "btn-submit": "🚀 Solicitar Demo Gratuita",
      "c1-ind": "Salud",
      "c1-name": "Clínica Dental Sonrisa Plus",
      "c1-prob": "50% de llamadas sin respuesta. Recepcionista saturada.",
      "c1-sol": "Agente GPT + agendamiento automático en WhatsApp y web.",
      "c1-result": "Citas agendadas automáticamente en el primer mes",
      "c2-ind": "Distribución",
      "c2-name": "Distribuidora MX Norte",
      "c2-prob": "Seguimiento de pedidos manual, errores frecuentes y retrasos.",
      "c2-sol": "Automatización completa de pedidos y notificaciones con IA.",
      "c2-result": "Reducción de costos operativos en 60 días",
      "c3-ind": "Legal",
      "c3-name": "Despacho Pérez & Asociados",
      "c3-prob": "Imagen poco profesional, sin presencia digital, sin sistema de contacto.",
      "c3-sol": "Web profesional + chatbot GPT + correo corporativo + IA.",
      "c3-result": "Más consultas orgánicas via Google en 3 meses",
      "c4-ind": "E-commerce",
      "c4-name": "TiendaModa.mx",
      "c4-prob": "Abandono de carrito del 78%. Sin seguimiento post-visita.",
      "c4-sol": "CRM + IA con flujos de recuperación de carrito y upsell automático.",
      "c4-result": "Incremento en ventas totales en 45 días",
      "c5-ind": "Educación",
      "c5-name": "Instituto Innova Tech",
      "c5-prob": "Proceso de inscripción lento. Leads sin seguimiento estructurado.",
      "c5-sol": "Agente GPT + automatización inscripción + CRM con IA.",
      "c5-result": "Tasa de cierre de inscripciones vs año anterior",
      "c6-ind": "Servicios",
      "c6-name": "Plomería Rápida 24h",
      "c6-prob": "Sin presencia web, todo por recomendación. Crecimiento estancado.",
      "c6-sol": "Web local SEO + chatbot + Google My Business + IA de cotización.",
      "c6-result": "Nuevos clientes en los primeros 90 días",
      "cal-sub": "Sesión de 30 min · Elige día y hora según tu disponibilidad",
      "cal-title": "Agendar en Calendly",
      "case-prob-label": "Problema",
      "case-sol-label": "Solución IA",
      "chat-badge": "⚡ Respuesta en &lt;2 seg",
      "chat-msg1": "¿Puedes atender a mis clientes automáticamente?",
      "chat-msg2": "¿Cuánto tiempo tarda en estar listo?",
      "chat-reply1": "¡Sí! Implementamos un agente GPT personalizado con el conocimiento de tu empresa, disponible 24/7 para responder preguntas, agendar citas y calificar leads.",
      "chat-sub": "Asistente IA para tu negocio",
      "chat-title": "Agente GPT RACBCONSULTING",
      "contact-alt-label": "Otras formas de contactarnos",
      "contact-alt-sub": "Contamos con múltiples canales para que elijas el que más te comode.",
      "contact-alt-title": "Elige cómo hablar con nosotros",
      "cop-btn": "Enviar mensaje →",
      "cop-cal-label": "Agendar Consultoría",
      "cop-cal-link": "Abrir Calendly →",
      "cop-cal-sub": "Sesiones de 30 min gratuitas",
      "cop-email-label": "Correo Electrónico",
      "cop-field-email": "Email *",
      "cop-field-msg": "Mensaje *",
      "cop-field-name": "Nombre *",
      "cop-field-subject": "Asunto",
      "cop-form-label": "Envíanos un mensaje",
      "cop-form-title": "¿Tienes alguna pregunta?",
      "cop-hours": "Lunes a Viernes · 9:00 – 19:00h",
      "cop-info-label": "Nuestros datos",
      "cop-info-title": "Información de contacto",
      "cop-loc-label": "Ubicación",
      "cop-loc-sub": "Consultoría 100% remota y presencial",
      "cop-loc-text": "Servicios disponibles en toda Latinoamérica",
      "cop-sub": "Estamos listos para ayudarte a dar el primer paso hacia la transformación digital con IA.",
      "cop-title": "Hablemos de tu proyecto",
      "cop-wa-label": "WhatsApp / Teléfono",
      "cp-cta-btn": "🚀 Quiero resultados como estos",
      "cp-cta-sub": "Agenda una consultoría y analicemos juntos cómo la IA puede transformar los resultados de tu negocio.",
      "cp-cta-title": "¿Tu empresa podría ser el próximo caso de éxito?",
      "cp-sub": "No hablamos de promesas. Aquí están los resultados comprobables que hemos logrado para negocios como el tuyo.",
      "cp-title": "Resultados reales de PYMEs que ya usan IA con RACBCONSULTING",
      "cta-btn1": "🚀 Agenda tu Demo IA",
      "cta-btn2": "💬 Habla con un Experto (WhatsApp)",
      "cta-sub": "Agenda una consultoría gratuita de 30 minutos y descubre cómo la IA puede generar resultados reales para tu PYME.",
      "cta-title": "¿Listo para transformar tu negocio con IA?",
      "demo-form-label": "Formulario de contacto",
      "demo-form-sub": "Completa el formulario y un consultor de RACBCONSULTING te contactará en menos de 24 horas para entender tus necesidades.",
      "demo-form-title": "Cuéntanos sobre tu negocio",
      "demo-get-title": "¿Qué obtienes en tu Demo?",
      "demo-get1": "Diagnóstico personalizado de tu negocio",
      "demo-get2": "Demo en vivo de las soluciones IA aplicadas a tu industria",
      "demo-get3": "Propuesta inicial con estimado de ROI",
      "demo-get4": "Preguntas y respuestas sin compromiso",
      "dp-sub": "30 minutos para mostrarte cómo la IA puede transformar tu negocio. Sin compromiso, sin tecnicismos.",
      "dp-title": "Agenda tu Demo IA Gratuita",
      "field-comments": "Comentarios / Descripción de tu necesidad",
      "field-company": "Empresa",
      "field-email": "Correo electrónico *",
      "field-name": "Nombre completo *",
      "field-service": "Servicio de interés *",
      "footer-copyright": "© 2025 RACBCONSULTING. Todos los derechos reservados.",
      "footer-desc": "Implementamos soluciones de Inteligencia Artificial para PYMEs y profesionales que quieren resultados reales y crecimiento medible.",
      "footer-schedule": "Agendar llamada",
      "ft-company3": "Demo Gratuita",
      "ft-h-company": "Empresa",
      "ft-h-contact": "Contacto",
      "ft-h-services": "Servicios",
      "ft-privacy": "Privacidad",
      "ft-schedule": "Agendar llamada",
      "ft-svc1": "Web con IA",
      "ft-svc2": "Chatbots GPT",
      "ft-svc3": "Automatización",
      "ft-svc4": "Correo + IA",
      "ft-svc5": "CRM + IA",
      "hero-badge": "Especialistas en IA para TEST LOCAL OK",
      "hero-btn1": "🚀 Solicita una Demo",
      "hero-btn2": "Ver Servicios →",
      "hero-stat1-label": "PYMEs atendidas",
      "hero-stat2-label": "Reducción de costos",
      "hero-stat3-label": "Soporte IA activo",
      "hero-sub": "Soluciones de Inteligencia Artificial diseñadas específicamente para PYMES y profesionales que quieren resultados reales, no promesas vacías.",
      "hero-title": "Te ayudamos a implementar la <em>IA de manera práctica</em> para hacer crecer tu negocio",
      "ia-active": "IA Activa ahora",
      "mail-sub": "hello@racbconsulting.com · Respuesta &lt; 24h",
      "mail-title": "Correo Electrónico",
      "nav-blog": "Blog",
      "nav-cases": "Casos de Éxito",
      "nav-contact": "Contacto",
      "nav-cta": "Agenda tu Demo IA",
      "nav-home": "Inicio",
      "nav-services": "Servicios IA",
      "opt-select": "Selecciona un servicio...",
      "opt1": "Desarrollo Web Inteligente con IA",
      "opt2": "Chatbots y Agentes GPT",
      "opt3": "Automatización de Procesos",
      "opt4": "Correo Corporativo + IA",
      "opt5": "Integraciones CRM + IA",
      "opt6": "No sé, quiero asesoría",
      "process-label": "Nuestro Proceso",
      "process-title": "De la idea a la IA funcionando en 4 pasos",
      "services-btn": "Ver todos los servicios →",
      "services-label": "Nuestros Servicios",
      "services-sub": "Desde automatizar tu atención al cliente hasta transformar tu web en una máquina de ventas con IA.",
      "services-title": "Soluciones de IA para cada etapa de tu negocio",
      "sp-cta-btn": "Agendar Consultoría Gratuita",
      "sp-cta-sub": "Agenda una consultoría gratuita y te ayudamos a identificar qué servicio de IA tiene mayor impacto para tu negocio.",
      "sp-cta-title": "¿Qué solución necesitas para tu PYME?",
      "sp-sub": "Implementamos tecnología de Inteligencia Artificial adaptada a tu industria, presupuesto y objetivos de negocio.",
      "sp-title": "Soluciones de IA para PYMES y Profesionales",
      "sp1-label": "Servicio 01",
      "sp1-p1": "Tu sitio web debería ser tu mejor vendedor. Creamos sitios web potenciados con Inteligencia Artificial que personalizan la experiencia de cada visitante, generan contenido SEO automáticamente y convierten más visitas en clientes.",
      "sp1-p2": "Construidos en WordPress con los últimos plugins de IA, tus páginas aprenden de tus visitantes y mejoran continuamente sin que tengas que hacer nada manual.",
      "sp1-title": "Desarrollo Web Inteligente con IA para tu Negocio",
      "sp1-visual-sub": "Con IA integrada, tu sitio se convierte en un activo que genera leads incluso mientras duermes.",
      "sp1-visual-title": "Web que trabaja por ti",
      "sp2-label": "Servicio 02",
      "sp2-p1": "Un chatbot inteligente WordPress no es solo una ventana de chat. Es un agente GPT entrenado con la información de tu empresa, capaz de vender, agendar citas, resolver dudas y escalar a humanos cuando es necesario.",
      "sp2-p2": "Disponible en tu web, WhatsApp, Instagram y más canales, trabajando 24/7 para que nunca pierdas una oportunidad de negocio.",
      "sp2-title": "Chatbots Inteligentes y Agentes GPT para Atención al Cliente",
      "sp2-visual-sub": "Un agente que conoce tu negocio perfectamente y responde como tú lo haría, pero disponible siempre.",
      "sp2-visual-title": "Agente GPT para atención",
      "sp3-label": "Servicio 03",
      "sp3-p1": "¿Tu equipo pierde horas en tareas repetitivas? La automatización inteligente conecta tus herramientas, elimina procesos manuales y te permite enfocarte en lo que realmente hace crecer tu negocio.",
      "sp3-p2": "Usamos n8n, Make y Zapier con capas de IA para crear flujos que antes requerían personal dedicado, ahora funcionan solos.",
      "sp3-title": "Automatización de Procesos con IA para PYMES",
      "sp3-visual-sub": "Automatiza las tareas repetitivas y libera a tu equipo para lo que realmente importa.",
      "sp3-visual-title": "Flujos que trabajan solos",
      "stat1-num": "+120",
      "stat2-num": "40%",
      "stat3-num": "24/7",
      "step1-text": "Analizamos tu negocio para identificar dónde la IA tiene mayor impacto en menos tiempo.",
      "step1-title": "Diagnóstico Gratuito",
      "step2-text": "Diseñamos una hoja de ruta con herramientas específicas, plazos y KPIs de éxito medibles.",
      "step2-title": "Diseño de Solución",
      "step3-text": "Desplegamos, probamos e integramos la IA en tu operación con mínima interrupción del negocio.",
      "step3-title": "Implementación",
      "step4-text": "Monitoreamos, ajustamos y mejoramos continuamente para que tu IA siempre entregue los mejores resultados.",
      "step4-title": "Optimización",
      "svc-quote-btn": "Solicitar cotización →",
      "svc1-desc": "Sitios web que no solo se ven bien, sino que usan IA para personalizar la experiencia de cada visitante y convertir más.",
      "svc1-title": "Desarrollo Web Inteligente con IA",
      "svc2-desc": "Agentes GPT entrenados con el conocimiento de tu empresa para atender, vender y calificar leads las 24 horas del día.",
      "svc2-title": "Chatbots y Agentes GPT",
      "svc3-desc": "Elimina tareas repetitivas con flujos IA. Conectamos tus herramientas y automatizamos procesos que hoy hacen manualmente.",
      "svc3-title": "Automatización de Procesos",
      "tab1": "🌐 Web con IA",
      "tab2": "💬 Chatbots GPT",
      "tab3": "⚙️ Automatización",
      "tab4": "📧 Correo + IA",
      "tab5": "🔗 CRM + IA",
      "test-label": "Testimonios",
      "test-title": "Lo que dicen nuestros clientes",
      "test1-text": "\"El chatbot IA que RACBCONSULTING implementó en nuestra web aumentó las consultas calificadas en un 180%. Antes respondíamos emails 2 días después, ahora el agente GPT responde al instante.\"",
      "test2-text": "\"La automatización de procesos nos ahorró 3 empleados en tareas administrativas. El ROI fue evidente en el primer mes. Recomiendo RACBCONSULTING sin dudarlo.\"",
      "test3-text": "\"Pensé que la IA era solo para empresas grandes. RACBCONSULTING me demostró que con su solución de correo corporativo + IA, mi despacho jurídico ahora compite con cualquiera.\"",
      "toast-msg": "✅ ¡Mensaje enviado! Te contactaremos pronto.",
      "ver-mas": "Ver más →",
      "vs1-1": "Más conversiones",
      "vs1-2": "Menos rebote",
      "vs1-3": "Generación de leads",
      "vs1-4": "SEO Google",
      "vs2-1": "Consultas resueltas sin humano",
      "vs2-2": "Tiempo de respuesta",
      "vs2-3": "Conversaciones simultáneas",
      "vs2-4": "Leads calificados",
      "vs3-1": "Menos tiempo admin",
      "vs3-2": "Errores manuales",
      "vs3-3": "Más productividad",
      "vs3-4": "Desde el mes 1",
      "wa-sub": "Respuesta en minutos · Lunes a Viernes 9–19h",
      "wa-title": "WhatsApp Directo",
      "f1-1": "Diseño responsive mobile-first con UX optimizado por IA",
      "f1-2": "Generación automática de contenido SEO con GPT",
      "f1-3": "Chatbot integrado para atención 24/7",
      "f1-4": "Personalización dinámica de contenido por perfil de usuario",
      "f1-5": "Integración con CRM y herramientas de marketing",
      "f1-6": "Analytics IA: predicción de comportamiento de visitantes",
      "f1-7": "Velocidad de carga optimizada (Core Web Vitals)",
      "f1-8": "SEO técnico + schema.org para posicionamiento local",
      "f2-1": "Agente GPT personalizado con tu base de conocimiento",
      "f2-2": "Disponible en Web, WhatsApp Business y redes sociales",
      "f2-3": "Calificación automática de leads con IA",
      "f2-4": "Agendamiento de citas integrado con tu calendario",
      "f2-5": "Escalación inteligente a humanos",
      "f2-6": "Panel de analytics y conversaciones",
      "f2-7": "Integración con CRM y email marketing",
      "f2-8": "Soporte multiidioma (español, inglés y más)",
      "f3-1": "Mapeo y diagnóstico de procesos automatizables",
      "f3-2": "Automatización de seguimiento de prospectos y clientes",
      "f3-3": "Flujos de facturación y cobranza automática",
      "f3-4": "Reportes y dashboards generados por IA",
      "f3-5": "Integración entre herramientas (CRM, ERP, contabilidad)",
      "f3-6": "Notificaciones inteligentes por email y WhatsApp",
      "f3-7": "Clasificación y enrutamiento automático de correos",
      "f3-8": "Entrenamiento de tu equipo en los nuevos flujos",
      "bp-label": "Blog de IA para Negocios",
      "sp-label": "Catálogo de Servicios",
      "cp-label": "Casos de Éxito",
      "dp-label": "Demo & Cotización",
      "cop-label": "Contacto"
},
    en: {
      "auth1-name": "María Castro",
      "auth1-role": "CEO – Dental Clinic Sonrisa",
      "auth2-name": "Jorge Reyes",
      "auth2-role": "Director – Distribuidora MX Norte",
      "auth3-name": "Laura Pérez, Esq.",
      "auth3-role": "Independent Attorney",
      "bcat-all": "All",
      "bcat1": "💬 Chatbots",
      "bcat2": "⚙️ Automation",
      "bcat3": "🤖 GPT AI",
      "bcat4": "🌐 AI Web",
      "ben1-text": "From the first meeting to your AI solution live in production in under 4 weeks. No friction, no endless projects.",
      "ben2-text": "Every solution includes tracking metrics. You will see exactly how much time you save, how many leads you capture and how much your revenue grows with AI.",
      "ben3-text": "We don't leave you alone. We train your team, optimize your AI and scale with you. We have support plans for every need.",
      "benefits-label": "Why RACBCONSULTING?",
      "benefits-sub": "We don't sell technology for technology's sake. We implement AI solutions that solve real problems and grow your revenue.",
      "benefits-title": "AI that generates measurable results for your SMB",
      "blog-btn": "View all articles →",
      "blog-label": "AI Blog",
      "blog-sub": "Practical articles, no jargon, written for SMB owners who want real results.",
      "blog-title": "Learn how to implement AI in your business",
      "blog1-cat": "Chatbots",
      "blog1-date": "Feb 15, 2025",
      "blog1-title": "How a GPT chatbot can triple your online sales",
      "blog1-excerpt": "Discover how to implement a GPT agent on your website to automatically qualify leads...",
      "blog2-cat": "Automation",
      "blog2-date": "Feb 8, 2025",
      "blog2-title": "5 SMB processes you can automate with AI this week",
      "blog2-excerpt": "From invoicing to customer follow-up, here are the easiest processes to automate with accessible tools.",
      "blog3-cat": "AI Web",
      "blog3-date": "Feb 1, 2025",
      "blog3-title": "WordPress + AI: The combination that will revolutionize your website in 2025",
      "blog3-excerpt": "The AI plugins for WordPress changing the way SMBs generate content...",
      "bp-sub": "Practical articles on chatbots, automation, GPT AI and more. No jargon, real results.",
      "bp-title": "Learn to implement AI in your SMB",
      "bp1-excerpt": "Discover how to implement a GPT agent on your website to automatically qualify leads and never miss a sales opportunity.",
      "bp3-excerpt": "The best AI plugins for WordPress that are changing the way SMBs generate content and capture leads.",
      "bp4-title": "What is a GPT Agent and how can it replace human tasks in your company",
      "bp4-excerpt": "Practical explanation of GPT agents and real use cases for businesses of all sizes in Latin America.",
      "bp5-title": "Corporate email with AI: How your inbox can work on its own",
      "bp5-excerpt": "Implement smart filters, automated replies and AI classification to process emails in seconds instead of hours.",
      "bp6-title": "CRM + AI: The formula for never losing a customer again",
      "bp6-excerpt": "How to integrate Artificial Intelligence into your CRM to predict which customers are ready to buy and which are at risk of leaving.",
      "btn-submit": "🚀 Request Free Demo",
      "c1-ind": "Healthcare",
      "c1-name": "Sonrisa Plus Dental Clinic",
      "c1-prob": "50% of calls unanswered. Overwhelmed receptionist.",
      "c1-sol": "GPT Agent + automatic scheduling via WhatsApp and web.",
      "c1-result": "Appointments booked automatically in the first month",
      "c2-ind": "Distribution",
      "c2-name": "Distribuidora MX Norte",
      "c2-prob": "Manual order tracking, frequent errors and delays.",
      "c2-sol": "Full automation of orders and notifications with AI.",
      "c2-result": "Reduction in operating costs in 60 days",
      "c3-ind": "Legal",
      "c3-name": "Pérez & Associates Law Firm",
      "c3-prob": "Unprofessional image, no digital presence, no contact system.",
      "c3-sol": "Professional website + GPT chatbot + corporate email + AI.",
      "c3-result": "More organic inquiries via Google in 3 months",
      "c4-ind": "E-commerce",
      "c4-name": "TiendaModa.mx",
      "c4-prob": "78% cart abandonment. No post-visit follow-up.",
      "c4-sol": "CRM + AI with cart recovery and automatic upsell flows.",
      "c4-result": "Increase in total sales in 45 days",
      "c5-ind": "Education",
      "c5-name": "Instituto Innova Tech",
      "c5-prob": "Slow enrollment process. Leads with no structured follow-up.",
      "c5-sol": "GPT Agent + enrollment automation + AI CRM.",
      "c5-result": "Enrollment closing rate vs previous year",
      "c6-ind": "Services",
      "c6-name": "Plomería Rápida 24h",
      "c6-prob": "No web presence, all by word of mouth. Stagnant growth.",
      "c6-sol": "Local SEO website + chatbot + Google My Business + AI quoting.",
      "c6-result": "New customers in the first 90 days",
      "cal-sub": "30-min session · Pick your preferred day and time",
      "cal-title": "Schedule on Calendly",
      "case-prob-label": "Problem",
      "case-sol-label": "AI Solution",
      "chat-badge": "⚡ Response in &lt;2 sec",
      "chat-msg1": "Can you handle my customers automatically?",
      "chat-msg2": "How long until it is live?",
      "chat-reply1": "Yes! We deploy a custom GPT agent trained on your business knowledge, available 24/7 to answer questions, schedule appointments and qualify leads.",
      "chat-sub": "AI Assistant for your business",
      "chat-title": "RACBCONSULTING GPT Agent",
      "contact-alt-label": "Other ways to reach us",
      "contact-alt-sub": "We have multiple channels so you can choose what works best for you.",
      "contact-alt-title": "Choose how to talk to us",
      "cop-btn": "Send message →",
      "cop-cal-label": "Schedule Consultation",
      "cop-cal-link": "Open Calendly →",
      "cop-cal-sub": "Free 30-min sessions available",
      "cop-email-label": "Email Address",
      "cop-field-email": "Email *",
      "cop-field-msg": "Message *",
      "cop-field-name": "Name *",
      "cop-field-subject": "Subject",
      "cop-form-label": "Send us a message",
      "cop-form-title": "Do you have a question?",
      "cop-hours": "Monday to Friday · 9:00 AM – 7:00 PM",
      "cop-info-label": "Our details",
      "cop-info-title": "Contact information",
      "cop-loc-label": "Location",
      "cop-loc-sub": "100% remote and in-person consulting",
      "cop-loc-text": "Services available throughout Latin America",
      "cop-sub": "We are ready to help you take the first step toward digital transformation with AI.",
      "cop-title": "Let's talk about your project",
      "cop-wa-label": "WhatsApp / Phone",
      "cp-cta-btn": "🚀 I want results like these",
      "cp-cta-sub": "Book a consultation and let's analyze together how AI can transform your business results.",
      "cp-cta-title": "Could your company be the next success story?",
      "cp-sub": "We don't talk about promises. Here are the verifiable results we've achieved for businesses like yours.",
      "cp-title": "Real results from SMBs already using AI with RACBCONSULTING",
      "cta-btn1": "🚀 Book your AI Demo",
      "cta-btn2": "💬 Talk to an Expert (WhatsApp)",
      "cta-sub": "Book a free 30-minute consultation and discover how AI can generate real results for your SMB.",
      "cta-title": "Ready to transform your business with AI?",
      "demo-form-label": "Contact form",
      "demo-form-sub": "Fill in the form and a RACBCONSULTING consultant will reach out within 24 hours to understand your needs.",
      "demo-form-title": "Tell us about your business",
      "demo-get-title": "What do you get in your Demo?",
      "demo-get1": "Personalized diagnosis of your business",
      "demo-get2": "Live demo of AI solutions applied to your industry",
      "demo-get3": "Initial proposal with ROI estimate",
      "demo-get4": "Q&A with no commitment",
      "dp-sub": "30 minutes to show you how AI can transform your business. No commitment, no jargon.",
      "dp-title": "Book Your Free AI Demo",
      "field-comments": "Comments / Description of your need",
      "field-company": "Company",
      "field-email": "Email address *",
      "field-name": "Full name *",
      "field-service": "Service of interest *",
      "footer-copyright": "© 2025 RACBCONSULTING. All rights reserved.",
      "footer-desc": "We implement Artificial Intelligence solutions for SMBs and professionals who want real results and measurable growth.",
      "footer-schedule": "Schedule a call",
      "ft-company3": "Free Demo",
      "ft-h-company": "Company",
      "ft-h-contact": "Contact",
      "ft-h-services": "Services",
      "ft-privacy": "Privacy",
      "ft-schedule": "Schedule a call",
      "ft-svc1": "AI Web",
      "ft-svc2": "GPT Chatbots",
      "ft-svc3": "Automation",
      "ft-svc4": "Email + AI",
      "ft-svc5": "CRM + AI",
      "hero-badge": "AI Specialists for Business",
      "hero-btn1": "🚀 Request a Demo",
      "hero-btn2": "View Services →",
      "hero-stat1-label": "SMBs served",
      "hero-stat2-label": "Cost reduction",
      "hero-stat3-label": "Active AI support",
      "hero-sub": "Artificial Intelligence solutions designed specifically for SMBs and professionals who want real results, not empty promises.",
      "hero-title": "We help you implement <em>AI in a practical way</em> to grow your business",
      "ia-active": "AI Active now",
      "mail-sub": "hello@racbconsulting.com · Reply &lt; 24h",
      "mail-title": "Email",
      "nav-blog": "Blog",
      "nav-cases": "Success Stories",
      "nav-contact": "Contact",
      "nav-cta": "Book Your AI Demo",
      "nav-home": "Home",
      "nav-services": "AI Services",
      "opt-select": "Select a service...",
      "opt1": "Intelligent Web Development with AI",
      "opt2": "Chatbots and GPT Agents",
      "opt3": "Process Automation",
      "opt4": "Corporate Email + AI",
      "opt5": "CRM + AI Integrations",
      "opt6": "I don't know, I need advice",
      "process-label": "Our Process",
      "process-title": "From idea to working AI in 4 steps",
      "services-btn": "View all services →",
      "services-label": "Our Services",
      "services-sub": "From automating your customer support to turning your website into an AI-powered sales machine.",
      "services-title": "AI solutions for every stage of your business",
      "sp-cta-btn": "Book Free Consultation",
      "sp-cta-sub": "Book a free consultation and we will help you identify which AI service has the greatest impact for your business.",
      "sp-cta-title": "What solution does your SMB need?",
      "sp-sub": "We implement AI technology tailored to your industry, budget and business objectives.",
      "sp-title": "AI Solutions for SMBs and Professionals",
      "sp1-label": "Service 01",
      "sp1-p1": "Your website should be your best salesperson. We build websites powered by Artificial Intelligence that personalize the experience for each visitor, generate SEO content automatically and convert more visits into customers.",
      "sp1-p2": "Built on WordPress with the latest AI plugins, your pages learn from your visitors and continuously improve without any manual work from you.",
      "sp1-title": "Intelligent Web Development with AI for Your Business",
      "sp1-visual-sub": "With AI integrated, your website becomes an asset that generates leads even while you sleep.",
      "sp1-visual-title": "A website that works for you",
      "sp2-label": "Service 02",
      "sp2-p1": "An intelligent WordPress chatbot is not just a chat window. It is a GPT agent trained on your business information, capable of selling, scheduling appointments, resolving doubts and escalating to humans when needed.",
      "sp2-p2": "Available on your website, WhatsApp, Instagram and more channels, working 24/7 so you never miss a business opportunity.",
      "sp2-title": "Intelligent Chatbots and GPT Agents for Customer Service",
      "sp2-visual-sub": "An agent that knows your business perfectly and responds the way you would, but always available.",
      "sp2-visual-title": "GPT Agent for customer service",
      "sp3-label": "Service 03",
      "sp3-p1": "Does your team lose hours on repetitive tasks? Intelligent automation connects your tools, eliminates manual processes and lets you focus on what really grows your business.",
      "sp3-p2": "We use n8n, Make and Zapier with AI layers to create workflows that previously required dedicated staff but now run on their own.",
      "sp3-title": "AI Process Automation for SMBs",
      "sp3-visual-sub": "Automate repetitive tasks and free your team for what really matters.",
      "sp3-visual-title": "Workflows that run themselves",
      "stat1-num": "+120",
      "stat2-num": "40%",
      "stat3-num": "24/7",
      "step1-text": "We analyze your business to identify where AI creates the biggest impact in the shortest time.",
      "step1-title": "Free Diagnosis",
      "step2-text": "We design a roadmap with specific tools, timelines and measurable success KPIs.",
      "step2-title": "Solution Design",
      "step3-text": "We deploy, test and integrate AI into your operation with minimal business disruption.",
      "step3-title": "Implementation",
      "step4-text": "We continuously monitor, adjust and improve so your AI always delivers the best results.",
      "step4-title": "Optimization",
      "svc-quote-btn": "Request a quote →",
      "svc1-desc": "Websites that not only look great but use AI to personalize each visitor's experience and convert more.",
      "svc1-title": "Intelligent Web Development with AI",
      "svc2-desc": "GPT agents trained on your company knowledge to serve, sell and qualify leads around the clock.",
      "svc2-title": "Chatbots and GPT Agents",
      "svc3-desc": "Eliminate repetitive tasks with AI flows. We connect your tools and automate processes currently done manually.",
      "svc3-title": "Process Automation",
      "tab1": "🌐 AI Web",
      "tab2": "💬 GPT Chatbots",
      "tab3": "⚙️ Automation",
      "tab4": "📧 Email + AI",
      "tab5": "🔗 CRM + AI",
      "test-label": "Testimonials",
      "test-title": "What our clients say",
      "test1-text": "\"The AI chatbot that RACBCONSULTING deployed on our website increased qualified inquiries by 180%. We used to reply to emails 2 days later — now the GPT agent responds instantly.\"",
      "test2-text": "\"The process automation saved us 3 employees' worth of administrative work. ROI was clear in the first month. I recommend RACBCONSULTING without hesitation.\"",
      "test3-text": "\"I thought AI was only for big companies. RACBCONSULTING showed me that with their corporate email + AI solution, my law firm now competes with anyone.\"",
      "toast-msg": "✅ Message sent! We will be in touch shortly.",
      "ver-mas": "Learn more →",
      "vs1-1": "More conversions",
      "vs1-2": "Less bounce",
      "vs1-3": "Lead generation",
      "vs1-4": "Google SEO",
      "vs2-1": "Queries resolved without human",
      "vs2-2": "Response time",
      "vs2-3": "Simultaneous conversations",
      "vs2-4": "Qualified leads",
      "vs3-1": "Less admin time",
      "vs3-2": "Manual errors",
      "vs3-3": "More productivity",
      "vs3-4": "From month 1",
      "wa-sub": "Response in minutes · Mon–Fri 9am–7pm",
      "wa-title": "WhatsApp Direct",
      "f1-1": "Responsive mobile-first design with AI-optimized UX",
      "f1-2": "Automatic SEO content generation with GPT",
      "f1-3": "Integrated chatbot for 24/7 support",
      "f1-4": "Dynamic content personalization by user profile",
      "f1-5": "Integration with CRM and marketing tools",
      "f1-6": "AI Analytics: visitor behavior prediction",
      "f1-7": "Optimized loading speed (Core Web Vitals)",
      "f1-8": "Technical SEO + schema.org for local positioning",
      "f2-1": "Custom GPT agent with your knowledge base",
      "f2-2": "Available on Web, WhatsApp Business and social media",
      "f2-3": "Automatic lead qualification with AI",
      "f2-4": "Appointment scheduling integrated with your calendar",
      "f2-5": "Smart escalation to humans",
      "f2-6": "Analytics and conversations dashboard",
      "f2-7": "Integration with CRM and email marketing",
      "f2-8": "Multi-language support (Spanish, English and more)",
      "f3-1": "Mapping and diagnosis of automatable processes",
      "f3-2": "Automated prospect and customer follow-up",
      "f3-3": "Invoicing and automatic collection flows",
      "f3-4": "Reports and dashboards generated by AI",
      "f3-5": "Integration between tools (CRM, ERP, accounting)",
      "f3-6": "Smart notifications via email and WhatsApp",
      "f3-7": "Automatic email classification and routing",
      "f3-8": "Team training on new workflows",
      "bp-label": "AI for Business Blog",
      "sp-label": "Service Catalog",
      "cp-label": "Success Stories",
      "dp-label": "Demo & Quote",
      "cop-label": "Contact"
}
  };

  let currentLang = 'es';
  window.currentLang = currentLang;

  function applyLang(lang) {
    const t = translations[lang];
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (t[key] !== undefined) {
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
          el.placeholder = t[key];
        } else if (el.tagName === 'OPTION') {
          el.text = t[key];
        } else {
          const val = t[key];
          if (val.includes('<') || val.includes('&')) {
            el.innerHTML = val;
          } else {
            el.textContent = val;
          }
        }
      }
    });
    document.getElementById('html-root').setAttribute('lang', lang);
    document.title = lang === 'es'
      ? 'RACBCONSULTING | Soluciones de IA para PYMES y Profesionales'
      : 'RACBCONSULTING | AI Solutions for SMBs and Professionals';
  }

  function toggleLang() {
    currentLang = currentLang === 'es' ? 'en' : 'es';
    window.currentLang = currentLang;
    applyLang(currentLang);
    document.getElementById('langFlag').textContent = currentLang === 'es' ? '🇺🇸' : '🇪🇸';
    document.getElementById('langLabel').textContent = currentLang === 'es' ? 'EN' : 'ES';
    try { localStorage.setItem('racb_lang', currentLang); } catch(e) {}
  }

  // ===== INIT =====
  initReveal();

  // Close modals on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key !== 'Escape') return;
  if (typeof closeAdvisorModal === 'function') {
    const advisor = document.getElementById('advisor-modal');
    if (advisor && advisor.classList.contains('is-open')) { closeAdvisorModal(); return; }
  }
  if (typeof closePrivacy === 'function') {
    const privacy = document.getElementById('privacy-modal');
    if (privacy && privacy.classList.contains('modal-visible')) closePrivacy();
  }
});

  // Close modals on backdrop click
document.addEventListener('click', (e) => {
  const privacy = document.getElementById('privacy-modal');
  if (privacy && e.target === privacy && typeof closePrivacy === 'function') {
    closePrivacy();
  }
  const advisor = document.getElementById('advisor-modal');
  if (advisor && e.target === advisor && typeof closeAdvisorModal === 'function') {
    closeAdvisorModal();
  }
});
	// ===== MAKE FUNCTIONS GLOBAL (for inline onclick="...") =====
  window.showPage = showPage;
  window.toggleNav = toggleNav;
  window.closeNav = closeNav;
  window.filterService = filterService;
  window.filterBlog = filterBlog;
  window.showPrivacy = showPrivacy;
  window.closePrivacy = closePrivacy;
  window.handleForm = handleForm;
  window.openAdvisorModal = openAdvisorModal;
  window.closeAdvisorModal = closeAdvisorModal;
  window.sendAdvisorMessage = sendAdvisorMessage;
  window.sendAdvisorPrompt = sendAdvisorPrompt;
  window.handleAdvisorKey = handleAdvisorKey;
  window.toggleLang = toggleLang;
  window.applyLang = applyLang;

	// ===== WhatsApp Smart (preserva tu sitio; abre en nueva pestaña) =====
function openWhatsAppSmart(phone, text) {
  const p = String(phone || '').replace(/\D/g, '');
  const msg = encodeURIComponent(text || '');

  // Mobile: usa wa.me (normalmente abre la app; si no está instalada, WhatsApp muestra opciones de descarga)
  const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

  // Desktop: SIEMPRE abre WhatsApp Web en una pestaña nueva para NO reemplazar racbconsulting.com
  // (Evita también el doble comportamiento web+app que ocurre con api.whatsapp.com / wa.me en algunos equipos)
  const url = isMobile
    ? `https://wa.me/${p}${msg ? `?text=${msg}` : ''}`
    : `https://web.whatsapp.com/send?phone=${p}${msg ? `&text=${msg}` : ''}`;

  const w = window.open(url, '_blank', 'noopener');

  // Si el navegador bloquea popups, hacemos fallback: mostramos un modal (si existe) o navegamos en la misma pestaña
  if (!w) {
    const fallback = document.getElementById('wa-fallback');
    const linkEl = document.getElementById('wa-fallback-link');
    if (fallback && linkEl) {
      linkEl.href = url;
      linkEl.textContent = url;
      fallback.style.display = 'flex';
      requestAnimationFrame(() => fallback.classList.add('modal-visible'));
    } else {
      window.location.href = url;
    }
  }
}

// 1) Hacer que TODOS los links .js-wa funcionen (footer + sección contacto)
document.addEventListener('click', function (e) {
  const a = e.target.closest('a.js-wa');
  if (!a) return;

  // Evita que cualquier otro handler o el href original dispare navegación
  e.preventDefault();
  e.stopPropagation();
  if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();

  const phone = a.dataset.phone || '17865678418';
  const text = a.dataset.text || 'Hola, quiero información sobre sus servicios de IA';
  openWhatsAppSmart(phone, text);
}, true);

// 2) Hacer que el botón flotante también use la lógica smart
(function () {
  const btn = document.querySelector('.wa-float');
  if (!btn) return;

  // Si tienes data-phone / data-text en el HTML, respétalos
  const phone = btn.dataset.phone || '17865678418';
  const text  = btn.dataset.text  || 'Hola, quiero información sobre sus servicios de IA';

  // Mantén href como "#" para que el listener .js-wa lo maneje
  btn.setAttribute('href', '#');
  btn.classList.add('js-wa');
  btn.dataset.phone = phone;
  btn.dataset.text  = text;
})();
})();
