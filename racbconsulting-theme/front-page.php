<?php
/**
 * Front Page Template
 * RACBCONSULTING Executive Consulting Funnel
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- HERO SECTION -->
    <section class="hero-section" aria-labelledby="hero-headline">
        <div class="container">

            <?php /* TODO: ACF — replace badge text with get_field('hero_offer_badge', 'option') — controls offer label per campaign */ ?>
            <p class="offer-badge" data-i18n="fp-hero-badge">Free Initial Executive Diagnostic — Limited Availability</p>

            <h1 id="hero-headline" data-i18n="fp-hero-title">
                Where Is Your Company Quietly Losing Money?
            </h1>

            <p class="hero-subheadline" data-i18n="fp-hero-sub">
                Most businesses do not have a lead problem.<br>
                They have an operational response problem.
            </p>

            <p class="hero-body" data-i18n="fp-hero-body">
                We identify missed revenue, scheduling failures, leadership bottlenecks,
                administrative overload, and execution gaps before they become expensive.
            </p>

            <div class="hero-actions">
                <?php /* TODO: ACF — replace CTA label with get_field('hero_primary_cta_label', 'option') */ ?>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
                    Book Executive Diagnostic
                </a>

                <?php /* TODO: ACF — replace secondary CTA label with get_field('hero_secondary_cta_label', 'option') */ ?>
                <a href="#how-it-works" class="btn-secondary" data-i18n="fp-hero-cta2">
                    See How It Works
                </a>
            </div>

        </div>
    </section>


    <!-- AUTHORITY POSITIONING SECTION -->
    <section class="authority-section" id="how-it-works" aria-labelledby="authority-headline">
        <div class="container">

            <?php /* TODO: ACF — replace eyebrow with get_field('authority_eyebrow', 'option') */ ?>
            <?php /* TODO: WPML — all copy in this section via WPML string translation or theme options per language */ ?>
            <p class="section-label" data-i18n="fp-authority-label">The Approach</p>

            <?php /* TODO: ACF — replace headline with get_field('authority_headline', 'option') */ ?>
            <h2 id="authority-headline" data-i18n="fp-authority-title">We Do Not Sell Automation</h2>

            <?php /* TODO: ACF — replace lead copy with get_field('authority_lead', 'option') */ ?>
            <p class="authority-lead" data-i18n="fp-authority-lead">
                Most companies ask for automation.
            </p>

            <p class="authority-support" data-i18n="fp-authority-support">
                The real problem is operational failure.<br>
                More software does not fix execution.<br>
                It makes it more expensive.
            </p>

            <!-- Diagnostic block -->
            <div class="authority-diagnostic">

                <p class="authority-diagnostic-intro" data-i18n="fp-authority-diag-intro1">Businesses rarely lose money because they lack tools.</p>
                <p class="authority-diagnostic-intro" data-i18n="fp-authority-diag-intro2">They lose money because:</p>

                <?php /* TODO: ACF — replace list items with repeater field get_field('authority_diagnostic_items', 'option') */ ?>
                <ul class="authority-list">
                    <li data-i18n="fp-authority-li1">leads are not answered fast enough</li>
                    <li data-i18n="fp-authority-li2">estimates arrive too late</li>
                    <li data-i18n="fp-authority-li3">scheduling breaks under pressure</li>
                    <li data-i18n="fp-authority-li4">follow-up discipline disappears</li>
                    <li data-i18n="fp-authority-li5">leadership gets trapped in operations</li>
                    <li data-i18n="fp-authority-li6">administrative overload kills execution</li>
                </ul>

                <p class="authority-diagnostic-close" data-i18n="fp-authority-diag-close">
                    The problem is rarely software.<br>
                    The problem is operational structure.
                </p>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace quote with get_field('authority_quote', 'option') */ ?>
            <blockquote class="authority-quote">
                <p data-i18n="fp-authority-quote">Automating a broken process does not create efficiency.<br>
                It accelerates the damage.</p>
                <footer data-i18n="fp-authority-quote-footer">
                    That is why we start with diagnosis first.<br>
                    Not implementation. Not automation. Diagnosis.
                </footer>
            </blockquote>

            <!-- Premium identification panel -->
            <div class="authority-panel">

                <?php /* TODO: ACF — replace panel intro with get_field('authority_panel_intro', 'option') */ ?>
                <p class="authority-panel-intro" data-i18n="fp-authority-panel-intro">Before adding systems, we identify:</p>

                <?php /* TODO: ACF — replace panel list with repeater field get_field('authority_panel_items', 'option') */ ?>
                <ul class="authority-panel-list">
                    <li data-i18n="fp-authority-panel-li1">where revenue is leaking</li>
                    <li data-i18n="fp-authority-panel-li2">where execution is failing</li>
                    <li data-i18n="fp-authority-panel-li3">what should be fixed first</li>
                    <li data-i18n="fp-authority-panel-li4">what should never be automated</li>
                </ul>

                <p class="authority-panel-close" data-i18n="fp-authority-panel-close">
                    Because automation without executive clarity is expensive.
                </p>

            </div>

            <!-- Closing authority manifesto -->
            <?php /* TODO: ACF — replace manifesto lines with repeater get_field('authority_manifesto', 'option') */ ?>
            <div class="authority-close" aria-label="Executive positioning statement">
                <p data-i18n="fp-authority-manifesto1">We do not sell automation.</p>
                <p data-i18n="fp-authority-manifesto2">We solve operational problems.</p>
                <p data-i18n="fp-authority-manifesto3">Automation is only the implementation layer.</p>
                <p data-i18n="fp-authority-manifesto4">The real product is executive judgment.</p>
            </div>

            <!-- Micro CTA -->
            <div class="authority-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('authority_cta_label', 'option') */ ?>
                <p class="authority-cta-label" data-i18n="fp-authority-cta-label">Start With Diagnosis</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
                    Book Executive Diagnostic
                </a>
            </div>

        </div>
    </section>


    <!-- WHO WE HELP SECTION -->
    <section class="vertical-section" id="who-we-help" aria-labelledby="vertical-headline">
        <div class="container">

            <?php /* TODO: WPML — all copy in this section via WPML string translation or theme options per language */ ?>

            <!-- Section header -->
            <header class="vertical-header">

                <?php /* TODO: ACF — replace eyebrow with get_field('vertical_eyebrow', 'option') */ ?>
                <p class="section-label" data-i18n="fp-verticals-label">Verticals We Serve</p>

                <?php /* TODO: ACF — replace headline with get_field('vertical_headline', 'option') */ ?>
                <h2 id="vertical-headline" data-i18n="fp-verticals-title">Who We Help</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('vertical_lead', 'option') */ ?>
                <p class="vertical-lead" data-i18n="fp-verticals-lead">
                    We work with companies where operational failure becomes expensive.<br>
                    Not hobby businesses. Not experiments.<br>
                    Real operations. Real pressure. Real money.
                </p>

            </header>

            <!-- 3-column vertical cards -->
            <div class="vertical-grid">

                <!-- Card 1: Contractors -->
                <?php /* TODO: ACF — replace card 1 content with get_field('vertical_card_1', 'option') */ ?>
                <article class="vertical-card">
                    <div class="vertical-card-header">
                        <h3 data-i18n="fp-v1-title">Contractors</h3>
                        <ul class="vertical-examples">
                            <li data-i18n="fp-v1-ex1">HVAC</li>
                            <li data-i18n="fp-v1-ex2">Plumbing</li>
                            <li data-i18n="fp-v1-ex3">Electrical</li>
                            <li data-i18n="fp-v1-ex4">Roofing</li>
                            <li data-i18n="fp-v1-ex5">General Contractors</li>
                            <li data-i18n="fp-v1-ex6">Field Service Businesses</li>
                        </ul>
                    </div>
                    <div class="vertical-card-body">
                        <p class="vertical-pain-label" data-i18n="fp-pain-label">Where money disappears:</p>
                        <ul class="vertical-pain-list">
                            <li data-i18n="fp-v1-pain1">Scheduling chaos</li>
                            <li data-i18n="fp-v1-pain2">Missed calls</li>
                            <li data-i18n="fp-v1-pain3">Slow estimates</li>
                            <li data-i18n="fp-v1-pain4">Dispatch pressure</li>
                            <li data-i18n="fp-v1-pain5">Administrative overload</li>
                            <li data-i18n="fp-v1-pain6">Revenue leakage between jobs</li>
                        </ul>
                    </div>
                </article>

                <!-- Card 2: Multifamily Operations -->
                <?php /* TODO: ACF — replace card 2 content with get_field('vertical_card_2', 'option') */ ?>
                <article class="vertical-card">
                    <div class="vertical-card-header">
                        <h3 data-i18n="fp-v2-title">Multifamily Operations</h3>
                        <ul class="vertical-examples">
                            <li data-i18n="fp-v2-ex1">Property Management</li>
                            <li data-i18n="fp-v2-ex2">Maintenance Operations</li>
                            <li data-i18n="fp-v2-ex3">Vendor Coordination</li>
                            <li data-i18n="fp-v2-ex4">Leasing Support</li>
                            <li data-i18n="fp-v2-ex5">Service Execution</li>
                            <li data-i18n="fp-v2-ex6">Resident Operations</li>
                        </ul>
                    </div>
                    <div class="vertical-card-body">
                        <p class="vertical-pain-label" data-i18n="fp-pain-label">Where money disappears:</p>
                        <ul class="vertical-pain-list">
                            <li data-i18n="fp-v2-pain1">Work order bottlenecks</li>
                            <li data-i18n="fp-v2-pain2">Vendor friction</li>
                            <li data-i18n="fp-v2-pain3">Delayed execution</li>
                            <li data-i18n="fp-v2-pain4">Communication failures</li>
                            <li data-i18n="fp-v2-pain5">Operational blind spots</li>
                            <li data-i18n="fp-v2-pain6">Leadership overload</li>
                        </ul>
                    </div>
                </article>

                <!-- Card 3: Service Businesses -->
                <?php /* TODO: ACF — replace card 3 content with get_field('vertical_card_3', 'option') */ ?>
                <article class="vertical-card">
                    <div class="vertical-card-header">
                        <h3 data-i18n="fp-v3-title">Service Businesses</h3>
                        <ul class="vertical-examples">
                            <li data-i18n="fp-v3-ex1">Professional Services</li>
                            <li data-i18n="fp-v3-ex2">Medical</li>
                            <li data-i18n="fp-v3-ex3">Legal</li>
                            <li data-i18n="fp-v3-ex4">Home Services</li>
                            <li data-i18n="fp-v3-ex5">Executive Operations</li>
                            <li data-i18n="fp-v3-ex6">Growing Service Teams</li>
                        </ul>
                    </div>
                    <div class="vertical-card-body">
                        <p class="vertical-pain-label" data-i18n="fp-pain-label">Where money disappears:</p>
                        <ul class="vertical-pain-list">
                            <li data-i18n="fp-v3-pain1">Follow-up failure</li>
                            <li data-i18n="fp-v3-pain2">Administrative drag</li>
                            <li data-i18n="fp-v3-pain3">Poor lead conversion</li>
                            <li data-i18n="fp-v3-pain4">Broken handoffs</li>
                            <li data-i18n="fp-v3-pain5">Execution inconsistency</li>
                            <li data-i18n="fp-v3-pain6">Growth without operational structure</li>
                        </ul>
                    </div>
                </article>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement lines with get_field('vertical_statement', 'option') */ ?>
            <div class="vertical-statement">
                <p data-i18n="fp-verticals-statement1">If your business depends on speed, coordination, execution, and operational discipline&mdash;</p>
                <p class="vertical-statement-emphasis" data-i18n="fp-verticals-statement2">this is where money disappears first.</p>
            </div>

            <!-- Exclusion block -->
            <?php /* TODO: ACF — replace exclusion copy with get_field('vertical_exclusion', 'option') */ ?>
            <div class="vertical-exclusion">
                <p data-i18n="fp-verticals-exclusion1">We are not built for businesses looking for cheap automation.</p>
                <p data-i18n="fp-verticals-exclusion2">We are built for operators who understand that execution failures cost real money.</p>
            </div>

            <!-- Micro CTA -->
            <div class="vertical-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('vertical_cta_label', 'option') */ ?>
                <p class="vertical-cta-label" data-i18n="fp-verticals-cta-label">If operations break, revenue follows.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
                    Book Executive Diagnostic
                </a>
            </div>

        </div>
    </section>


    <!-- WHAT WE DIAGNOSE SECTION -->
    <section class="diagnose-section" id="what-we-diagnose" aria-labelledby="diagnose-headline">
        <div class="container">

            <?php /* TODO: WPML — all copy in this section via WPML string translation or theme options per language */ ?>

            <!-- Section header -->
            <header class="diagnose-header">

                <?php /* TODO: ACF — replace eyebrow with get_field('diagnose_eyebrow', 'option') */ ?>
                <p class="section-label" data-i18n="fp-diagnose-label">Executive Diagnostic</p>

                <?php /* TODO: ACF — replace headline with get_field('diagnose_headline', 'option') */ ?>
                <h2 id="diagnose-headline" data-i18n="fp-diagnose-title">What We Diagnose</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('diagnose_lead', 'option') */ ?>
                <p class="diagnose-lead" data-i18n="fp-diagnose-lead">
                    Most companies do not notice where money is disappearing.<br>
                    They only notice when growth slows, margins tighten, and leadership gets pulled into operational chaos.<br>
                    We identify the hidden failures before they become expensive.
                </p>

            </header>

            <!-- 7 diagnostic items — editorial report rows -->
            <?php /* TODO: ACF — replace all items with repeater get_field('diagnose_items', 'option') */ ?>
            <div class="diagnose-list" role="list">

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">01</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d1-title">Lost Leads</h3>
                        <p class="diagnose-situation" data-i18n="fp-d1-situation">Leads arrive. Nobody responds fast enough.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d1-consequence">The opportunity disappears before the conversation starts.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">02</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d2-title">Scheduling Chaos</h3>
                        <p class="diagnose-situation" data-i18n="fp-d2-situation">Jobs stack. Dispatch breaks. Priority decisions become daily emergencies.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d2-consequence">Operations become reactive instead of controlled.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">03</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d3-title">Delayed Estimates</h3>
                        <p class="diagnose-situation" data-i18n="fp-d3-situation">Quotes arrive too late. The client already moved forward with someone else.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d3-consequence">Revenue is lost silently.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">04</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d4-title">Administrative Overload</h3>
                        <p class="diagnose-situation" data-i18n="fp-d4-situation">Leaders get trapped inside admin work.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d4-consequence">Execution slows because decisions are buried under operations.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">05</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d5-title">Follow-Up Failure</h3>
                        <p class="diagnose-situation" data-i18n="fp-d5-situation">Nobody follows up consistently.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d5-consequence">Opportunities die without anyone noticing.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">06</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d6-title">Leadership Bottlenecks</h3>
                        <p class="diagnose-situation" data-i18n="fp-d6-situation">Everything depends on one person.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d6-consequence">Growth becomes impossible because execution cannot scale.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">07</span>
                    <div class="diagnose-content">
                        <h3 data-i18n="fp-d7-title">Hidden Revenue Leakage</h3>
                        <p class="diagnose-situation" data-i18n="fp-d7-situation">Small operational failures compound.</p>
                        <p class="diagnose-consequence" data-i18n="fp-d7-consequence">No single disaster. Just constant invisible financial damage.</p>
                    </div>
                </div>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement with get_field('diagnose_statement', 'option') */ ?>
            <div class="diagnose-statement">
                <p data-i18n="fp-diagnose-statement1">Most businesses do not have a sales problem.</p>
                <p class="diagnose-statement-emphasis" data-i18n="fp-diagnose-statement2">They have an execution visibility problem.</p>
            </div>

            <!-- Executive Diagnostic purpose — centered large type -->
            <?php /* TODO: ACF — replace purpose block with get_field('diagnose_purpose', 'option') */ ?>
            <div class="diagnose-purpose">
                <p class="diagnose-purpose-setup" data-i18n="fp-diagnose-purpose1">We do not guess.</p>
                <p class="diagnose-purpose-anchor" data-i18n="fp-diagnose-purpose2">We diagnose.</p>
                <p class="diagnose-purpose-detail" data-i18n="fp-diagnose-purpose3">
                    We identify where money is leaking, what must be fixed first,
                    and what should never be automated.
                </p>
            </div>

            <!-- Micro CTA -->
            <div class="diagnose-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('diagnose_cta_label', 'option') */ ?>
                <p class="diagnose-cta-label" data-i18n="fp-diagnose-cta-label">Clarity before automation.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
                    Book Executive Diagnostic
                </a>
            </div>

        </div>
    </section>


    <!-- THE EXECUTIVE DIAGNOSTIC SECTION -->
    <section class="exd-section" id="executive-diagnostic" aria-labelledby="exd-headline">
        <div class="container">

            <?php /* TODO: WPML — all copy in this section via WPML string translation or theme options per language */ ?>

            <!-- Section header -->
            <header class="exd-header">

                <?php /* TODO: ACF — replace eyebrow with get_field('exd_eyebrow', 'option') */ ?>
                <p class="section-label" data-i18n="fp-exd-label">The Process</p>

                <?php /* TODO: ACF — replace headline with get_field('exd_headline', 'option') */ ?>
                <h2 id="exd-headline" data-i18n="fp-exd-title">The Executive Diagnostic</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('exd_lead', 'option') */ ?>
                <p class="exd-lead" data-i18n="fp-exd-lead">
                    This is not a sales call.<br>
                    This is an executive operational review focused on identifying where your company
                    loses money, where execution is breaking, and what should happen next.
                </p>

            </header>

            <!-- 4-step process — 2×2 grid -->
            <?php /* TODO: ACF — replace all step content with repeater get_field('exd_steps', 'option') */ ?>
            <div class="exd-grid">

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">01</span>
                    <p class="exd-card-step" data-i18n="fp-exd-s1-step">Step 1</p>
                    <h3 class="exd-card-title" data-i18n="fp-exd-s1-title">Executive Intake</h3>
                    <div class="exd-card-body">
                        <p data-i18n="fp-exd-s1-body1">We review your operation, current systems, decision flow, scheduling pressure,
                        response discipline, leadership bottlenecks, and revenue leakage indicators.</p>
                        <p data-i18n="fp-exd-s1-body2">We identify how the business actually operates — not how it looks on paper.</p>
                    </div>
                </article>

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">02</span>
                    <p class="exd-card-step" data-i18n="fp-exd-s2-step">Step 2</p>
                    <h3 class="exd-card-title" data-i18n="fp-exd-s2-title">Operational Diagnosis</h3>
                    <div class="exd-card-body">
                        <p data-i18n="fp-exd-s2-body1">We map where execution breaks.</p>
                        <ul class="exd-areas">
                            <li data-i18n="fp-exd-s2-li1">Lead response</li>
                            <li data-i18n="fp-exd-s2-li2">Scheduling</li>
                            <li data-i18n="fp-exd-s2-li3">Estimates</li>
                            <li data-i18n="fp-exd-s2-li4">Follow-up</li>
                            <li data-i18n="fp-exd-s2-li5">Admin overload</li>
                            <li data-i18n="fp-exd-s2-li6">Leadership dependency</li>
                        </ul>
                        <p data-i18n="fp-exd-s2-body2">We isolate where money is leaking.</p>
                    </div>
                </article>

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">03</span>
                    <p class="exd-card-step" data-i18n="fp-exd-s3-step">Step 3</p>
                    <h3 class="exd-card-title" data-i18n="fp-exd-s3-title">Strategic Review</h3>
                    <div class="exd-card-body">
                        <p data-i18n="fp-exd-s3-body1">We define what should be fixed first.</p>
                        <ul class="exd-areas">
                            <li data-i18n="fp-exd-s3-li1">What should be automated</li>
                            <li data-i18n="fp-exd-s3-li2">What should never be automated</li>
                            <li data-i18n="fp-exd-s3-li3">What creates the fastest operational impact</li>
                        </ul>
                    </div>
                </article>

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">04</span>
                    <p class="exd-card-step" data-i18n="fp-exd-s4-step">Step 4</p>
                    <h3 class="exd-card-title" data-i18n="fp-exd-s4-title">Executive Recommendation</h3>
                    <div class="exd-card-body">
                        <p data-i18n="fp-exd-s4-body1">You receive strategic clarity.</p>
                        <p data-i18n="fp-exd-s4-body2">Not generic advice.</p>
                        <p data-i18n="fp-exd-s4-body3">A real executive path forward.</p>
                        <p data-i18n="fp-exd-s4-body4">Whether implementation happens with us or not.</p>
                    </div>
                </article>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement lines with get_field('exd_statement', 'option') */ ?>
            <div class="exd-statement">
                <p data-i18n="fp-exd-statement1">Most companies try to buy tools before understanding the problem.</p>
                <p data-i18n="fp-exd-statement2">That is backwards.</p>
                <p class="exd-statement-anchor" data-i18n="fp-exd-statement3">We fix that first.</p>
            </div>

            <!-- Trust statement -->
            <?php /* TODO: ACF — replace trust block with get_field('exd_trust', 'option') */ ?>
            <div class="exd-trust">
                <p class="exd-trust-body" data-i18n="fp-exd-trust1">
                    This is why qualified companies are currently receiving the
                    Initial Executive Diagnostic at no cost.
                </p>
                <p class="exd-trust-reason" data-i18n="fp-exd-trust2">Because clarity creates better decisions.</p>
            </div>

            <!-- Micro CTA -->
            <div class="exd-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('exd_cta_label', 'option') */ ?>
                <p class="exd-cta-label" data-i18n="fp-exd-cta-label">Limited availability for qualified companies.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
                    Book Executive Diagnostic
                </a>
            </div>

        </div>
    </section>


    <!-- PROOF / CASE STUDIES SECTION -->
    <section class="proof-section" id="case-studies" aria-labelledby="proof-headline">
        <div class="container">

            <?php /* TODO: WPML — all copy in this section via WPML string translation or theme options per language */ ?>

            <!-- Section header -->
            <header class="proof-header">

                <?php /* TODO: ACF — replace eyebrow with get_field('proof_eyebrow', 'option') */ ?>
                <p class="section-label" data-i18n="fp-proof-label">Executive Proof</p>

                <?php /* TODO: ACF — replace headline with get_field('proof_headline', 'option') */ ?>
                <h2 id="proof-headline" data-i18n="fp-proof-title">Where Operations Improve, Revenue Follows</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('proof_lead', 'option') */ ?>
                <p class="proof-lead" data-i18n="fp-proof-lead">
                    Results are not measured by how good automation looks.<br>
                    They are measured by response speed, execution quality, operational clarity, and recoverable revenue.<br>
                    That is where real proof exists.
                </p>

            </header>

            <!-- 3 case study cards -->
            <?php /* TODO: ACF — replace all case study content with repeater get_field('proof_cases', 'option') */ ?>
            <div class="proof-grid">

                <!-- Case Study 1 -->
                <article class="proof-card">
                    <p class="proof-card-vertical" data-i18n="fp-pc1-vertical">Contractor Operations</p>
                    <div class="proof-card-problem">
                        <p class="proof-zone-label" data-i18n="fp-proof-z-problem">Problem</p>
                        <ul class="proof-problem-list">
                            <li data-i18n="fp-pc1-p1">Missed calls</li>
                            <li data-i18n="fp-pc1-p2">Scheduling gaps</li>
                            <li data-i18n="fp-pc1-p3">Delayed estimates</li>
                            <li data-i18n="fp-pc1-p4">Revenue leakage between jobs</li>
                        </ul>
                    </div>
                    <div class="proof-card-divider" aria-hidden="true"></div>
                    <div class="proof-card-result">
                        <p class="proof-zone-label proof-zone-result" data-i18n="fp-proof-z-result">Result</p>
                        <ul class="proof-result-list">
                            <li data-i18n="fp-pc1-r1">Faster response</li>
                            <li data-i18n="fp-pc1-r2">Cleaner dispatch</li>
                            <li data-i18n="fp-pc1-r3">Higher booking consistency</li>
                            <li data-i18n="fp-pc1-r4">Operational visibility</li>
                        </ul>
                    </div>
                </article>

                <!-- Case Study 2 -->
                <article class="proof-card">
                    <p class="proof-card-vertical" data-i18n="fp-pc2-vertical">Multifamily Operations</p>
                    <div class="proof-card-problem">
                        <p class="proof-zone-label" data-i18n="fp-proof-z-problem">Problem</p>
                        <ul class="proof-problem-list">
                            <li data-i18n="fp-pc2-p1">Maintenance pressure</li>
                            <li data-i18n="fp-pc2-p2">Vendor coordination failures</li>
                            <li data-i18n="fp-pc2-p3">Delayed execution</li>
                            <li data-i18n="fp-pc2-p4">Administrative overload</li>
                        </ul>
                    </div>
                    <div class="proof-card-divider" aria-hidden="true"></div>
                    <div class="proof-card-result">
                        <p class="proof-zone-label proof-zone-result" data-i18n="fp-proof-z-result">Result</p>
                        <ul class="proof-result-list">
                            <li data-i18n="fp-pc2-r1">Cleaner workflows</li>
                            <li data-i18n="fp-pc2-r2">Reduced friction</li>
                            <li data-i18n="fp-pc2-r3">Execution control</li>
                            <li data-i18n="fp-pc2-r4">Leadership visibility</li>
                        </ul>
                    </div>
                </article>

                <!-- Case Study 3 -->
                <article class="proof-card">
                    <p class="proof-card-vertical" data-i18n="fp-pc3-vertical">Service Business Operations</p>
                    <div class="proof-card-problem">
                        <p class="proof-zone-label" data-i18n="fp-proof-z-problem">Problem</p>
                        <ul class="proof-problem-list">
                            <li data-i18n="fp-pc3-p1">Broken follow-up</li>
                            <li data-i18n="fp-pc3-p2">Administrative drag</li>
                            <li data-i18n="fp-pc3-p3">Poor lead conversion</li>
                            <li data-i18n="fp-pc3-p4">Growth without operational structure</li>
                        </ul>
                    </div>
                    <div class="proof-card-divider" aria-hidden="true"></div>
                    <div class="proof-card-result">
                        <p class="proof-zone-label proof-zone-result" data-i18n="fp-proof-z-result">Result</p>
                        <ul class="proof-result-list">
                            <li data-i18n="fp-pc3-r1">Operational discipline</li>
                            <li data-i18n="fp-pc3-r2">Faster decision flow</li>
                            <li data-i18n="fp-pc3-r3">Better conversion</li>
                            <li data-i18n="fp-pc3-r4">Scalable execution</li>
                        </ul>
                    </div>
                </article>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement with get_field('proof_statement', 'option') */ ?>
            <div class="proof-statement">
                <p data-i18n="fp-proof-statement1">Good operations create measurable outcomes.</p>
                <p data-i18n="fp-proof-statement2">Good marketing only creates temporary attention.</p>
                <p class="proof-statement-anchor" data-i18n="fp-proof-statement3">We optimize the first.</p>
            </div>

            <!-- Authority block -->
            <?php /* TODO: ACF — replace authority block with get_field('proof_authority', 'option') */ ?>
            <div class="proof-authority">
                <p data-i18n="fp-proof-authority1">Our work is not judged by how impressive the automation looks.</p>
                <p class="proof-authority-anchor" data-i18n="fp-proof-authority2">It is judged by what stops breaking.</p>
            </div>

            <!-- Micro CTA -->
            <div class="proof-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('proof_cta_label', 'option') */ ?>
                <p class="proof-cta-label" data-i18n="fp-proof-cta-label">If operations improve, revenue follows.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
                    Book Executive Diagnostic
                </a>
            </div>

        </div>
    </section>


    <!-- PRIVATE EXECUTIVE ADVISOR BLOCK -->
    <section class="advisor-block" id="advisor" aria-labelledby="advisor-headline">
        <div class="container">

            <?php /* TODO: ACF — entire advisor block content via get_field('advisor_block', 'option') for bilingual copy control */ ?>
            <?php /* TODO: WPML — all copy below should be translated via WPML string translation or theme options per language */ ?>

            <div class="advisor-card">

                <?php /* TODO: ACF — replace eyebrow with get_field('advisor_eyebrow', 'option') */ ?>
                <p class="section-label" data-i18n="fp-advisor-label">Executive Advisory Desk</p>

                <h2 id="advisor-headline" data-i18n="fp-advisor-title">Speak With Your Private Executive Advisor</h2>

                <p class="advisor-intro" data-i18n="fp-advisor-intro">
                    Before booking your Executive Diagnostic, speak directly with our Executive Advisory Desk.
                </p>

                <p class="advisor-body" data-i18n="fp-advisor-body">
                    We help identify if the issue is lead generation, operations, scheduling,
                    follow-up discipline, or hidden revenue leakage.
                    Start the right conversation first.
                </p>

                <?php /* TODO: ACF — replace CTA label with get_field('advisor_cta_label', 'option') and URL with get_field('advisor_cta_url', 'option') */ ?>
                <?php /* TODO: Replace openAdvisorModal() with the real Private Executive Advisor widget trigger when implemented. */ ?>
                <a href="#advisor" class="btn-secondary" onclick="openAdvisorModal(); return false;" data-i18n="fp-advisor-cta">
                    Start Advisory Conversation
                </a>

            </div>

        </div>
    </section>

