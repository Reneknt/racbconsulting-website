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

  const MVP_URL = 'https://mvp.racbconsulting.com';

  var advisorState = {
    firstMessage: '',
    quickPromptUsed: false,
    captureShown: false,
    captureRendering: false,
    submitted: false,
    captureMode: null,
    messageCount: 0,
    intentType: '',
    conversationSummary: '',
    conversationHistory: [],
    userName: '',
    advisorName: '',
    sessionId: ''
  };

  function generateSessionId() {
    return Math.random().toString(36).slice(2, 11) + Date.now().toString(36);
  }

  function getAdvisorPersona() {
    var h = new Date().getHours();
    if (h >= 5  && h < 12) return 'Daniel';
    if (h >= 12 && h < 17) return 'Marcus';
    if (h >= 17 && h < 22) return 'Sofia';
    return 'Daniel';
  }

  function setAdvisorModalTitle(name) {
    var el = document.getElementById('advisor-modal-title');
    if (el) el.textContent = name;
  }

  function openAdvisorModal() {
    const modal = document.getElementById('advisor-modal');
    if (!modal) return;
    if (!advisorState.advisorName) {
      advisorState.advisorName = getAdvisorPersona();
    }
    setAdvisorModalTitle(advisorState.advisorName);
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
    var t = translations[currentLang];
    var history = document.getElementById('advisor-chat-history');
    if (!history) return;

    // Compute fresh persona for next conversation
    var personaName = getAdvisorPersona();

    advisorState.firstMessage        = '';
    advisorState.quickPromptUsed     = false;
    advisorState.captureShown        = false;
    advisorState.captureRendering    = false;
    advisorState.submitted           = false;
    advisorState.captureMode         = null;
    advisorState.messageCount        = 0;
    advisorState.intentType          = '';
    advisorState.conversationSummary = '';
    advisorState.conversationHistory = [];
    advisorState.userName            = '';
    advisorState.advisorName         = personaName;
    advisorState.sessionId           = generateSessionId();

    setAdvisorModalTitle(personaName);
    history.innerHTML = '';

    // Personalized welcome — advisor introduces themselves
    var baseWelcome = t['fp-advisor-welcome'] || "Walk me through what's happening. Start with wherever the pressure is highest.";
    var welcomeText = currentLang === 'es'
      ? personaName + ' de RACBCONSULTING. ' + baseWelcome
      : personaName + ' here. ' + baseWelcome;

    var welcome = document.createElement('div');
    welcome.className = 'advisor-msg advisor-msg--assistant';
    var wp = document.createElement('p');
    wp.textContent = welcomeText;
    welcome.appendChild(wp);
    history.appendChild(welcome);

    var prompts = document.createElement('div');
    prompts.id = 'advisor-quick-prompts';
    prompts.className = 'advisor-quick-prompts';
    [
      t['fp-advisor-qp1'] || "We're losing leads",
      t['fp-advisor-qp2'] || 'Scheduling keeps breaking',
      t['fp-advisor-qp3'] || 'Follow-up keeps falling through',
      t['fp-advisor-qp4'] || "We can't keep up operationally"
    ].forEach(function(label) {
      var btn = document.createElement('button');
      btn.className = 'advisor-quick-prompt';
      btn.textContent = label;
      btn.addEventListener('click', function() { sendAdvisorPrompt(btn); });
      prompts.appendChild(btn);
    });
    history.appendChild(prompts);

    var input = document.getElementById('advisor-chat-input');
    if (input) { input.value = ''; input.disabled = false; }
    var sendBtn = document.querySelector('.advisor-chat-send');
    if (sendBtn) sendBtn.disabled = false;
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

  function appendAdvisorAssistantMessage(userText) {
    var t = translations[currentLang];
    if (advisorState.captureShown || advisorState.submitted) return;

    advisorState.messageCount++;
    if (userText) {
      advisorState.conversationSummary += (advisorState.conversationSummary ? ' | ' : '') + userText;
    }

    // Update intent classification — always re-evaluate if greeting or unknown
    var classified = classifyAdvisorMessage(userText || '');
    if (!advisorState.intentType || advisorState.intentType === 'unknown' ||
        advisorState.intentType === 'greeting') {
      if (classified !== 'greeting' || !advisorState.intentType) {
        advisorState.intentType = classified;
      }
    }

    // Gate: show capture?
    if (shouldShowCaptureNow()) {
      advisorState.captureShown = true;
      appendAdvisorBubble(t['advisor-bridge'] || "That gives me enough context. If you share your name and email, I can route this to the Executive Advisory Desk.");
      setTimeout(renderAdvisorCaptureForm, 450);
      return;
    }

    // Conversational reply based on intent
    var replyKey;
    if (advisorState.messageCount > 1 && advisorState.intentType === 'greeting') {
      replyKey = 'advisor-unknown-reply';
    } else {
      switch (advisorState.intentType) {
        case 'greeting':     replyKey = 'advisor-greeting-reply';     break;
        case 'service':      replyKey = 'advisor-service-reply';      break;
        case 'operational':  replyKey = 'advisor-operational-reply';  break;
        default:             replyKey = 'advisor-unknown-reply';
      }
    }
    appendAdvisorBubble(t[replyKey] || t['advisor-unknown-reply'] || "Understood. Tell me more about what you are trying to improve.");

    // Routing buttons appear only after the greeting reply and only once
    if (advisorState.intentType === 'greeting' && advisorState.messageCount === 1) {
      setTimeout(renderAdvisorRoutingButtons, 350);
    }
  }

  function scrollAdvisorHistory() {
    const history = document.getElementById('advisor-chat-history');
    if (history) history.scrollTop = history.scrollHeight;
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  function sendAdvisorMessage() {
    if (advisorState.submitted) return;
    var input = document.getElementById('advisor-chat-input');
    if (!input) return;
    var text = input.value.trim();
    if (!text) return;
    input.value = '';
    if (!advisorState.firstMessage) advisorState.firstMessage = text;
    hideAdvisorQuickPrompts();
    hideAdvisorRoutingButtons();
    appendAdvisorUserMessage(text);
    callAdvisorAPI(text);
  }

  function sendAdvisorPrompt(btn) {
    if (advisorState.submitted) return;
    var text = btn.textContent.trim();
    if (!advisorState.firstMessage) {
      advisorState.firstMessage = text;
      advisorState.quickPromptUsed = true;
    }
    hideAdvisorQuickPrompts();
    hideAdvisorRoutingButtons();
    appendAdvisorUserMessage(text);
    callAdvisorAPI(text);
  }

  function hideAdvisorQuickPrompts() {
    const prompts = document.getElementById('advisor-quick-prompts');
    if (prompts) prompts.remove();
  }

  function classifyAdvisorMessage(text) {
    var lc = text.toLowerCase().trim();
    var greetings = ['hi','hello','hola','buenas','hey','buenos','buen dia','buen día',
                     'saludos','howdy','yo','sup','good morning','good afternoon',
                     'good day','test','testing'];
    if (greetings.some(function(g) {
      return lc === g || lc === g + '!' || lc === g + '.' || lc.startsWith(g + ' ') || lc.startsWith(g + ',');
    })) return 'greeting';

    var serviceKw = ['chatbot','bot','automation','automatización','automatizacion',
                     'website','web','landing','crm','whatsapp','n8n','workflow',
                     'flujo','ai agent','agente ia','agente de ia','appointment',
                     'calendar','email automation','automatizar','platform',
                     'plataforma','implementar','implement','build','crear',
                     'create','develop','desarrollar','software','app','herramienta',
                     'tool','sistema','system','integration','integración'];
    if (serviceKw.some(function(k) { return lc.includes(k); })) return 'service';

    var opKw = ['losing leads','perdiendo leads','missed calls','llamadas perdidas',
                'scheduling','programación','programacion','follow-up','seguimiento',
                'delayed estimate','presupuesto','admin overload','operations',
                'operaciones','revenue','ingresos','leakage','fuga','maintenance',
                'mantenimiento','vendor','proveedor','dispatch','despacho','leads',
                'sales','ventas','slow','lento','inconsistent','inconsistente',
                'broken','roto','chaos','caos','overloaded','sobrecargado',
                'losing money','perdiendo dinero','not converting','no convierten',
                'response time','tiempo de respuesta'];
    if (opKw.some(function(k) { return lc.includes(k); })) return 'operational';

    return 'unknown';
  }

  function shouldShowCaptureNow() {
    if (advisorState.captureShown || advisorState.submitted) return false;
    // Explicit diagnostic route always triggers capture
    if (advisorState.intentType === 'diagnostic') return true;
    // Two substantive messages — not still in greeting/unsure territory
    if (advisorState.messageCount >= 2 &&
        advisorState.intentType !== 'greeting' &&
        advisorState.intentType !== 'unsure') return true;
    // Fallback: after 3 exchanges regardless of intent
    if (advisorState.messageCount >= 3) return true;
    return false;
  }

  function focusAdvisorInput() {
    var input = document.getElementById('advisor-chat-input');
    if (input && !input.disabled) input.focus();
  }

  function focusExistingAdvisorCaptureForm() {
    var form = document.querySelector('.advisor-capture-form');
    if (!form) return;
    form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(function() {
      var inputs = form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select, textarea');
      var target = null;
      for (var i = 0; i < inputs.length; i++) {
        if (!inputs[i].value) { target = inputs[i]; break; }
      }
      if (!target && inputs.length) target = inputs[0];
      if (target) target.focus();
    }, 300);
  }

  function detectAdvisorMessageLanguage(message) {
    var msg = (' ' + message.toLowerCase().trim() + ' ');

    // Too short or single-word — no reliable signal
    if (message.trim().length < 8 || message.trim().split(/\s+/).length < 2) return null;

    // Strip known neutral technical terms before scoring
    var neutral = ['crm', 'api', 'whatsapp', 'workflow', 'automation', 'chatbot', 'erp', 'saas'];
    neutral.forEach(function(t) { msg = msg.replace(new RegExp(t, 'g'), ' '); });

    var esSignals = [
      'hola', 'cómo', 'como ', 'qué ', 'que ', 'gracias', 'problema',
      'entonces', 'quiero', 'necesito', 'mañana', 'manana', 'después', 'despues',
      'diagnóstico', 'diagnostico', 'revisión', 'revision', 'operación', 'operacion',
      'negocio', 'dónde', 'donde', 'sería', 'seria', 'podemos', 'tenemos',
      'perdemos', 'claro', 'buenas'
    ];
    var enSignals = [
      'hello', ' how ', ' what ', 'thanks', 'problem', 'business',
      'review', 'diagnostic', 'tomorrow', ' would ', ' could ', ' need ',
      ' want ', ' where ', 'process', 'schedule', 'leads', 'follow'
    ];

    var esHits = 0, enHits = 0;
    esSignals.forEach(function(s) { if (msg.indexOf(s) !== -1) esHits++; });
    enSignals.forEach(function(s) { if (msg.indexOf(s) !== -1) enHits++; });

    if (esHits >= 2 && esHits > enHits) return 'es';
    if (enHits >= 2 && enHits > esHits) return 'en';
    return null;
  }

  function surfaceAdvisorCaptureForm() {
    if (advisorState.submitted) return;
    if (document.querySelector('.advisor-capture-form')) {
      advisorState.captureShown = true;
      focusExistingAdvisorCaptureForm();
      return;
    }
    if (advisorState.captureRendering) return;
    advisorState.captureShown = true;
    renderAdvisorCaptureForm();
  }

  function appendAdvisorBubble(text) {
    var history = document.getElementById('advisor-chat-history');
    if (!history) return;
    var wrap = document.createElement('div');
    wrap.className = 'advisor-msg advisor-msg--assistant';
    var p = document.createElement('p');
    p.textContent = text;
    wrap.appendChild(p);
    history.appendChild(wrap);
    scrollAdvisorHistory();
  }

  function renderAdvisorRoutingButtons() {
    if (document.getElementById('advisor-routing-btns')) return;
    var t = translations[currentLang];
    var history = document.getElementById('advisor-chat-history');
    if (!history) return;
    var container = document.createElement('div');
    container.id = 'advisor-routing-btns';
    container.className = 'advisor-quick-prompts';
    [
      { intent: 'diagnostic', key: 'advisor-route-diagnostic', fallback: 'I need an Executive Diagnostic' },
      { intent: 'service',    key: 'advisor-route-service',    fallback: 'I need a specific service' },
      { intent: 'unsure',     key: 'advisor-route-unsure',     fallback: "I'm not sure yet" }
    ].forEach(function(route) {
      var btn = document.createElement('button');
      btn.className = 'advisor-quick-prompt';
      btn.textContent = t[route.key] || route.fallback;
      btn.addEventListener('click', function() { sendAdvisorRouting(route.intent); });
      container.appendChild(btn);
    });
    history.appendChild(container);
    scrollAdvisorHistory();
  }

  function hideAdvisorRoutingButtons() {
    var el = document.getElementById('advisor-routing-btns');
    if (el) el.remove();
  }

  function sendAdvisorRouting(intentValue) {
    if (advisorState.submitted) return;
    var t = translations[currentLang];
    var labelKey = intentValue === 'diagnostic' ? 'advisor-route-diagnostic'
                 : intentValue === 'service'    ? 'advisor-route-service'
                 :                                'advisor-route-unsure';
    var label = t[labelKey] || intentValue;

    if (!advisorState.firstMessage) advisorState.firstMessage = label;

    hideAdvisorRoutingButtons();
    appendAdvisorUserMessage(label);
    callAdvisorAPI(label);
  }

  function handleAdvisorKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendAdvisorMessage();
    }
  }

  function renderAdvisorCaptureForm() {
    if (advisorState.submitted) return;
    if (advisorState.captureRendering) return;
    if (document.querySelector('.advisor-capture-form')) {
      advisorState.captureShown = true;
      focusExistingAdvisorCaptureForm();
      return;
    }

    advisorState.captureRendering = true;
    try {
      var t = translations[currentLang];
      var history = document.getElementById('advisor-chat-history');
      if (!history) return;

      var wrap = document.createElement('div');
      wrap.className = 'advisor-msg advisor-msg--assistant';
      wrap.id = 'advisor-capture-wrap';
      wrap.style.maxWidth = '100%';

      var form = document.createElement('div');
      form.className = 'advisor-capture-form';

      form.appendChild(buildAdvisorField('advisor-capture-name', 'text',
        t['advisor-name-label'] || 'Name',
        t['advisor-name-ph']    || 'Your name',
        'name'));
      form.appendChild(buildAdvisorField('advisor-capture-email', 'email',
        t['advisor-email-label'] || 'Email',
        t['advisor-email-ph']    || 'you@company.com',
        'email'));
      form.appendChild(buildAdvisorSelect('advisor-capture-btype',
        t['advisor-btype-label'] || 'Business type', [
          { value: '',            label: t['advisor-btype-opt0']        || 'Select...' },
          { value: 'contractor',  label: t['advisor-btype-contractor']  || 'Contractor (HVAC, Plumbing, Electrical, Roofing)' },
          { value: 'multifamily', label: t['advisor-btype-multifamily'] || 'Multifamily Operations' },
          { value: 'service',     label: t['advisor-btype-service']     || 'Service Business' },
          { value: 'other',       label: t['advisor-btype-other']       || 'Other' }
        ]));
      form.appendChild(buildAdvisorSelect('advisor-capture-urgency',
        t['advisor-urgency-label'] || 'Urgency', [
          { value: '',             label: t['advisor-urgency-opt0']       || 'Select...' },
          { value: 'immediate',    label: t['advisor-urgency-immediate']  || 'I need to resolve this now' },
          { value: 'within_month', label: t['advisor-urgency-month']      || 'Within the next month' },
          { value: 'exploring',    label: t['advisor-urgency-exploring']  || 'Exploring options' }
        ]));

      var hp = document.createElement('input');
      hp.type = 'text';
      hp.id = 'advisor-hp';
      hp.style.cssText = 'position:absolute;left:-9999px;opacity:0;pointer-events:none;';
      hp.tabIndex = -1;
      hp.setAttribute('autocomplete', 'off');
      form.appendChild(hp);

      var errEl = document.createElement('p');
      errEl.id = 'advisor-capture-error';
      errEl.className = 'advisor-capture-error';
      errEl.style.display = 'none';
      form.appendChild(errEl);

      var submitBtn = document.createElement('button');
      submitBtn.type = 'button';
      submitBtn.id = 'advisor-capture-submit';
      submitBtn.className = 'advisor-capture-submit';
      submitBtn.textContent = t['advisor-submit'] || 'Send to Advisory Desk';
      submitBtn.addEventListener('click', submitAdvisorForm);
      form.appendChild(submitBtn);

      wrap.appendChild(form);
      history.appendChild(wrap);

      if (advisorState.userName) {
        var nameInput = document.getElementById('advisor-capture-name');
        if (nameInput) nameInput.value = advisorState.userName;
      }

      scrollAdvisorHistory();
      advisorState.captureShown = true;
    } finally {
      advisorState.captureRendering = false;
    }
  }

  function buildAdvisorField(id, type, labelText, placeholder, autocomplete) {
    var field = document.createElement('div');
    field.className = 'advisor-field';
    var lbl = document.createElement('label');
    lbl.setAttribute('for', id);
    lbl.textContent = labelText;
    field.appendChild(lbl);
    var input = document.createElement('input');
    input.type = type;
    input.id = id;
    input.placeholder = placeholder;
    if (autocomplete) input.setAttribute('autocomplete', autocomplete);
    field.appendChild(input);
    return field;
  }

  function buildAdvisorSelect(id, labelText, options) {
    var field = document.createElement('div');
    field.className = 'advisor-field';
    var lbl = document.createElement('label');
    lbl.setAttribute('for', id);
    lbl.textContent = labelText;
    field.appendChild(lbl);
    var sel = document.createElement('select');
    sel.id = id;
    options.forEach(function(opt) {
      var o = document.createElement('option');
      o.value = opt.value;
      o.textContent = opt.label;
      if (!opt.value) { o.disabled = true; o.selected = true; }
      sel.appendChild(o);
    });
    field.appendChild(sel);
    return field;
  }

  function submitAdvisorForm() {
    if (advisorState.submitted) return;
    var t         = translations[currentLang];
    var nameEl    = document.getElementById('advisor-capture-name');
    var emailEl   = document.getElementById('advisor-capture-email');
    var btypeEl   = document.getElementById('advisor-capture-btype');
    var urgencyEl = document.getElementById('advisor-capture-urgency');
    var hpEl      = document.getElementById('advisor-hp');
    var errEl     = document.getElementById('advisor-capture-error');
    var submitBtn = document.getElementById('advisor-capture-submit');

    var name    = nameEl    ? nameEl.value.trim()  : '';
    var email   = emailEl   ? emailEl.value.trim() : '';
    var btype   = btypeEl   ? btypeEl.value        : '';
    var urgency = urgencyEl ? urgencyEl.value      : '';
    var hp      = hpEl      ? hpEl.value           : '';

    var errMsg = '';
    if (!name)
      errMsg = t['advisor-validation-name']    || 'Please enter your name.';
    else if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
      errMsg = t['advisor-validation-email']   || 'Please enter a valid email address.';
    else if (!btype)
      errMsg = t['advisor-validation-btype']   || 'Please select your business type.';
    else if (!urgency)
      errMsg = t['advisor-validation-urgency'] || 'Please select your urgency.';

    if (errMsg) {
      if (errEl) { errEl.textContent = errMsg; errEl.style.display = ''; }
      return;
    }
    if (errEl) errEl.style.display = 'none';
    if (hp) return;

    advisorState.submitted = true;
    if (submitBtn) { submitBtn.textContent = t['advisor-submitting'] || 'Sending...'; submitBtn.disabled = true; }

    var body = new URLSearchParams();
    body.append('action',            'racb_advisor');
    body.append('nonce',             typeof racbAjax !== 'undefined' ? racbAjax.nonce : '');
    body.append('name',              name);
    body.append('email',             email);
    body.append('business_type',     btype);
    body.append('urgency',           urgency);
    body.append('first_message',          advisorState.firstMessage);
    body.append('quick_prompt_used',      advisorState.quickPromptUsed ? '1' : '0');
    body.append('intent_type',            advisorState.intentType);
    body.append('conversation_summary',   advisorState.conversationSummary);
    body.append('message_count',          String(advisorState.messageCount));
    body.append('lang',                   currentLang);
    body.append('page_url',               window.location.href);
    body.append('website',                hp);

    var ajaxUrl = typeof racbAjax !== 'undefined' ? racbAjax.ajax_url : '/wp-admin/admin-ajax.php';

    fetch(ajaxUrl, {
      method:  'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
      body:    body.toString()
    })
    .then(function(res) { return res.json(); })
    .then(function() {
      var captureWrap = document.getElementById('advisor-capture-wrap');
      if (captureWrap) captureWrap.remove();
      renderAdvisorSuccess(t);
    })
    .catch(function() {
      advisorState.submitted = false;
      if (submitBtn) { submitBtn.textContent = t['advisor-submit'] || 'Send to Advisory Desk'; submitBtn.disabled = false; }
      if (errEl) { errEl.textContent = t['advisor-error-msg'] || 'Unable to process. Please try again or email ceo@racbconsulting.com.'; errEl.style.display = ''; }
    });
  }

  function renderAdvisorSuccess(t) {
    var history = document.getElementById('advisor-chat-history');
    if (!history) return;
    var wrap = document.createElement('div');
    wrap.className = 'advisor-msg advisor-msg--assistant';
    var msg = document.createElement('p');
    msg.textContent = t['advisor-success-msg'] || 'We have your information. Our Executive Advisory Desk will be in touch within 24 hours.';
    wrap.appendChild(msg);
    // TODO: MVP dependency — CTA routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project.
    var cta = document.createElement('a');
    cta.href = MVP_URL;
    cta.target = '_blank';
    cta.rel = 'noopener';
    cta.className = 'advisor-chat-cta';
    cta.textContent = t['advisor-success-cta'] || 'Book Executive Diagnostic';
    wrap.appendChild(cta);
    history.appendChild(wrap);
    scrollAdvisorHistory();
  }

  function callAdvisorAPI(text) {
    if (advisorState.submitted) return;

    // Conversational language detection — override currentLang if clear evidence
    var detectedLang = detectAdvisorMessageLanguage(text);
    if (detectedLang && detectedLang !== currentLang) {
      console.log('[Advisor Language Override]', currentLang, '->', detectedLang);
      currentLang = detectedLang;
    }

    advisorState.messageCount++;
    if (text) {
      advisorState.conversationSummary += (advisorState.conversationSummary ? ' | ' : '') + text;
    }

    showAdvisorTyping();
    disableAdvisorInput(true);

    var history = advisorState.conversationHistory.slice(-16).map(function(h) {
      return { role: h.role, content: h.content };
    });

    var body = new URLSearchParams();
    body.append('action',        'racb_advisor_chat');
    body.append('nonce',         typeof racbAjax !== 'undefined' ? racbAjax.nonce : '');
    body.append('message',       text);
    body.append('lang',          currentLang);
    body.append('page_url',      window.location.href);
    body.append('history',       JSON.stringify(history));
    body.append('message_count', String(advisorState.messageCount));
    body.append('user_name',     advisorState.userName);
    body.append('session_id',    advisorState.sessionId);

    var ajaxUrl = typeof racbAjax !== 'undefined' ? racbAjax.ajax_url : '/wp-admin/admin-ajax.php';

    fetch(ajaxUrl, {
      method:  'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
      body:    body.toString()
    })
    .then(function(res) { return res.json(); })
    .then(function(json) {
      removeAdvisorTyping();
      disableAdvisorInput(false);

      if (!json.success || !json.data || !json.data.reply) {
        appendAdvisorBubble(getAdvisorFallback());
        setTimeout(focusAdvisorInput, 50);
        return;
      }

      var data = json.data;

      if (data.is_fallback) {
        // API call failed — show fallback text but do not corrupt conversation history
        // and undo the messageCount increment so capture timing stays accurate
        advisorState.messageCount--;
        appendAdvisorBubble(data.reply);
        setTimeout(focusAdvisorInput, 50);
        return;
      }

      advisorState.conversationHistory.push({ role: 'user',      content: text });
      advisorState.conversationHistory.push({ role: 'assistant', content: data.reply });

      if (data.intent_type) advisorState.intentType = data.intent_type;

      if (data.capture_mode === 'now' || data.capture_mode === 'followup') {
        advisorState.captureMode = data.capture_mode;
      }

      if (data.extracted_name && !advisorState.userName) {
        advisorState.userName = data.extracted_name;
      }
      if (data.advisor_name) {
        advisorState.advisorName = data.advisor_name;
        setAdvisorModalTitle(data.advisor_name);
      }

      appendAdvisorBubble(data.reply);

      if (data.should_capture && advisorState.messageCount >= 2 && !advisorState.submitted) {
        // Surface form (render first time, or scroll into view if already rendered)
        setTimeout(surfaceAdvisorCaptureForm, 500);
      } else {
        // No form action — return focus to chat input
        setTimeout(focusAdvisorInput, 50);
        if (advisorState.messageCount === 1 && !data.should_capture &&
            advisorState.intentType === 'greeting') {
          setTimeout(renderAdvisorRoutingButtons, 350);
        }
      }
    })
    .catch(function() {
      removeAdvisorTyping();
      disableAdvisorInput(false);
      appendAdvisorBubble(getAdvisorFallback());
      setTimeout(focusAdvisorInput, 50);
    });
  }

  function showAdvisorTyping() {
    if (document.getElementById('advisor-typing')) return;
    var history = document.getElementById('advisor-chat-history');
    if (!history) return;
    var div = document.createElement('div');
    div.id = 'advisor-typing';
    div.className = 'advisor-msg advisor-msg--assistant advisor-typing';
    var p = document.createElement('p');
    p.textContent = '...';
    div.appendChild(p);
    history.appendChild(div);
    scrollAdvisorHistory();
  }

  function removeAdvisorTyping() {
    var el = document.getElementById('advisor-typing');
    if (el) el.remove();
  }

  function disableAdvisorInput(disabled) {
    var input = document.getElementById('advisor-chat-input');
    var btn   = document.querySelector('.advisor-chat-send');
    if (input) input.disabled = disabled;
    if (btn)   btn.disabled   = disabled;
  }

  function getAdvisorFallback() {
    var spanishSignals = ['hola','buenas','español','espanol','gracias','necesito','empresa',
      'negocio','diagnóstico','diagnostico','dinero','operación','operacion','costo','precio',
      'cuánto','cuanto','me llamo','hablas con'];
    var recentText = advisorState.conversationHistory.slice(-6)
      .map(function(h) { return h.content || ''; }).join(' ').toLowerCase();
    var spanishDetected = spanishSignals.some(function(s) { return recentText.indexOf(s) !== -1; });
    var fallbackLang = (currentLang === 'es' || spanishDetected) ? 'es' : 'en';
    var pool = fallbackLang === 'es'
      ? [
          'Perdona, se interrumpió brevemente la conexión de mi lado. Retomamos: ¿qué parte del negocio te está generando más incertidumbre ahora mismo?',
          'Se interrumpió un momento, pero seguimos. Cuéntame: ¿dónde sientes más fricción hoy en la operación?',
          'Gracias por la paciencia. Retomemos con calma: ¿qué proceso o área te preocupa más ahora mismo?'
        ]
      : [
          'Sorry, the connection briefly interrupted on my side. Let\'s continue: where are you feeling the most operational pressure right now?',
          'The line paused for a moment, but we can continue. Where does the business feel most inefficient right now?',
          'Thanks for your patience. Let\'s pick it back up calmly: what process or area feels most unclear right now?'
        ];
    return pool[advisorState.messageCount % pool.length];
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
      "nav-cta": "Reservar Diagnóstico Ejecutivo",
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
      "cop-label": "Contacto",
      "fp-cta-btn": "Reservar Diagnóstico Ejecutivo",
      "fp-hero-badge": "Diagnóstico Ejecutivo Inicial Gratuito — Disponibilidad Limitada",
      "fp-hero-title": "¿Dónde Está Perdiendo Dinero su Empresa Silenciosamente?",
      "fp-hero-sub": "La mayoría de las empresas no tienen un problema de leads.<br>Tienen un problema de respuesta operativa.",
      "fp-hero-body": "Identificamos ingresos perdidos, fallos de programación, cuellos de botella de liderazgo, sobrecarga administrativa y brechas de ejecución antes de que se vuelvan costosos.",
      "fp-hero-cta2": "Ver Cómo Funciona",
      "fp-authority-label": "El Enfoque",
      "fp-authority-title": "No Vendemos Automatización",
      "fp-authority-lead": "La mayoría de las empresas piden automatización.",
      "fp-authority-support": "El problema real es el fallo operativo.<br>Más software no arregla la ejecución.<br>Lo hace más costoso.",
      "fp-authority-diag-intro1": "Las empresas rara vez pierden dinero por falta de herramientas.",
      "fp-authority-diag-intro2": "Pierden dinero porque:",
      "fp-authority-li1": "los leads no se responden con suficiente rapidez",
      "fp-authority-li2": "los presupuestos llegan demasiado tarde",
      "fp-authority-li3": "la programación falla bajo presión",
      "fp-authority-li4": "la disciplina de seguimiento desaparece",
      "fp-authority-li5": "el liderazgo queda atrapado en operaciones",
      "fp-authority-li6": "la sobrecarga administrativa mata la ejecución",
      "fp-authority-diag-close": "El problema rara vez es el software.<br>El problema es la estructura operativa.",
      "fp-authority-quote": "Automatizar un proceso roto no crea eficiencia.<br>Acelera el daño.",
      "fp-authority-quote-footer": "Por eso comenzamos con el diagnóstico primero.<br>No con la implementación. No con la automatización. Con el diagnóstico.",
      "fp-authority-panel-intro": "Antes de añadir sistemas, identificamos:",
      "fp-authority-panel-li1": "dónde se están fugando los ingresos",
      "fp-authority-panel-li2": "dónde está fallando la ejecución",
      "fp-authority-panel-li3": "qué debe corregirse primero",
      "fp-authority-panel-li4": "qué nunca debe automatizarse",
      "fp-authority-panel-close": "Porque la automatización sin claridad ejecutiva es costosa.",
      "fp-authority-manifesto1": "No vendemos automatización.",
      "fp-authority-manifesto2": "Resolvemos problemas operativos.",
      "fp-authority-manifesto3": "La automatización es solo la capa de implementación.",
      "fp-authority-manifesto4": "El producto real es el juicio ejecutivo.",
      "fp-authority-cta-label": "Comenzar Con el Diagnóstico",
      "fp-verticals-label": "Verticales que Atendemos",
      "fp-verticals-title": "A Quién Ayudamos",
      "fp-verticals-lead": "Trabajamos con empresas donde el fallo operativo se vuelve costoso.<br>No negocios pasatiempo. No experimentos.<br>Operaciones reales. Presión real. Dinero real.",
      "fp-v1-title": "Contratistas",
      "fp-v1-ex1": "HVAC",
      "fp-v1-ex2": "Plomería",
      "fp-v1-ex3": "Electricidad",
      "fp-v1-ex4": "Techado",
      "fp-v1-ex5": "Contratistas Generales",
      "fp-v1-ex6": "Negocios de Servicios en Campo",
      "fp-pain-label": "Dónde desaparece el dinero:",
      "fp-v1-pain1": "Caos de programación",
      "fp-v1-pain2": "Llamadas perdidas",
      "fp-v1-pain3": "Presupuestos lentos",
      "fp-v1-pain4": "Presión de despacho",
      "fp-v1-pain5": "Sobrecarga administrativa",
      "fp-v1-pain6": "Fuga de ingresos entre trabajos",
      "fp-v2-title": "Operaciones Multifamiliares",
      "fp-v2-ex1": "Administración de Propiedades",
      "fp-v2-ex2": "Operaciones de Mantenimiento",
      "fp-v2-ex3": "Coordinación de Proveedores",
      "fp-v2-ex4": "Soporte de Arrendamiento",
      "fp-v2-ex5": "Ejecución de Servicios",
      "fp-v2-ex6": "Operaciones con Residentes",
      "fp-v2-pain1": "Cuellos de botella en órdenes de trabajo",
      "fp-v2-pain2": "Fricción con proveedores",
      "fp-v2-pain3": "Ejecución tardía",
      "fp-v2-pain4": "Fallos de comunicación",
      "fp-v2-pain5": "Puntos ciegos operativos",
      "fp-v2-pain6": "Sobrecarga de liderazgo",
      "fp-v3-title": "Negocios de Servicios",
      "fp-v3-ex1": "Servicios Profesionales",
      "fp-v3-ex2": "Médico",
      "fp-v3-ex3": "Legal",
      "fp-v3-ex4": "Servicios del Hogar",
      "fp-v3-ex5": "Operaciones Ejecutivas",
      "fp-v3-ex6": "Equipos de Servicio en Crecimiento",
      "fp-v3-pain1": "Fallo en el seguimiento",
      "fp-v3-pain2": "Lastre administrativo",
      "fp-v3-pain3": "Baja conversión de leads",
      "fp-v3-pain4": "Traspasos deficientes",
      "fp-v3-pain5": "Inconsistencia en la ejecución",
      "fp-v3-pain6": "Crecimiento sin estructura operativa",
      "fp-verticals-statement1": "Si su negocio depende de velocidad, coordinación, ejecución y disciplina operativa—",
      "fp-verticals-statement2": "aquí es donde el dinero desaparece primero.",
      "fp-verticals-exclusion1": "No estamos construidos para empresas que buscan automatización barata.",
      "fp-verticals-exclusion2": "Estamos construidos para operadores que entienden que los fallos de ejecución cuestan dinero real.",
      "fp-verticals-cta-label": "Si las operaciones fallan, los ingresos lo siguen.",
      "fp-diagnose-label": "Diagnóstico Ejecutivo",
      "fp-diagnose-title": "Qué Diagnosticamos",
      "fp-diagnose-lead": "La mayoría de las empresas no notan dónde está desapareciendo el dinero.<br>Lo descubren cuando el crecimiento se detiene, los márgenes se comprimen y el liderazgo queda atrapado en el caos operativo.<br>Identificamos los fallos ocultos antes de que se vuelvan costosos.",
      "fp-d1-title": "Leads Perdidos",
      "fp-d1-situation": "Los leads llegan. Nadie responde con suficiente rapidez.",
      "fp-d1-consequence": "La oportunidad desaparece antes de que comience la conversación.",
      "fp-d2-title": "Caos de Programación",
      "fp-d2-situation": "Los trabajos se acumulan. El despacho falla. Las decisiones de prioridad se convierten en emergencias diarias.",
      "fp-d2-consequence": "Las operaciones se vuelven reactivas en lugar de controladas.",
      "fp-d3-title": "Presupuestos Tardíos",
      "fp-d3-situation": "Los presupuestos llegan demasiado tarde. El cliente ya avanzó con otra empresa.",
      "fp-d3-consequence": "Los ingresos se pierden silenciosamente.",
      "fp-d4-title": "Sobrecarga Administrativa",
      "fp-d4-situation": "Los líderes quedan atrapados en tareas administrativas.",
      "fp-d4-consequence": "La ejecución se ralentiza porque las decisiones quedan sepultadas bajo las operaciones.",
      "fp-d5-title": "Fallo en el Seguimiento",
      "fp-d5-situation": "Nadie hace seguimiento de manera consistente.",
      "fp-d5-consequence": "Las oportunidades mueren sin que nadie lo note.",
      "fp-d6-title": "Cuellos de Botella de Liderazgo",
      "fp-d6-situation": "Todo depende de una sola persona.",
      "fp-d6-consequence": "El crecimiento se vuelve imposible porque la ejecución no puede escalar.",
      "fp-d7-title": "Fuga Oculta de Ingresos",
      "fp-d7-situation": "Los pequeños fallos operativos se acumulan.",
      "fp-d7-consequence": "No hay un desastre único. Solo daño financiero invisible y constante.",
      "fp-diagnose-statement1": "La mayoría de las empresas no tienen un problema de ventas.",
      "fp-diagnose-statement2": "Tienen un problema de visibilidad de ejecución.",
      "fp-diagnose-purpose1": "No adivinamos.",
      "fp-diagnose-purpose2": "Diagnosticamos.",
      "fp-diagnose-purpose3": "Identificamos dónde se están fugando los ingresos, qué debe corregirse primero y qué nunca debe automatizarse.",
      "fp-diagnose-cta-label": "Claridad antes de la automatización.",
      "fp-exd-label": "El Proceso",
      "fp-exd-title": "El Diagnóstico Ejecutivo",
      "fp-exd-lead": "Esto no es una llamada de ventas.<br>Es una revisión operativa ejecutiva enfocada en identificar dónde su empresa pierde dinero,<br>dónde está fallando la ejecución y qué debe suceder a continuación.",
      "fp-exd-s1-step": "Paso 1",
      "fp-exd-s1-title": "Evaluación Inicial Ejecutiva",
      "fp-exd-s1-body1": "Revisamos su operación, los sistemas actuales, el flujo de decisiones, la presión de programación,<br>la disciplina de respuesta, los cuellos de botella de liderazgo y los indicadores de fuga de ingresos.",
      "fp-exd-s1-body2": "Identificamos cómo opera realmente el negocio, no cómo aparece en papel.",
      "fp-exd-s2-step": "Paso 2",
      "fp-exd-s2-title": "Diagnóstico Operativo",
      "fp-exd-s2-body1": "Trazamos dónde falla la ejecución.",
      "fp-exd-s2-li1": "Respuesta a leads",
      "fp-exd-s2-li2": "Programación",
      "fp-exd-s2-li3": "Presupuestos",
      "fp-exd-s2-li4": "Seguimiento",
      "fp-exd-s2-li5": "Sobrecarga administrativa",
      "fp-exd-s2-li6": "Dependencia de liderazgo",
      "fp-exd-s2-body2": "Aislamos dónde se fugan los ingresos.",
      "fp-exd-s3-step": "Paso 3",
      "fp-exd-s3-title": "Revisión Estratégica",
      "fp-exd-s3-body1": "Definimos qué debe corregirse primero.",
      "fp-exd-s3-li1": "Qué debe automatizarse",
      "fp-exd-s3-li2": "Qué nunca debe automatizarse",
      "fp-exd-s3-li3": "Qué genera el impacto operativo más rápido",
      "fp-exd-s4-step": "Paso 4",
      "fp-exd-s4-title": "Recomendación Ejecutiva",
      "fp-exd-s4-body1": "Usted recibe claridad estratégica.",
      "fp-exd-s4-body2": "No consejos genéricos.",
      "fp-exd-s4-body3": "Un camino ejecutivo real hacia adelante.",
      "fp-exd-s4-body4": "Tanto si la implementación ocurre con nosotros como si no.",
      "fp-exd-statement1": "La mayoría de las empresas intenta comprar herramientas antes de entender el problema.",
      "fp-exd-statement2": "Eso es al revés.",
      "fp-exd-statement3": "Nosotros lo corregimos primero.",
      "fp-exd-trust1": "Por eso las empresas calificadas reciben actualmente el Diagnóstico Ejecutivo Inicial sin costo.",
      "fp-exd-trust2": "Porque la claridad genera mejores decisiones.",
      "fp-exd-cta-label": "Disponibilidad limitada para empresas calificadas.",
      "fp-proof-label": "Evidencia Ejecutiva",
      "fp-proof-title": "Donde Mejoran las Operaciones, los Ingresos Siguen",
      "fp-proof-lead": "Los resultados no se miden por lo bien que parece la automatización.<br>Se miden por la velocidad de respuesta, la calidad de ejecución, la claridad operativa y los ingresos recuperables.<br>Ahí es donde existe la prueba real.",
      "fp-proof-z-problem": "Problema",
      "fp-proof-z-result": "Resultado",
      "fp-pc1-vertical": "Operaciones de Contratistas",
      "fp-pc1-p1": "Llamadas perdidas",
      "fp-pc1-p2": "Brechas de programación",
      "fp-pc1-p3": "Presupuestos tardíos",
      "fp-pc1-p4": "Fuga de ingresos entre trabajos",
      "fp-pc1-r1": "Respuesta más rápida",
      "fp-pc1-r2": "Despacho más ordenado",
      "fp-pc1-r3": "Mayor consistencia de reservas",
      "fp-pc1-r4": "Visibilidad operativa",
      "fp-pc2-vertical": "Operaciones Multifamiliares",
      "fp-pc2-p1": "Presión de mantenimiento",
      "fp-pc2-p2": "Fallos de coordinación con proveedores",
      "fp-pc2-p3": "Ejecución tardía",
      "fp-pc2-p4": "Sobrecarga administrativa",
      "fp-pc2-r1": "Flujos de trabajo más ordenados",
      "fp-pc2-r2": "Fricción reducida",
      "fp-pc2-r3": "Control de ejecución",
      "fp-pc2-r4": "Visibilidad de liderazgo",
      "fp-pc3-vertical": "Operaciones de Negocios de Servicios",
      "fp-pc3-p1": "Seguimiento deficiente",
      "fp-pc3-p2": "Lastre administrativo",
      "fp-pc3-p3": "Baja conversión de leads",
      "fp-pc3-p4": "Crecimiento sin estructura operativa",
      "fp-pc3-r1": "Disciplina operativa",
      "fp-pc3-r2": "Flujo de decisiones más ágil",
      "fp-pc3-r3": "Mejor conversión",
      "fp-pc3-r4": "Ejecución escalable",
      "fp-proof-statement1": "Las buenas operaciones generan resultados medibles.",
      "fp-proof-statement2": "El buen marketing solo genera atención temporal.",
      "fp-proof-statement3": "Nosotros optimizamos lo primero.",
      "fp-proof-authority1": "Nuestro trabajo no se juzga por lo impresionante que parece la automatización.",
      "fp-proof-authority2": "Se juzga por lo que deja de fallar.",
      "fp-proof-cta-label": "Si las operaciones mejoran, los ingresos siguen.",
      "fp-advisor-label": "Mesa de Asesoría Ejecutiva",
      "fp-advisor-title": "Hable Con Su Asesor Ejecutivo Privado",
      "fp-advisor-intro": "Antes de reservar su Diagnóstico Ejecutivo, hable directamente con nuestra Mesa de Asesoría Ejecutiva.",
      "fp-advisor-body": "Ayudamos a identificar si el problema es la generación de leads, las operaciones, la programación,<br>la disciplina de seguimiento o la fuga oculta de ingresos.<br>Comience la conversación correcta primero.",
      "fp-advisor-cta": "Iniciar Conversación de Asesoría",
      "fp-advisor-modal-label": "Asesor Ejecutivo Privado",
      "fp-advisor-modal-title": "Asesor Ejecutivo",
      "fp-advisor-welcome": "Cuéntame qué está pasando en la operación. Empieza por donde sientas más presión.",
      "fp-advisor-qp1": "Estamos perdiendo leads",
      "fp-advisor-qp2": "La programación sigue fallando",
      "fp-advisor-qp3": "El seguimiento no es consistente",
      "fp-advisor-qp4": "La operación no puede seguir el ritmo",
      "fp-advisor-input-placeholder": "Cuéntame qué está fallando...",
      "advisor-ack": "Con eso tengo suficiente contexto. Necesito un par de datos para conectarte con la persona correcta.",
      "advisor-greeting-reply": "¿Qué parte de la operación te está generando más presión ahora mismo?",
      "advisor-service-reply": "Eso depende de qué parte de la operación quieres mejorar. Antes de recomendar algo, cuéntame qué está fallando concretamente.",
      "advisor-operational-reply": "Ese es un patrón que vemos con frecuencia. ¿Cuándo ocurre con más fuerza — es constante o se dispara en ciertos momentos?",
      "advisor-unknown-reply": "¿Qué parte de la operación está generando más ruido ahora mismo?",
      "advisor-route-diagnostic": "Quiero un Diagnóstico Ejecutivo",
      "advisor-route-service": "Necesito un servicio específico",
      "advisor-route-unsure": "Todavía estoy explorando",
      "advisor-diagnostic-reply": "Bien. El Diagnóstico Ejecutivo es el punto de partida correcto. Necesito un par de datos para asignarlo al equipo indicado.",
      "advisor-service-follow-reply": "Podemos evaluar eso. Antes de recomendar algo, dime qué proceso o resultado necesita mejorar primero.",
      "advisor-unsure-reply": "Sin problema. El primer paso siempre es identificar dónde se está perdiendo dinero. ¿Hay algo urgente ahora mismo, o estás explorando opciones?",
      "advisor-bridge": "Con eso tengo suficiente contexto. Necesito un par de datos para conectarte con la persona correcta.",
      "advisor-name-label": "Nombre",
      "advisor-name-ph": "Su nombre",
      "advisor-email-label": "Correo electrónico",
      "advisor-email-ph": "usted@empresa.com",
      "advisor-btype-label": "Tipo de negocio",
      "advisor-btype-opt0": "Seleccionar...",
      "advisor-btype-contractor": "Contratista (HVAC, Plomería, Electricidad, Techado)",
      "advisor-btype-multifamily": "Operaciones Multifamiliares",
      "advisor-btype-service": "Negocio de Servicios",
      "advisor-btype-other": "Otro",
      "advisor-urgency-label": "Urgencia",
      "advisor-urgency-opt0": "Seleccionar...",
      "advisor-urgency-immediate": "Necesito resolver esto ahora",
      "advisor-urgency-month": "Dentro del próximo mes",
      "advisor-urgency-exploring": "Estoy explorando opciones",
      "advisor-submit": "Enviar a la Mesa de Asesoría",
      "advisor-submitting": "Enviando...",
      "advisor-success-msg": "Recibimos su información. Nuestro Equipo de Asesoría Ejecutiva se pondrá en contacto dentro de las próximas 24 horas.",
      "advisor-success-cta": "Reservar Diagnóstico Ejecutivo",
      "advisor-error-msg": "No pudimos procesar su envío. Por favor intente de nuevo o escríbanos directamente a ceo@racbconsulting.com.",
      "advisor-validation-name": "Por favor ingrese su nombre.",
      "advisor-validation-email": "Por favor ingrese un correo electrónico válido.",
      "advisor-validation-btype": "Por favor seleccione su tipo de negocio.",
      "advisor-validation-urgency": "Por favor seleccione su urgencia.",
      "fp-footer-label": "Consultoría Ejecutiva",
      "fp-footer-headline": "Si todavía está aquí, su operación está dejando dinero sobre la mesa.",
      "fp-footer-subtext": "Identificamos dónde su empresa está perdiendo dinero y qué debe corregirse primero.",
      "about-hero-badge": "Firma de Consultoría Ejecutiva — Austin, Texas",
      "about-hero-title": "No Somos un Proveedor de Software",
      "about-hero-sub": "Somos una firma de consultoría ejecutiva.<br>Diagnosticamos el fallo operativo antes de recomendar nada.",
      "about-hero-body": "La mayoría de las empresas llegan con una solicitud de automatización.<br>Reducimos la velocidad de esa conversación, porque el problema casi nunca es la herramienta.",
      "about-hero-cta2": "Sobre la Firma",
      "about-philosophy-label": "Nuestra Filosofía",
      "about-philosophy-title": "Diagnóstico Antes de la Implementación",
      "about-philosophy-lead": "La automatización sin claridad ejecutiva es costosa.",
      "about-philosophy-support": "La mayoría de las empresas no tienen un problema de software.<br>Tienen un problema de estructura operativa.<br>Añadir herramientas a una ejecución deficiente acelera el daño.",
      "about-philosophy-intro": "Comenzamos cada compromiso identificando:",
      "about-philosophy-li1": "dónde se están fugando los ingresos",
      "about-philosophy-li2": "dónde está fallando la ejecución",
      "about-philosophy-li3": "qué cuellos de botella de liderazgo existen",
      "about-philosophy-li4": "qué debe corregirse antes de automatizar cualquier cosa",
      "about-philosophy-li5": "qué nunca debe automatizarse",
      "about-philosophy-close": "Esa disciplina es lo que separa la consultoría operativa de la venta de software.",
      "about-philosophy-quote": "Automatizar un proceso roto no crea eficiencia.<br>Acelera el daño.",
      "about-philosophy-quote-footer": "Por eso cada compromiso de RACBCONSULTING comienza con el Diagnóstico Ejecutivo.<br>No con una propuesta. No con una demo. Con el diagnóstico.",
      "about-firm-label": "La Firma",
      "about-firm-title": "RACBCONSULTING LLC",
      "about-firm-lead": "Con sede en Austin, Texas.<br>Atendiendo operadores en todo Estados Unidos y América Latina.",
      "about-firm-intro": "Trabajamos con:",
      "about-firm-li1": "Contratistas — HVAC, plomería, electricidad, techado, contratistas generales",
      "about-firm-li2": "Operaciones multifamiliares — administración de propiedades, mantenimiento, coordinación de proveedores",
      "about-firm-li3": "Negocios de servicios — servicios profesionales, médico, legal, servicios del hogar",
      "about-firm-close": "No estamos construidos para empresas que buscan automatización barata.<br>Estamos construidos para operadores que entienden que los fallos de ejecución cuestan dinero real.",
      "about-firm-panel-intro": "Nuestro trabajo se juzga por:",
      "about-firm-panel-li1": "qué deja de fugarse",
      "about-firm-panel-li2": "qué deja de fallar",
      "about-firm-panel-li3": "qué deja de atrapar al liderazgo",
      "about-firm-panel-li4": "qué ejecución se vuelve confiable sin supervisión constante",
      "about-firm-panel-close": "No por lo impresionante que parece la automatización.",
      "about-what-label": "Qué Hacemos",
      "about-what-title": "El Diagnóstico Ejecutivo",
      "about-what-lead": "Una revisión operativa estructurada, no una llamada de ventas.",
      "about-what-support": "Identificamos dónde su empresa está perdiendo dinero, dónde está fallando la ejecución y qué debe suceder a continuación.<br>Tanto si la implementación ocurre con nosotros como si no.",
      "about-what-m1": "No vendemos automatización.",
      "about-what-m2": "Resolvemos problemas operativos.",
      "about-what-m3": "La automatización es solo la capa de implementación.",
      "about-what-m4": "El producto real es el juicio ejecutivo.",
      "about-cta-label": "Listo para Comenzar",
      "about-cta-title": "Reserve su Diagnóstico Ejecutivo",
      "about-cta-intro": "Las empresas calificadas reciben actualmente el Diagnóstico Ejecutivo Inicial sin costo.",
      "about-cta-body": "Esto no es una llamada de ventas.<br>Es una revisión operativa ejecutiva enfocada en identificar dónde su empresa está perdiendo dinero y qué debe ocurrir primero.",
      "cases-hero-badge": "Evidencia Ejecutiva — Resultados Operativos",
      "cases-hero-title": "Donde Mejoran las Operaciones,<br>los Ingresos Siguen",
      "cases-hero-sub": "Los resultados no se miden por lo bien que parece la automatización.",
      "cases-hero-body": "Se miden por la velocidad de respuesta, la calidad de ejecución, la claridad operativa y los ingresos recuperables.<br>Ahí es donde existe la prueba real.",
      "cases-hero-cta2": "Ver los Resultados",
      "cases-context-label": "Por Qué Importan Estos Casos",
      "cases-context-title": "No Medimos Impresiones",
      "cases-context-lead": "Cada caso a continuación comenzó con un diagnóstico operativo, no con una recomendación de herramientas.",
      "cases-context-support": "Identificamos dónde estaba fallando la ejecución,<br>dónde se estaban fugando los ingresos<br>y qué necesitaba cambiar antes de automatizar cualquier cosa.",
      "cases-context-intro": "Los problemas que buscamos:",
      "cases-context-li1": "leads no respondidos con suficiente rapidez",
      "cases-context-li2": "presupuestos que llegan demasiado tarde",
      "cases-context-li3": "programación que falla bajo presión",
      "cases-context-li4": "disciplina de seguimiento que desaparece",
      "cases-context-li5": "liderazgo atrapado dentro de las operaciones diarias",
      "cases-context-li6": "sobrecarga administrativa que ralentiza la ejecución",
      "cases-context-close": "Estos no son problemas de software.<br>Son problemas de estructura operativa, y esa distinción lo cambia todo.",
      "cases-proof-label": "Evidencia Ejecutiva",
      "cases-proof-title": "Tres Verticales. Un Patrón.",
      "cases-proof-lead": "El fallo operativo cuesta dinero en cada industria.<br>Los síntomas difieren. La causa raíz es casi siempre la misma.",
      "cases-v1-label": "Vertical — Contratistas",
      "cases-v1-title": "HVAC, Plomería, Electricidad, Techado, Contratistas Generales",
      "cases-v1-vertical": "Operaciones de Contratistas",
      "cases-v1-p1": "Llamadas perdidas en volumen",
      "cases-v1-p2": "Brechas de programación entre trabajos",
      "cases-v1-p3": "Presupuestos tardíos — el cliente ya avanzó con otro",
      "cases-v1-p4": "Fuga de ingresos entre ciclos de despacho",
      "cases-v1-r1": "Respuesta más rápida a leads",
      "cases-v1-r2": "Despacho y programación más ordenados",
      "cases-v1-r3": "Mayor consistencia de reservas",
      "cases-v1-r4": "Visibilidad operativa entre trabajos",
      "cases-v2-label": "Vertical — Operaciones Multifamiliares",
      "cases-v2-title": "Administración de Propiedades, Operaciones de Mantenimiento, Coordinación de Proveedores",
      "cases-v2-vertical": "Operaciones Multifamiliares",
      "cases-v2-p1": "Cuellos de botella en órdenes de trabajo a escala",
      "cases-v2-p2": "Fallos de coordinación con proveedores",
      "cases-v2-p3": "Ejecución tardía en mantenimiento",
      "cases-v2-p4": "Liderazgo sobrecargado por ruido operativo",
      "cases-v2-r1": "Flujos de trabajo y traspasos más ordenados",
      "cases-v2-r2": "Fricción con proveedores reducida",
      "cases-v2-r3": "Control de ejecución restaurado",
      "cases-v2-r4": "Visibilidad de liderazgo sin apagar incendios diarios",
      "cases-v3-label": "Vertical — Negocios de Servicios",
      "cases-v3-title": "Servicios Profesionales, Médico, Legal, Servicios del Hogar",
      "cases-v3-vertical": "Operaciones de Negocios de Servicios",
      "cases-v3-p1": "Disciplina de seguimiento deficiente",
      "cases-v3-p2": "Lastre administrativo que ralentiza los ingresos",
      "cases-v3-p3": "Baja conversión de leads por traspasos desorganizados",
      "cases-v3-p4": "Crecimiento sin estructura operativa que lo soporte",
      "cases-v3-r1": "Disciplina operativa restaurada",
      "cases-v3-r2": "Flujo de decisiones más ágil",
      "cases-v3-r3": "Mejor conversión de lead a cliente",
      "cases-v3-r4": "Ejecución escalable sin añadir personal",
      "cases-proof-statement1": "Las buenas operaciones generan resultados medibles.",
      "cases-proof-statement2": "El buen marketing solo genera atención temporal.",
      "cases-proof-statement3": "Nosotros optimizamos lo primero.",
      "cases-proof-authority1": "Nuestro trabajo no se juzga por lo impresionante que parece la automatización.",
      "cases-proof-authority2": "Se juzga por lo que deja de fallar.",
      "cases-cta-label": "Siguiente Paso",
      "cases-cta-title": "Su Operación Podría Ser la Siguiente",
      "cases-cta-intro": "Si su negocio depende de velocidad, coordinación, ejecución y disciplina operativa, aquí es donde el dinero desaparece primero.",
      "cases-cta-body": "Comience con el Diagnóstico Ejecutivo.<br>Identificamos dónde su empresa está perdiendo dinero antes de recomendar cualquier cosa.",
      "contact-hero-badge": "Mesa de Asesoría Ejecutiva — Disponibilidad Limitada",
      "contact-hero-title": "Comience la Conversación Correcta Primero",
      "contact-hero-sub": "Antes de reservar su Diagnóstico Ejecutivo, hable directamente con nuestra Mesa de Asesoría Ejecutiva.",
      "contact-hero-body": "Ayudamos a identificar si el problema es la generación de leads, las operaciones, la programación, la disciplina de seguimiento o la fuga oculta de ingresos —<br>para que la conversación de diagnóstico esté enfocada desde el principio.",
      "contact-hero-cta2": "Hablar Con un Asesor",
      "contact-options-label": "Cómo Contactarnos",
      "contact-options-title": "Tres Formas de Comenzar",
      "contact-options-lead": "Elija el canal que mejor se ajuste a donde se encuentra en la decisión.",
      "contact-c1-label": "Mesa de Asesoría Ejecutiva",
      "contact-c1-title": "Hablar Con un Asesor",
      "contact-c1-body": "¿No sabe por dónde empezar? Nuestro Asesor Ejecutivo le ayuda a identificar si el problema es la respuesta a leads, la programación, el seguimiento o un fallo operativo oculto — antes de reservar nada.",
      "contact-c1-cta": "Iniciar Conversación de Asesoría",
      "contact-c2-label": "Camino Más Rápido",
      "contact-c2-title": "Reservar Diagnóstico Ejecutivo",
      "contact-c2-body": "¿Listo para diagnosticar? Las empresas calificadas reciben actualmente el Diagnóstico Ejecutivo Inicial sin costo. Esta es una revisión operativa estructurada, no una llamada de ventas.",
      "contact-c3-label": "Línea Directa",
      "contact-c3-title": "Escribir al Equipo Ejecutivo",
      "contact-c3-body": "Para consultas específicas, discusiones de asociación o cualquier asunto que no encaje en una conversación de diagnóstico, contacte directamente al equipo ejecutivo.",
      "contact-expect-label": "Qué Esperar",
      "contact-expect-title": "Esto No Es un Proceso de Ventas",
      "contact-expect-lead": "Cada conversación en RACBCONSULTING comienza con escuchar, no con vender.",
      "contact-expect-intro": "Cuando se comunique con nosotros, preguntaremos sobre:",
      "contact-expect-li1": "cómo ingresan actualmente los leads y con qué rapidez se responden",
      "contact-expect-li2": "dónde falla la programación o el despacho bajo presión",
      "contact-expect-li3": "cómo se gestiona el seguimiento y si es consistente",
      "contact-expect-li4": "dónde el tiempo de liderazgo está siendo consumido por el ruido operativo",
      "contact-expect-li5": "qué se ha intentado ya y por qué no ha funcionado",
      "contact-expect-close": "Esas respuestas determinan si el Diagnóstico Ejecutivo es el siguiente paso correcto y en qué debe enfocarse.",
      "contact-expect-m1": "No vendemos herramientas.",
      "contact-expect-m2": "No hacemos demos genéricas.",
      "contact-expect-m3": "Identificamos qué está realmente roto.",
      "contact-cta-label": "Mesa de Asesoría Ejecutiva",
      "contact-cta-title": "Hable Con Su Asesor Ejecutivo Privado",
      "contact-cta-intro": "Antes de reservar su Diagnóstico Ejecutivo, hable directamente con nuestra Mesa de Asesoría Ejecutiva.",
      "contact-cta-body": "Ayudamos a identificar si el problema es la generación de leads, las operaciones, la programación,<br>la disciplina de seguimiento o la fuga oculta de ingresos.<br>Comience la conversación correcta primero.",
      "contact-cta-btn": "Iniciar Conversación de Asesoría"
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
      "nav-cta": "Book Executive Diagnostic",
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
      "cop-label": "Contact",
      "fp-cta-btn": "Book Executive Diagnostic",
      "fp-hero-badge": "Free Initial Executive Diagnostic — Limited Availability",
      "fp-hero-title": "Where Is Your Company Quietly Losing Money?",
      "fp-hero-sub": "Most businesses do not have a lead problem.<br>They have an operational response problem.",
      "fp-hero-body": "We identify missed revenue, scheduling failures, leadership bottlenecks, administrative overload, and execution gaps before they become expensive.",
      "fp-hero-cta2": "See How It Works",
      "fp-authority-label": "The Approach",
      "fp-authority-title": "We Do Not Sell Automation",
      "fp-authority-lead": "Most companies ask for automation.",
      "fp-authority-support": "The real problem is operational failure.<br>More software does not fix execution.<br>It makes it more expensive.",
      "fp-authority-diag-intro1": "Businesses rarely lose money because they lack tools.",
      "fp-authority-diag-intro2": "They lose money because:",
      "fp-authority-li1": "leads are not answered fast enough",
      "fp-authority-li2": "estimates arrive too late",
      "fp-authority-li3": "scheduling breaks under pressure",
      "fp-authority-li4": "follow-up discipline disappears",
      "fp-authority-li5": "leadership gets trapped in operations",
      "fp-authority-li6": "administrative overload kills execution",
      "fp-authority-diag-close": "The problem is rarely software.<br>The problem is operational structure.",
      "fp-authority-quote": "Automating a broken process does not create efficiency.<br>It accelerates the damage.",
      "fp-authority-quote-footer": "That is why we start with diagnosis first.<br>Not implementation. Not automation. Diagnosis.",
      "fp-authority-panel-intro": "Before adding systems, we identify:",
      "fp-authority-panel-li1": "where revenue is leaking",
      "fp-authority-panel-li2": "where execution is failing",
      "fp-authority-panel-li3": "what should be fixed first",
      "fp-authority-panel-li4": "what should never be automated",
      "fp-authority-panel-close": "Because automation without executive clarity is expensive.",
      "fp-authority-manifesto1": "We do not sell automation.",
      "fp-authority-manifesto2": "We solve operational problems.",
      "fp-authority-manifesto3": "Automation is only the implementation layer.",
      "fp-authority-manifesto4": "The real product is executive judgment.",
      "fp-authority-cta-label": "Start With Diagnosis",
      "fp-verticals-label": "Verticals We Serve",
      "fp-verticals-title": "Who We Help",
      "fp-verticals-lead": "We work with companies where operational failure becomes expensive.<br>Not hobby businesses. Not experiments.<br>Real operations. Real pressure. Real money.",
      "fp-v1-title": "Contractors",
      "fp-v1-ex1": "HVAC",
      "fp-v1-ex2": "Plumbing",
      "fp-v1-ex3": "Electrical",
      "fp-v1-ex4": "Roofing",
      "fp-v1-ex5": "General Contractors",
      "fp-v1-ex6": "Field Service Businesses",
      "fp-pain-label": "Where money disappears:",
      "fp-v1-pain1": "Scheduling chaos",
      "fp-v1-pain2": "Missed calls",
      "fp-v1-pain3": "Slow estimates",
      "fp-v1-pain4": "Dispatch pressure",
      "fp-v1-pain5": "Administrative overload",
      "fp-v1-pain6": "Revenue leakage between jobs",
      "fp-v2-title": "Multifamily Operations",
      "fp-v2-ex1": "Property Management",
      "fp-v2-ex2": "Maintenance Operations",
      "fp-v2-ex3": "Vendor Coordination",
      "fp-v2-ex4": "Leasing Support",
      "fp-v2-ex5": "Service Execution",
      "fp-v2-ex6": "Resident Operations",
      "fp-v2-pain1": "Work order bottlenecks",
      "fp-v2-pain2": "Vendor friction",
      "fp-v2-pain3": "Delayed execution",
      "fp-v2-pain4": "Communication failures",
      "fp-v2-pain5": "Operational blind spots",
      "fp-v2-pain6": "Leadership overload",
      "fp-v3-title": "Service Businesses",
      "fp-v3-ex1": "Professional Services",
      "fp-v3-ex2": "Medical",
      "fp-v3-ex3": "Legal",
      "fp-v3-ex4": "Home Services",
      "fp-v3-ex5": "Executive Operations",
      "fp-v3-ex6": "Growing Service Teams",
      "fp-v3-pain1": "Follow-up failure",
      "fp-v3-pain2": "Administrative drag",
      "fp-v3-pain3": "Poor lead conversion",
      "fp-v3-pain4": "Broken handoffs",
      "fp-v3-pain5": "Execution inconsistency",
      "fp-v3-pain6": "Growth without operational structure",
      "fp-verticals-statement1": "If your business depends on speed, coordination, execution, and operational discipline—",
      "fp-verticals-statement2": "this is where money disappears first.",
      "fp-verticals-exclusion1": "We are not built for businesses looking for cheap automation.",
      "fp-verticals-exclusion2": "We are built for operators who understand that execution failures cost real money.",
      "fp-verticals-cta-label": "If operations break, revenue follows.",
      "fp-diagnose-label": "Executive Diagnostic",
      "fp-diagnose-title": "What We Diagnose",
      "fp-diagnose-lead": "Most companies do not notice where money is disappearing.<br>They only notice when growth slows, margins tighten, and leadership gets pulled into operational chaos.<br>We identify the hidden failures before they become expensive.",
      "fp-d1-title": "Lost Leads",
      "fp-d1-situation": "Leads arrive. Nobody responds fast enough.",
      "fp-d1-consequence": "The opportunity disappears before the conversation starts.",
      "fp-d2-title": "Scheduling Chaos",
      "fp-d2-situation": "Jobs stack. Dispatch breaks. Priority decisions become daily emergencies.",
      "fp-d2-consequence": "Operations become reactive instead of controlled.",
      "fp-d3-title": "Delayed Estimates",
      "fp-d3-situation": "Quotes arrive too late. The client already moved forward with someone else.",
      "fp-d3-consequence": "Revenue is lost silently.",
      "fp-d4-title": "Administrative Overload",
      "fp-d4-situation": "Leaders get trapped inside admin work.",
      "fp-d4-consequence": "Execution slows because decisions are buried under operations.",
      "fp-d5-title": "Follow-Up Failure",
      "fp-d5-situation": "Nobody follows up consistently.",
      "fp-d5-consequence": "Opportunities die without anyone noticing.",
      "fp-d6-title": "Leadership Bottlenecks",
      "fp-d6-situation": "Everything depends on one person.",
      "fp-d6-consequence": "Growth becomes impossible because execution cannot scale.",
      "fp-d7-title": "Hidden Revenue Leakage",
      "fp-d7-situation": "Small operational failures compound.",
      "fp-d7-consequence": "No single disaster. Just constant invisible financial damage.",
      "fp-diagnose-statement1": "Most businesses do not have a sales problem.",
      "fp-diagnose-statement2": "They have an execution visibility problem.",
      "fp-diagnose-purpose1": "We do not guess.",
      "fp-diagnose-purpose2": "We diagnose.",
      "fp-diagnose-purpose3": "We identify where money is leaking, what must be fixed first, and what should never be automated.",
      "fp-diagnose-cta-label": "Clarity before automation.",
      "fp-exd-label": "The Process",
      "fp-exd-title": "The Executive Diagnostic",
      "fp-exd-lead": "This is not a sales call.<br>This is an executive operational review focused on identifying where your company loses money, where execution is breaking, and what should happen next.",
      "fp-exd-s1-step": "Step 1",
      "fp-exd-s1-title": "Executive Intake",
      "fp-exd-s1-body1": "We review your operation, current systems, decision flow, scheduling pressure, response discipline, leadership bottlenecks, and revenue leakage indicators.",
      "fp-exd-s1-body2": "We identify how the business actually operates — not how it looks on paper.",
      "fp-exd-s2-step": "Step 2",
      "fp-exd-s2-title": "Operational Diagnosis",
      "fp-exd-s2-body1": "We map where execution breaks.",
      "fp-exd-s2-li1": "Lead response",
      "fp-exd-s2-li2": "Scheduling",
      "fp-exd-s2-li3": "Estimates",
      "fp-exd-s2-li4": "Follow-up",
      "fp-exd-s2-li5": "Admin overload",
      "fp-exd-s2-li6": "Leadership dependency",
      "fp-exd-s2-body2": "We isolate where money is leaking.",
      "fp-exd-s3-step": "Step 3",
      "fp-exd-s3-title": "Strategic Review",
      "fp-exd-s3-body1": "We define what should be fixed first.",
      "fp-exd-s3-li1": "What should be automated",
      "fp-exd-s3-li2": "What should never be automated",
      "fp-exd-s3-li3": "What creates the fastest operational impact",
      "fp-exd-s4-step": "Step 4",
      "fp-exd-s4-title": "Executive Recommendation",
      "fp-exd-s4-body1": "You receive strategic clarity.",
      "fp-exd-s4-body2": "Not generic advice.",
      "fp-exd-s4-body3": "A real executive path forward.",
      "fp-exd-s4-body4": "Whether implementation happens with us or not.",
      "fp-exd-statement1": "Most companies try to buy tools before understanding the problem.",
      "fp-exd-statement2": "That is backwards.",
      "fp-exd-statement3": "We fix that first.",
      "fp-exd-trust1": "This is why qualified companies are currently receiving the Initial Executive Diagnostic at no cost.",
      "fp-exd-trust2": "Because clarity creates better decisions.",
      "fp-exd-cta-label": "Limited availability for qualified companies.",
      "fp-proof-label": "Executive Proof",
      "fp-proof-title": "Where Operations Improve, Revenue Follows",
      "fp-proof-lead": "Results are not measured by how good automation looks.<br>They are measured by response speed, execution quality, operational clarity, and recoverable revenue.<br>That is where real proof exists.",
      "fp-proof-z-problem": "Problem",
      "fp-proof-z-result": "Result",
      "fp-pc1-vertical": "Contractor Operations",
      "fp-pc1-p1": "Missed calls",
      "fp-pc1-p2": "Scheduling gaps",
      "fp-pc1-p3": "Delayed estimates",
      "fp-pc1-p4": "Revenue leakage between jobs",
      "fp-pc1-r1": "Faster response",
      "fp-pc1-r2": "Cleaner dispatch",
      "fp-pc1-r3": "Higher booking consistency",
      "fp-pc1-r4": "Operational visibility",
      "fp-pc2-vertical": "Multifamily Operations",
      "fp-pc2-p1": "Maintenance pressure",
      "fp-pc2-p2": "Vendor coordination failures",
      "fp-pc2-p3": "Delayed execution",
      "fp-pc2-p4": "Administrative overload",
      "fp-pc2-r1": "Cleaner workflows",
      "fp-pc2-r2": "Reduced friction",
      "fp-pc2-r3": "Execution control",
      "fp-pc2-r4": "Leadership visibility",
      "fp-pc3-vertical": "Service Business Operations",
      "fp-pc3-p1": "Broken follow-up",
      "fp-pc3-p2": "Administrative drag",
      "fp-pc3-p3": "Poor lead conversion",
      "fp-pc3-p4": "Growth without operational structure",
      "fp-pc3-r1": "Operational discipline",
      "fp-pc3-r2": "Faster decision flow",
      "fp-pc3-r3": "Better conversion",
      "fp-pc3-r4": "Scalable execution",
      "fp-proof-statement1": "Good operations create measurable outcomes.",
      "fp-proof-statement2": "Good marketing only creates temporary attention.",
      "fp-proof-statement3": "We optimize the first.",
      "fp-proof-authority1": "Our work is not judged by how impressive the automation looks.",
      "fp-proof-authority2": "It is judged by what stops breaking.",
      "fp-proof-cta-label": "If operations improve, revenue follows.",
      "fp-advisor-label": "Executive Advisory Desk",
      "fp-advisor-title": "Speak With Your Private Executive Advisor",
      "fp-advisor-intro": "Before booking your Executive Diagnostic, speak directly with our Executive Advisory Desk.",
      "fp-advisor-body": "We help identify if the issue is lead generation, operations, scheduling, follow-up discipline, or hidden revenue leakage. Start the right conversation first.",
      "fp-advisor-cta": "Start Advisory Conversation",
      "fp-advisor-modal-label": "Private Executive Advisor",
      "fp-advisor-modal-title": "Executive Advisor",
      "fp-advisor-welcome": "Walk me through what's happening. Start with wherever the pressure is highest.",
      "fp-advisor-qp1": "We're losing leads",
      "fp-advisor-qp2": "Scheduling keeps breaking",
      "fp-advisor-qp3": "Follow-up keeps falling through",
      "fp-advisor-qp4": "We can't keep up operationally",
      "fp-advisor-input-placeholder": "Tell me what's breaking...",
      "advisor-ack": "That gives me enough context. I just need a couple of details to connect you with the right person.",
      "advisor-greeting-reply": "What part of the operation is giving you the most trouble right now?",
      "advisor-service-reply": "That depends on what you're actually trying to fix. What's breaking in the operation that's driving this?",
      "advisor-operational-reply": "That's a pattern we see often. Is this happening constantly, or does it spike at certain moments?",
      "advisor-unknown-reply": "What part of the operation is creating the most noise for you right now?",
      "advisor-route-diagnostic": "I want an Executive Diagnostic",
      "advisor-route-service": "I need a specific service",
      "advisor-route-unsure": "Still exploring",
      "advisor-diagnostic-reply": "Right. The Executive Diagnostic is the right starting point. I need a couple of details to route this to the right person.",
      "advisor-service-follow-reply": "We can look at that. Before making any recommendation, tell me what process or outcome needs to improve first.",
      "advisor-unsure-reply": "That's fine. The first step is always identifying where the money is going. Is there something urgent right now, or are you exploring options?",
      "advisor-bridge": "That gives me enough context. I just need a couple of details to connect you with the right person.",
      "advisor-name-label": "Name",
      "advisor-name-ph": "Your name",
      "advisor-email-label": "Email",
      "advisor-email-ph": "you@company.com",
      "advisor-btype-label": "Business type",
      "advisor-btype-opt0": "Select...",
      "advisor-btype-contractor": "Contractor (HVAC, Plumbing, Electrical, Roofing)",
      "advisor-btype-multifamily": "Multifamily Operations",
      "advisor-btype-service": "Service Business",
      "advisor-btype-other": "Other",
      "advisor-urgency-label": "Urgency",
      "advisor-urgency-opt0": "Select...",
      "advisor-urgency-immediate": "I need to resolve this now",
      "advisor-urgency-month": "Within the next month",
      "advisor-urgency-exploring": "Exploring options",
      "advisor-submit": "Send to Advisory Desk",
      "advisor-submitting": "Sending...",
      "advisor-success-msg": "We have your information. Our Executive Advisory Desk will be in touch within 24 hours.",
      "advisor-success-cta": "Book Executive Diagnostic",
      "advisor-error-msg": "Unable to process your submission. Please try again or reach us directly at ceo@racbconsulting.com.",
      "advisor-validation-name": "Please enter your name.",
      "advisor-validation-email": "Please enter a valid email address.",
      "advisor-validation-btype": "Please select your business type.",
      "advisor-validation-urgency": "Please select your urgency.",
      "fp-footer-label": "Executive Consulting",
      "fp-footer-headline": "If you're still here, your operation is leaving money on the table.",
      "fp-footer-subtext": "We identify where your company is losing money — and what needs to be fixed first.",
      "about-hero-badge": "Executive Consulting Firm — Austin, Texas",
      "about-hero-title": "We Are Not a Software Vendor",
      "about-hero-sub": "We are an executive consulting firm.<br>We diagnose operational failure before recommending anything.",
      "about-hero-body": "Most companies arrive with an automation request.<br>We slow that conversation down — because the problem is almost never the tool.",
      "about-hero-cta2": "About the Firm",
      "about-philosophy-label": "Our Philosophy",
      "about-philosophy-title": "Diagnosis Before Implementation",
      "about-philosophy-lead": "Automation without executive clarity is expensive.",
      "about-philosophy-support": "Most businesses do not have a software problem.<br>They have an operational structure problem.<br>Adding tools to broken execution makes the damage faster.",
      "about-philosophy-intro": "We start every engagement by identifying:",
      "about-philosophy-li1": "where revenue is leaking",
      "about-philosophy-li2": "where execution is breaking",
      "about-philosophy-li3": "what leadership bottlenecks exist",
      "about-philosophy-li4": "what should be fixed before anything is automated",
      "about-philosophy-li5": "what should never be automated at all",
      "about-philosophy-close": "That discipline is what separates operational consulting from software sales.",
      "about-philosophy-quote": "Automating a broken process does not create efficiency.<br>It accelerates the damage.",
      "about-philosophy-quote-footer": "That is why every RACBCONSULTING engagement starts with the Executive Diagnostic.<br>Not a proposal. Not a demo. Diagnosis.",
      "about-firm-label": "The Firm",
      "about-firm-title": "RACBCONSULTING LLC",
      "about-firm-lead": "Headquartered in Austin, Texas.<br>Serving operators across the United States and Latin America.",
      "about-firm-intro": "We work with:",
      "about-firm-li1": "Contractors — HVAC, plumbing, electrical, roofing, general contractors",
      "about-firm-li2": "Multifamily operations — property management, maintenance, vendor coordination",
      "about-firm-li3": "Service businesses — professional services, medical, legal, home services",
      "about-firm-close": "We are not built for companies looking for cheap automation.<br>We are built for operators who understand that execution failures cost real money.",
      "about-firm-panel-intro": "Our work is judged by:",
      "about-firm-panel-li1": "what stops leaking",
      "about-firm-panel-li2": "what stops breaking",
      "about-firm-panel-li3": "what leadership stops being trapped inside",
      "about-firm-panel-li4": "what execution becomes reliable without constant oversight",
      "about-firm-panel-close": "Not by how impressive the automation looks.",
      "about-what-label": "What We Do",
      "about-what-title": "The Executive Diagnostic",
      "about-what-lead": "A structured operational review — not a sales call.",
      "about-what-support": "We identify where your company is losing money, where execution is failing, and what should happen next.<br>Whether implementation happens with us or not.",
      "about-what-m1": "We do not sell automation.",
      "about-what-m2": "We solve operational problems.",
      "about-what-m3": "Automation is only the implementation layer.",
      "about-what-m4": "The real product is executive judgment.",
      "about-cta-label": "Ready to Start",
      "about-cta-title": "Book Your Executive Diagnostic",
      "about-cta-intro": "Qualified companies are currently receiving the Initial Executive Diagnostic at no cost.",
      "about-cta-body": "This is not a sales call.<br>It is an executive operational review focused on identifying where your company is losing money and what needs to happen first.",
      "cases-hero-badge": "Executive Proof — Operational Results",
      "cases-hero-title": "Where Operations Improve,<br>Revenue Follows",
      "cases-hero-sub": "Results are not measured by how good the automation looks.",
      "cases-hero-body": "They are measured by response speed, execution quality, operational clarity, and recoverable revenue.<br>That is where real proof exists.",
      "cases-hero-cta2": "See the Results",
      "cases-context-label": "Why These Cases Matter",
      "cases-context-title": "We Do Not Measure Impressions",
      "cases-context-lead": "Every case below started with an operational diagnosis — not a tool recommendation.",
      "cases-context-support": "We identified where execution was breaking,<br>where revenue was leaking,<br>and what needed to change before anything was automated.",
      "cases-context-intro": "The problems we look for:",
      "cases-context-li1": "leads not answered fast enough",
      "cases-context-li2": "estimates arriving too late",
      "cases-context-li3": "scheduling that breaks under pressure",
      "cases-context-li4": "follow-up discipline that disappears",
      "cases-context-li5": "leadership trapped inside daily operations",
      "cases-context-li6": "administrative overload slowing execution",
      "cases-context-close": "These are not software problems.<br>They are operational structure problems — and that distinction changes everything.",
      "cases-proof-label": "Executive Proof",
      "cases-proof-title": "Three Verticals. One Pattern.",
      "cases-proof-lead": "Operational failure costs money in every industry.<br>The symptoms differ. The root cause is almost always the same.",
      "cases-v1-label": "Vertical — Contractors",
      "cases-v1-title": "HVAC, Plumbing, Electrical, Roofing, General Contractors",
      "cases-v1-vertical": "Contractor Operations",
      "cases-v1-p1": "Missed calls at volume",
      "cases-v1-p2": "Scheduling gaps between jobs",
      "cases-v1-p3": "Delayed estimates — client already moved on",
      "cases-v1-p4": "Revenue leakage between dispatch cycles",
      "cases-v1-r1": "Faster lead response",
      "cases-v1-r2": "Cleaner dispatch and scheduling",
      "cases-v1-r3": "Higher booking consistency",
      "cases-v1-r4": "Operational visibility across jobs",
      "cases-v2-label": "Vertical — Multifamily Operations",
      "cases-v2-title": "Property Management, Maintenance Operations, Vendor Coordination",
      "cases-v2-vertical": "Multifamily Operations",
      "cases-v2-p1": "Work order bottlenecks at scale",
      "cases-v2-p2": "Vendor coordination failures",
      "cases-v2-p3": "Delayed execution on maintenance",
      "cases-v2-p4": "Leadership overloaded by operational noise",
      "cases-v2-r1": "Cleaner workflows and handoffs",
      "cases-v2-r2": "Reduced vendor friction",
      "cases-v2-r3": "Execution control restored",
      "cases-v2-r4": "Leadership visibility without daily firefighting",
      "cases-v3-label": "Vertical — Service Businesses",
      "cases-v3-title": "Professional Services, Medical, Legal, Home Services",
      "cases-v3-vertical": "Service Business Operations",
      "cases-v3-p1": "Broken follow-up discipline",
      "cases-v3-p2": "Administrative drag slowing revenue",
      "cases-v3-p3": "Poor lead conversion from disorganized handoffs",
      "cases-v3-p4": "Growth without operational structure to support it",
      "cases-v3-r1": "Operational discipline restored",
      "cases-v3-r2": "Faster decision flow",
      "cases-v3-r3": "Better lead-to-client conversion",
      "cases-v3-r4": "Scalable execution without adding headcount",
      "cases-proof-statement1": "Good operations create measurable outcomes.",
      "cases-proof-statement2": "Good marketing only creates temporary attention.",
      "cases-proof-statement3": "We optimize the first.",
      "cases-proof-authority1": "Our work is not judged by how impressive the automation looks.",
      "cases-proof-authority2": "It is judged by what stops breaking.",
      "cases-cta-label": "Next Step",
      "cases-cta-title": "Your Operation Could Be Next",
      "cases-cta-intro": "If your business depends on speed, coordination, execution, and operational discipline — this is where money disappears first.",
      "cases-cta-body": "Start with the Executive Diagnostic.<br>We identify where your company is losing money before recommending anything.",
      "contact-hero-badge": "Executive Advisory Desk — Limited Availability",
      "contact-hero-title": "Start the Right Conversation First",
      "contact-hero-sub": "Before booking your Executive Diagnostic, speak directly with our Executive Advisory Desk.",
      "contact-hero-body": "We help identify whether the issue is lead generation, operations, scheduling, follow-up discipline, or hidden revenue leakage — so the diagnostic conversation is focused from the start.",
      "contact-hero-cta2": "Speak With an Advisor",
      "contact-options-label": "How to Reach Us",
      "contact-options-title": "Three Ways to Start",
      "contact-options-lead": "Choose the channel that matches where you are in the decision.",
      "contact-c1-label": "Executive Advisory Desk",
      "contact-c1-title": "Speak With an Advisor",
      "contact-c1-body": "Not sure where to start? Our Executive Advisor helps you identify whether the problem is lead response, scheduling, follow-up, or hidden operational failure — before you book anything.",
      "contact-c1-cta": "Start Advisory Conversation",
      "contact-c2-label": "Fastest Path",
      "contact-c2-title": "Book Executive Diagnostic",
      "contact-c2-body": "Ready to diagnose? Qualified companies are currently receiving the Initial Executive Diagnostic at no cost. This is a structured operational review — not a sales call.",
      "contact-c3-label": "Direct Line",
      "contact-c3-title": "Email the Executive Team",
      "contact-c3-body": "For specific inquiries, partnership discussions, or anything that does not fit a diagnostic conversation, reach the executive team directly.",
      "contact-expect-label": "What to Expect",
      "contact-expect-title": "This Is Not a Sales Process",
      "contact-expect-lead": "Every conversation at RACBCONSULTING starts with listening — not pitching.",
      "contact-expect-intro": "When you reach out, we will ask about:",
      "contact-expect-li1": "how leads currently enter and how fast they are answered",
      "contact-expect-li2": "where scheduling or dispatch breaks under pressure",
      "contact-expect-li3": "how follow-up is handled and whether it is consistent",
      "contact-expect-li4": "where leadership time is being consumed by operational noise",
      "contact-expect-li5": "what has already been tried and why it has not held",
      "contact-expect-close": "Those answers determine whether the Executive Diagnostic is the right next step — and what it should focus on.",
      "contact-expect-m1": "We do not sell tools.",
      "contact-expect-m2": "We do not run generic demos.",
      "contact-expect-m3": "We identify what is actually broken.",
      "contact-cta-label": "Executive Advisory Desk",
      "contact-cta-title": "Speak With Your Private Executive Advisor",
      "contact-cta-intro": "Before booking your Executive Diagnostic, speak directly with our Executive Advisory Desk.",
      "contact-cta-body": "We help identify if the issue is lead generation, operations, scheduling, follow-up discipline, or hidden revenue leakage. Start the right conversation first.",
      "contact-cta-btn": "Start Advisory Conversation"
}
  };

  let currentLang = 'es';

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
      ? 'RACBCONSULTING — Diagnóstico Ejecutivo Operacional'
      : 'RACBCONSULTING — Executive Operational Consulting';
  }

  function toggleLang() {
    currentLang = currentLang === 'es' ? 'en' : 'es';
    window.currentLang = currentLang;
    applyLang(currentLang);
    document.getElementById('langFlag').textContent = currentLang === 'es' ? '🇪🇸' : '🇺🇸';
    document.getElementById('langLabel').textContent = currentLang === 'es' ? 'ES' : 'EN';
    try { localStorage.setItem('racb_lang', currentLang); } catch(e) {}
  }

  // ===== INIT =====
  initReveal();

  // ===== LANGUAGE INIT — localStorage → browser detection → fallback EN =====
  (function () {
    var saved;
    try { saved = localStorage.getItem('racb_lang'); } catch(e) {}
    var lang;
    if (saved === 'es' || saved === 'en') {
      lang = saved;
    } else {
      var nav = (navigator.languages && navigator.languages[0]) || navigator.language || '';
      lang = nav.toLowerCase().startsWith('es') ? 'es' : 'en';
    }
    currentLang = lang;
    window.currentLang = lang;
    applyLang(lang);
    var flagEl  = document.getElementById('langFlag');
    var labelEl = document.getElementById('langLabel');
    if (flagEl)  flagEl.textContent  = lang === 'es' ? '🇪🇸' : '🇺🇸';
    if (labelEl) labelEl.textContent = lang === 'es' ? 'ES'   : 'EN';
  }());

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
