<?php
/**
 * RACBCONSULTING — footer.php
 */
?>

<!-- FOOTER -->
<footer class="site-footer">

  <div class="footer-inner">

    <p class="footer-label" data-i18n="fp-footer-label">Executive Consulting</p>

    <h3 class="footer-headline" data-i18n="fp-footer-headline">
      If you're still here, your operation is leaving money on the table.
    </h3>

    <p class="footer-subtext" data-i18n="fp-footer-subtext">
      We identify where your company is losing money — and what needs to be fixed first.
    </p>

    <?php /* TODO: MVP dependency — Executive Diagnostic CTA intentionally routes to mvp.racbconsulting.com. MVP is managed in separate RACBCONSULTING-MVP project. */ ?>
    <a href="https://mvp.racbconsulting.com" class="btn-primary" target="_blank" rel="noopener" data-i18n="fp-cta-btn">
      Book Executive Diagnostic
    </a>

    <div class="footer-meta">
      <p>RACBCONSULTING LLC</p>
      <p>Austin, Texas</p>
      <p>ceo@racbconsulting.com</p>
    </div>

  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
