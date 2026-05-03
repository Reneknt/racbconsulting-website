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
            <p class="offer-badge">Free Initial Executive Diagnostic — Limited Availability</p>

            <h1 id="hero-headline">
                Where Is Your Company Quietly Losing Money?
            </h1>

            <p class="hero-subheadline">
                Most businesses do not have a lead problem.<br>
                They have an operational response problem.
            </p>

            <p class="hero-body">
                We identify missed revenue, scheduling failures, leadership bottlenecks,
                administrative overload, and execution gaps before they become expensive.
            </p>

            <div class="hero-actions">
                <?php /* TODO: ACF — replace CTA label with get_field('hero_primary_cta_label', 'option') */ ?>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
                    Book Executive Diagnostic
                </a>

                <?php /* TODO: ACF — replace secondary CTA label with get_field('hero_secondary_cta_label', 'option') */ ?>
                <a href="#how-it-works" class="btn-secondary">
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
            <p class="section-label">The Approach</p>

            <?php /* TODO: ACF — replace headline with get_field('authority_headline', 'option') */ ?>
            <h2 id="authority-headline">We Do Not Sell Automation</h2>

            <?php /* TODO: ACF — replace lead copy with get_field('authority_lead', 'option') */ ?>
            <p class="authority-lead">
                Most companies ask for automation.
            </p>

            <p class="authority-support">
                The real problem is operational failure.<br>
                More software does not fix execution.<br>
                It makes it more expensive.
            </p>

            <!-- Diagnostic block -->
            <div class="authority-diagnostic">

                <p class="authority-diagnostic-intro">Businesses rarely lose money because they lack tools.</p>
                <p class="authority-diagnostic-intro">They lose money because:</p>

                <?php /* TODO: ACF — replace list items with repeater field get_field('authority_diagnostic_items', 'option') */ ?>
                <ul class="authority-list">
                    <li>leads are not answered fast enough</li>
                    <li>estimates arrive too late</li>
                    <li>scheduling breaks under pressure</li>
                    <li>follow-up discipline disappears</li>
                    <li>leadership gets trapped in operations</li>
                    <li>administrative overload kills execution</li>
                </ul>

                <p class="authority-diagnostic-close">
                    The problem is rarely software.<br>
                    The problem is operational structure.
                </p>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace quote with get_field('authority_quote', 'option') */ ?>
            <blockquote class="authority-quote">
                <p>Automating a broken process does not create efficiency.<br>
                It accelerates the damage.</p>
                <footer>
                    That is why we start with diagnosis first.<br>
                    Not implementation. Not automation. Diagnosis.
                </footer>
            </blockquote>

            <!-- Premium identification panel -->
            <div class="authority-panel">

                <?php /* TODO: ACF — replace panel intro with get_field('authority_panel_intro', 'option') */ ?>
                <p class="authority-panel-intro">Before adding systems, we identify:</p>

                <?php /* TODO: ACF — replace panel list with repeater field get_field('authority_panel_items', 'option') */ ?>
                <ul class="authority-panel-list">
                    <li>where revenue is leaking</li>
                    <li>where execution is failing</li>
                    <li>what should be fixed first</li>
                    <li>what should never be automated</li>
                </ul>

                <p class="authority-panel-close">
                    Because automation without executive clarity is expensive.
                </p>

            </div>

            <!-- Closing authority manifesto -->
            <?php /* TODO: ACF — replace manifesto lines with repeater get_field('authority_manifesto', 'option') */ ?>
            <div class="authority-close" aria-label="Executive positioning statement">
                <p>We do not sell automation.</p>
                <p>We solve operational problems.</p>
                <p>Automation is only the implementation layer.</p>
                <p>The real product is executive judgment.</p>
            </div>

            <!-- Micro CTA -->
            <div class="authority-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('authority_cta_label', 'option') */ ?>
                <p class="authority-cta-label">Start With Diagnosis</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
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
                <p class="section-label">Verticals We Serve</p>

                <?php /* TODO: ACF — replace headline with get_field('vertical_headline', 'option') */ ?>
                <h2 id="vertical-headline">Who We Help</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('vertical_lead', 'option') */ ?>
                <p class="vertical-lead">
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
                        <h3>Contractors</h3>
                        <ul class="vertical-examples">
                            <li>HVAC</li>
                            <li>Plumbing</li>
                            <li>Electrical</li>
                            <li>Roofing</li>
                            <li>General Contractors</li>
                            <li>Field Service Businesses</li>
                        </ul>
                    </div>
                    <div class="vertical-card-body">
                        <p class="vertical-pain-label">Where money disappears:</p>
                        <ul class="vertical-pain-list">
                            <li>Scheduling chaos</li>
                            <li>Missed calls</li>
                            <li>Slow estimates</li>
                            <li>Dispatch pressure</li>
                            <li>Administrative overload</li>
                            <li>Revenue leakage between jobs</li>
                        </ul>
                    </div>
                </article>

                <!-- Card 2: Multifamily Operations -->
                <?php /* TODO: ACF — replace card 2 content with get_field('vertical_card_2', 'option') */ ?>
                <article class="vertical-card">
                    <div class="vertical-card-header">
                        <h3>Multifamily Operations</h3>
                        <ul class="vertical-examples">
                            <li>Property Management</li>
                            <li>Maintenance Operations</li>
                            <li>Vendor Coordination</li>
                            <li>Leasing Support</li>
                            <li>Service Execution</li>
                            <li>Resident Operations</li>
                        </ul>
                    </div>
                    <div class="vertical-card-body">
                        <p class="vertical-pain-label">Where money disappears:</p>
                        <ul class="vertical-pain-list">
                            <li>Work order bottlenecks</li>
                            <li>Vendor friction</li>
                            <li>Delayed execution</li>
                            <li>Communication failures</li>
                            <li>Operational blind spots</li>
                            <li>Leadership overload</li>
                        </ul>
                    </div>
                </article>

                <!-- Card 3: Service Businesses -->
                <?php /* TODO: ACF — replace card 3 content with get_field('vertical_card_3', 'option') */ ?>
                <article class="vertical-card">
                    <div class="vertical-card-header">
                        <h3>Service Businesses</h3>
                        <ul class="vertical-examples">
                            <li>Professional Services</li>
                            <li>Medical</li>
                            <li>Legal</li>
                            <li>Home Services</li>
                            <li>Executive Operations</li>
                            <li>Growing Service Teams</li>
                        </ul>
                    </div>
                    <div class="vertical-card-body">
                        <p class="vertical-pain-label">Where money disappears:</p>
                        <ul class="vertical-pain-list">
                            <li>Follow-up failure</li>
                            <li>Administrative drag</li>
                            <li>Poor lead conversion</li>
                            <li>Broken handoffs</li>
                            <li>Execution inconsistency</li>
                            <li>Growth without operational structure</li>
                        </ul>
                    </div>
                </article>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement lines with get_field('vertical_statement', 'option') */ ?>
            <div class="vertical-statement">
                <p>If your business depends on speed, coordination, execution, and operational discipline&mdash;</p>
                <p class="vertical-statement-emphasis">this is where money disappears first.</p>
            </div>

            <!-- Exclusion block -->
            <?php /* TODO: ACF — replace exclusion copy with get_field('vertical_exclusion', 'option') */ ?>
            <div class="vertical-exclusion">
                <p>We are not built for businesses looking for cheap automation.</p>
                <p>We are built for operators who understand that execution failures cost real money.</p>
            </div>

            <!-- Micro CTA -->
            <div class="vertical-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('vertical_cta_label', 'option') */ ?>
                <p class="vertical-cta-label">If operations break, revenue follows.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
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
                <p class="section-label">Executive Diagnostic</p>

                <?php /* TODO: ACF — replace headline with get_field('diagnose_headline', 'option') */ ?>
                <h2 id="diagnose-headline">What We Diagnose</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('diagnose_lead', 'option') */ ?>
                <p class="diagnose-lead">
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
                        <h3>Lost Leads</h3>
                        <p class="diagnose-situation">Leads arrive. Nobody responds fast enough.</p>
                        <p class="diagnose-consequence">The opportunity disappears before the conversation starts.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">02</span>
                    <div class="diagnose-content">
                        <h3>Scheduling Chaos</h3>
                        <p class="diagnose-situation">Jobs stack. Dispatch breaks. Priority decisions become daily emergencies.</p>
                        <p class="diagnose-consequence">Operations become reactive instead of controlled.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">03</span>
                    <div class="diagnose-content">
                        <h3>Delayed Estimates</h3>
                        <p class="diagnose-situation">Quotes arrive too late. The client already moved forward with someone else.</p>
                        <p class="diagnose-consequence">Revenue is lost silently.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">04</span>
                    <div class="diagnose-content">
                        <h3>Administrative Overload</h3>
                        <p class="diagnose-situation">Leaders get trapped inside admin work.</p>
                        <p class="diagnose-consequence">Execution slows because decisions are buried under operations.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">05</span>
                    <div class="diagnose-content">
                        <h3>Follow-Up Failure</h3>
                        <p class="diagnose-situation">Nobody follows up consistently.</p>
                        <p class="diagnose-consequence">Opportunities die without anyone noticing.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">06</span>
                    <div class="diagnose-content">
                        <h3>Leadership Bottlenecks</h3>
                        <p class="diagnose-situation">Everything depends on one person.</p>
                        <p class="diagnose-consequence">Growth becomes impossible because execution cannot scale.</p>
                    </div>
                </div>

                <div class="diagnose-item" role="listitem">
                    <span class="diagnose-num" aria-hidden="true">07</span>
                    <div class="diagnose-content">
                        <h3>Hidden Revenue Leakage</h3>
                        <p class="diagnose-situation">Small operational failures compound.</p>
                        <p class="diagnose-consequence">No single disaster. Just constant invisible financial damage.</p>
                    </div>
                </div>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement with get_field('diagnose_statement', 'option') */ ?>
            <div class="diagnose-statement">
                <p>Most businesses do not have a sales problem.</p>
                <p class="diagnose-statement-emphasis">They have an execution visibility problem.</p>
            </div>

            <!-- Executive Diagnostic purpose — centered large type -->
            <?php /* TODO: ACF — replace purpose block with get_field('diagnose_purpose', 'option') */ ?>
            <div class="diagnose-purpose">
                <p class="diagnose-purpose-setup">We do not guess.</p>
                <p class="diagnose-purpose-anchor">We diagnose.</p>
                <p class="diagnose-purpose-detail">
                    We identify where money is leaking, what must be fixed first,
                    and what should never be automated.
                </p>
            </div>

            <!-- Micro CTA -->
            <div class="diagnose-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('diagnose_cta_label', 'option') */ ?>
                <p class="diagnose-cta-label">Clarity before automation.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
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
                <p class="section-label">The Process</p>

                <?php /* TODO: ACF — replace headline with get_field('exd_headline', 'option') */ ?>
                <h2 id="exd-headline">The Executive Diagnostic</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('exd_lead', 'option') */ ?>
                <p class="exd-lead">
                    This is not a sales call.<br>
                    This is an executive operational review focused on identifying where your company
                    is losing money, where execution is breaking, and what should happen next.
                </p>

            </header>

            <!-- 4-step process — 2×2 grid -->
            <?php /* TODO: ACF — replace all step content with repeater get_field('exd_steps', 'option') */ ?>
            <div class="exd-grid">

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">01</span>
                    <p class="exd-card-step">Step 1</p>
                    <h3 class="exd-card-title">Executive Intake</h3>
                    <div class="exd-card-body">
                        <p>We review your operation, current systems, decision flow, scheduling pressure,
                        response discipline, leadership bottlenecks, and revenue leakage indicators.</p>
                        <p>We identify how the business actually operates — not how it looks on paper.</p>
                    </div>
                </article>

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">02</span>
                    <p class="exd-card-step">Step 2</p>
                    <h3 class="exd-card-title">Operational Diagnosis</h3>
                    <div class="exd-card-body">
                        <p>We map where execution breaks.</p>
                        <ul class="exd-areas">
                            <li>Lead response</li>
                            <li>Scheduling</li>
                            <li>Estimates</li>
                            <li>Follow-up</li>
                            <li>Admin overload</li>
                            <li>Leadership dependency</li>
                        </ul>
                        <p>We isolate where money is leaking.</p>
                    </div>
                </article>

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">03</span>
                    <p class="exd-card-step">Step 3</p>
                    <h3 class="exd-card-title">Strategic Review</h3>
                    <div class="exd-card-body">
                        <p>We define what should be fixed first.</p>
                        <ul class="exd-areas">
                            <li>What should be automated</li>
                            <li>What should never be automated</li>
                            <li>What creates the fastest operational impact</li>
                        </ul>
                    </div>
                </article>

                <article class="exd-card">
                    <span class="exd-card-num" aria-hidden="true">04</span>
                    <p class="exd-card-step">Step 4</p>
                    <h3 class="exd-card-title">Executive Recommendation</h3>
                    <div class="exd-card-body">
                        <p>You receive strategic clarity.</p>
                        <p>Not generic advice.</p>
                        <p>A real executive path forward.</p>
                        <p>Whether implementation happens with us or not.</p>
                    </div>
                </article>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement lines with get_field('exd_statement', 'option') */ ?>
            <div class="exd-statement">
                <p>Most companies try to buy tools before understanding the problem.</p>
                <p>That is backwards.</p>
                <p class="exd-statement-anchor">We fix that first.</p>
            </div>

            <!-- Trust statement -->
            <?php /* TODO: ACF — replace trust block with get_field('exd_trust', 'option') */ ?>
            <div class="exd-trust">
                <p class="exd-trust-body">
                    This is why qualified companies are currently receiving the
                    Initial Executive Diagnostic at no cost.
                </p>
                <p class="exd-trust-reason">Because clarity creates better decisions.</p>
            </div>

            <!-- Micro CTA -->
            <div class="exd-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('exd_cta_label', 'option') */ ?>
                <p class="exd-cta-label">Limited availability for qualified companies.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
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
                <p class="section-label">Executive Proof</p>

                <?php /* TODO: ACF — replace headline with get_field('proof_headline', 'option') */ ?>
                <h2 id="proof-headline">Where Operations Improve, Revenue Follows</h2>

                <?php /* TODO: ACF — replace lead copy with get_field('proof_lead', 'option') */ ?>
                <p class="proof-lead">
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
                    <p class="proof-card-vertical">Contractor Operations</p>
                    <div class="proof-card-problem">
                        <p class="proof-zone-label">Problem</p>
                        <ul class="proof-problem-list">
                            <li>Missed calls</li>
                            <li>Scheduling gaps</li>
                            <li>Delayed estimates</li>
                            <li>Revenue leakage between jobs</li>
                        </ul>
                    </div>
                    <div class="proof-card-divider" aria-hidden="true"></div>
                    <div class="proof-card-result">
                        <p class="proof-zone-label proof-zone-result">Result</p>
                        <ul class="proof-result-list">
                            <li>Faster response</li>
                            <li>Cleaner dispatch</li>
                            <li>Higher booking consistency</li>
                            <li>Operational visibility</li>
                        </ul>
                    </div>
                </article>

                <!-- Case Study 2 -->
                <article class="proof-card">
                    <p class="proof-card-vertical">Multifamily Operations</p>
                    <div class="proof-card-problem">
                        <p class="proof-zone-label">Problem</p>
                        <ul class="proof-problem-list">
                            <li>Maintenance pressure</li>
                            <li>Vendor coordination failures</li>
                            <li>Delayed execution</li>
                            <li>Administrative overload</li>
                        </ul>
                    </div>
                    <div class="proof-card-divider" aria-hidden="true"></div>
                    <div class="proof-card-result">
                        <p class="proof-zone-label proof-zone-result">Result</p>
                        <ul class="proof-result-list">
                            <li>Cleaner workflows</li>
                            <li>Reduced friction</li>
                            <li>Execution control</li>
                            <li>Leadership visibility</li>
                        </ul>
                    </div>
                </article>

                <!-- Case Study 3 -->
                <article class="proof-card">
                    <p class="proof-card-vertical">Service Business Operations</p>
                    <div class="proof-card-problem">
                        <p class="proof-zone-label">Problem</p>
                        <ul class="proof-problem-list">
                            <li>Broken follow-up</li>
                            <li>Administrative drag</li>
                            <li>Poor lead conversion</li>
                            <li>Growth without operational structure</li>
                        </ul>
                    </div>
                    <div class="proof-card-divider" aria-hidden="true"></div>
                    <div class="proof-card-result">
                        <p class="proof-zone-label proof-zone-result">Result</p>
                        <ul class="proof-result-list">
                            <li>Operational discipline</li>
                            <li>Faster decision flow</li>
                            <li>Better conversion</li>
                            <li>Scalable execution</li>
                        </ul>
                    </div>
                </article>

            </div>

            <!-- Strategic statement -->
            <?php /* TODO: ACF — replace statement with get_field('proof_statement', 'option') */ ?>
            <div class="proof-statement">
                <p>Good operations create measurable outcomes.</p>
                <p>Good marketing only creates temporary attention.</p>
                <p class="proof-statement-anchor">We optimize the first.</p>
            </div>

            <!-- Authority block -->
            <?php /* TODO: ACF — replace authority block with get_field('proof_authority', 'option') */ ?>
            <div class="proof-authority">
                <p>Our work is not judged by how impressive the automation looks.</p>
                <p class="proof-authority-anchor">It is judged by what stops breaking.</p>
            </div>

            <!-- Micro CTA -->
            <div class="proof-cta">
                <?php /* TODO: ACF — replace micro-CTA label with get_field('proof_cta_label', 'option') */ ?>
                <p class="proof-cta-label">If operations improve, revenue follows.</p>
                <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
                <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener">
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
                <p class="section-label">Executive Advisory Desk</p>

                <h2 id="advisor-headline">Speak With Your Private Executive Advisor</h2>

                <p class="advisor-intro">
                    Before booking your Executive Diagnostic, speak directly with our Executive Advisory Desk.
                </p>

                <p class="advisor-body">
                    We help identify if the issue is lead generation, operations, scheduling,
                    follow-up discipline, or hidden revenue leakage.
                    Start the right conversation first.
                </p>

                <?php /* TODO: ACF — replace CTA label with get_field('advisor_cta_label', 'option') and URL with get_field('advisor_cta_url', 'option') */ ?>
                <?php /* TODO: Replace #advisor with the real Private Executive Advisor widget trigger when implemented. */ ?>
                <a href="#advisor" class="btn-secondary">
                    Start Advisory Conversation
                </a>

            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
