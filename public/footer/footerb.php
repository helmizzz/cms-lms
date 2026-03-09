<?php
$site_name = get_setting('site_name', 'LEXALINK ID');
$name_parts = explode(' ', $site_name);
$last_word = array_pop($name_parts);
$first_part = implode(' ', $name_parts);
?>
<section id="footer_b" class="pt-3 pb-3">
  <div class="container">
   <div class="row footer_b_1 text-center">
    <div class="col-md-12">
      <p class="mb-0 col_light font_15">© 2013 <?= $first_part ?> <span class="col_oran"><?= $last_word ?></span>. All Rights Reserved | Design by <a class="col_oran" href="http://www.templateonweb.com">TemplateOnWeb</a></p>
    </div>
   </div>
  </div>
 </section>
