<?php
$site_name = get_setting('site_name', 'LEXALINK ID');
$name_parts = explode(' ', $site_name);
$last_word = array_pop($name_parts);
$first_part = implode(' ', $name_parts);
?>
<section id="footer_b" class="py-3" style="background: #00101f; border-top: 1px solid rgba(255,255,255,0.05);">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start">
        <p class="mb-0 text-white-50 small">© <?= date('Y') ?> <span class="fw-bold text-white"><?= $first_part ?> <?= $last_word ?></span>. Seluruh Hak Cipta Dilindungi.</p>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <p class="mb-0 text-white-50 small">Dikembangkan dengan <i class="fa fa-heart text-danger"></i> untuk Kepastian Hukum Indonesia.</p>
      </div>
    </div>
  </div>
</section>