</main>

<!-- ADVISOR MODAL -->
<?php /* TODO: Replace this temporary chat UI with the real Private Executive Advisor widget when implemented. */ ?>
<div id="advisor-modal" class="advisor-modal" role="dialog" aria-modal="true" aria-labelledby="advisor-modal-title" aria-hidden="true">
  <div class="advisor-modal-box">

    <div class="advisor-chat-header">
      <div class="advisor-chat-header-info">
        <p class="advisor-modal-label" data-i18n="fp-advisor-modal-label">Private Executive Advisor</p>
        <h3 id="advisor-modal-title" class="advisor-modal-title" data-i18n="fp-advisor-modal-title">Executive Advisor</h3>
      </div>
      <button class="advisor-modal-close" onclick="closeAdvisorModal()" aria-label="Close">&#x2715;</button>
    </div>

    <div id="advisor-chat-history" class="advisor-chat-history">

      <div class="advisor-msg advisor-msg--assistant">
        <p data-i18n="fp-advisor-welcome">Walk me through what's happening. Start with wherever the pressure is highest.</p>
      </div>

    </div>

    <div class="advisor-chat-input-area">
      <textarea
        id="advisor-chat-input"
        class="advisor-chat-input"
        data-i18n="fp-advisor-input-placeholder"
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
