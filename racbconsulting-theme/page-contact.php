<?php
/**
 * RACBCONSULTING — page-contact.php
 * Auto-assigned by WordPress to any page with slug: contact
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- HERO -->
    <section class="hero-section" aria-labelledby="contact-hero-headline">
        <div class="container">

            <p class="offer-badge">Executive Advisory Desk — Limited Availability</p>

            <h1 id="contact-hero-headline">
                Start the Right Conversation First
            </h1>

            <p class="hero-subheadline">
                Before booking your Executive Diagnostic, speak directly with our
                Executive Advisory Desk.
            </p>

            <p class="hero-body">
                We help identify whether the issue is lead generation, operations, scheduling,
                follow-up discipline, or hidden revenue leakage —
                so the diagnostic conversation is focused from the start.
            </p>

            <div class="hero-actions">
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
                    Book Executive Diagnostic
                </a>
                <a href="#advisory" class="btn-secondary">
                    Speak With an Advisor
                </a>
            </div>

        </div>
    </section>


    <!-- THREE CONTACT OPTIONS -->
    <section class="authority-section" id="advisory" aria-labelledby="contact-options-headline">
        <div class="container">

            <p class="section-label">How to Reach Us</p>

            <h2 id="contact-options-headline">Three Ways to Start</h2>

            <p class="authority-lead">
                Choose the channel that matches where you are in the decision.
            </p>

            <div class="contact-option-grid">

                <!-- Option 1: Advisor Chat -->
                <div class="contact-option-card">
                    <p class="section-label">Executive Advisory Desk</p>
                    <h3>Speak With an Advisor</h3>
                    <p>
                        Not sure where to start? Our Executive Advisor helps you identify
                        whether the problem is lead response, scheduling, follow-up, or hidden
                        operational failure — before you book anything.
                    </p>
                    <a
                        href="#advisor"
                        class="btn-secondary"
                        onclick="openAdvisorModal(); return false;"
                    >
                        Start Advisory Conversation
                    </a>
                </div>

                <!-- Option 2: Book Diagnostic — featured -->
                <div class="contact-option-card contact-option-card--featured">
                    <p class="section-label">Fastest Path</p>
                    <h3>Book Executive Diagnostic</h3>
                    <p>
                        Ready to diagnose? Qualified companies are currently receiving the Initial
                        Executive Diagnostic at no cost. This is a structured operational review —
                        not a sales call.
                    </p>
                    <a
                        href="https://mvp.racbconsulting.com"
                        class="btn-primary"
                        target="_blank"
                        rel="noopener"
                    >
                        Book Executive Diagnostic
                    </a>
                </div>

                <!-- Option 3: Direct Email -->
                <div class="contact-option-card">
                    <p class="section-label">Direct Line</p>
                    <h3>Email the Executive Team</h3>
                    <p>
                        For specific inquiries, partnership discussions, or anything that does not
                        fit a diagnostic conversation, reach the executive team directly.
                    </p>
                    <a
                        href="mailto:ceo@racbconsulting.com"
                        class="btn-secondary"
                    >
                        ceo@racbconsulting.com
                    </a>
                </div>

            </div>

        </div>
    </section>


    <!-- WHAT TO EXPECT -->
    <section class="authority-section" aria-labelledby="expect-headline">
        <div class="container">

            <p class="section-label">What to Expect</p>

            <h2 id="expect-headline">This Is Not a Sales Process</h2>

            <p class="authority-lead">
                Every conversation at RACBCONSULTING starts with listening — not pitching.
            </p>

            <div class="authority-diagnostic">

                <p class="authority-diagnostic-intro">When you reach out, we will ask about:</p>

                <ul class="authority-list">
                    <li>how leads currently enter and how fast they are answered</li>
                    <li>where scheduling or dispatch breaks under pressure</li>
                    <li>how follow-up is handled and whether it is consistent</li>
                    <li>where leadership time is being consumed by operational noise</li>
                    <li>what has already been tried and why it has not held</li>
                </ul>

                <p class="authority-diagnostic-close">
                    Those answers determine whether the Executive Diagnostic is the right next step —
                    and what it should focus on.
                </p>

            </div>

            <div class="authority-close" aria-label="Contact positioning statement">
                <p>We do not sell tools.</p>
                <p>We do not run generic demos.</p>
                <p>We identify what is actually broken.</p>
            </div>

        </div>
    </section>


    <!-- ADVISOR MODAL TRIGGER (reuses front-page modal) -->
    <section class="advisor-block" aria-labelledby="contact-cta-headline">
        <div class="container">
            <div class="advisor-card">

                <p class="section-label">Executive Advisory Desk</p>

                <h2 id="contact-cta-headline">Speak With Your Private Executive Advisor</h2>

                <p class="advisor-intro">
                    Before booking your Executive Diagnostic, speak directly with our Executive Advisory Desk.
                </p>

                <p class="advisor-body">
                    We help identify if the issue is lead generation, operations, scheduling,
                    follow-up discipline, or hidden revenue leakage.
                    Start the right conversation first.
                </p>

                <a
                    href="#advisor"
                    class="btn-secondary"
                    onclick="openAdvisorModal(); return false;"
                >
                    Start Advisory Conversation
                </a>

            </div>
        </div>
    </section>

</main>

<!-- ADVISOR MODAL (mirrors front-page.php modal so openAdvisorModal() works) -->
<div id="advisor-modal" class="advisor-modal" role="dialog" aria-modal="true" aria-labelledby="advisor-modal-title" aria-hidden="true">
  <div class="advisor-modal-box">

    <div class="advisor-chat-header">
      <div class="advisor-chat-header-info">
        <p class="advisor-modal-label">Private Executive Advisor</p>
        <h3 id="advisor-modal-title" class="advisor-modal-title">Executive Advisor</h3>
      </div>
      <button class="advisor-modal-close" onclick="closeAdvisorModal()" aria-label="Close">&#x2715;</button>
    </div>

    <div id="advisor-chat-history" class="advisor-chat-history">

      <div class="advisor-msg advisor-msg--assistant">
        <p>Welcome. I'm your RACBCONSULTING Executive Advisor. Tell me what is happening inside your operation, and I'll help identify the right next step.</p>
      </div>

      <div id="advisor-quick-prompts" class="advisor-quick-prompts">
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">We are losing leads</button>
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">Scheduling is chaotic</button>
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">Follow-up is inconsistent</button>
        <button class="advisor-quick-prompt" onclick="sendAdvisorPrompt(this)">Operations feel overloaded</button>
      </div>

    </div>

    <div class="advisor-chat-input-area">
      <textarea
        id="advisor-chat-input"
        class="advisor-chat-input"
        placeholder="Describe what is happening inside your operation..."
        rows="2"
        onkeydown="handleAdvisorKey(event)"
      ></textarea>
      <button class="advisor-chat-send" onclick="sendAdvisorMessage()" aria-label="Send">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
      </button>
    </div>

  </div>
</div>

<?php get_footer(); ?>
