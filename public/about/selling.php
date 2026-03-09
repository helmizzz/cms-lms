<?php
$about_post = db_get_one("SELECT content FROM posts WHERE type = 'about' LIMIT 1");
$about_content = $about_post ? $about_post['content'] : 'Pellentesque at posuere tellus. Ut sed dui justo. Phasellus scelerisque turpis arcu, ut pulvinar lectus tristique non. Nam laoreet, risus vel laoreet laoreet, mauris risus porta velit, id imperdiet ante nisi in ante.';
?>
<section id="sell" class="pt-5 pb-5">
     <div class="container">
       <div class="sell_i row mb-4">
            <div class="col-md-6">
         <div class="sell mt-5">
           <h1>Our brand, your value</h1>
           <p><?= nl2br($about_content) ?></p>
           <h5><a class="button_3" href="contact.php">Hubungi Kami</a></h5>
         </div>
       </div>
            <div class="col-md-6">
        <div class="sell_1">
         <img src="img/6.jpg" alt="abc" height="450" class="w-100">
        </div>
       </div>
       </div>
       <div class="row sell_i">
           <div class="col-md-6">
        <div class="sell_1">
         <img src="img/7.jpg" alt="abc" height="450" class="w-100">
        </div>
       </div>
            <div class="col-md-6">
         <div class="sell">
           <h1>Your goal complete</h1>
           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum.</p>
           <h6>Lorem ipsum dolor sit amet <i class="fa fa-check col_oran float-end"></i></h6>
		   <h6>Lorem ipsum dolor sit amet <i class="fa fa-check col_oran float-end"></i></h6>
		   <h6>Lorem ipsum dolor sit amet <i class="fa fa-check col_oran float-end"></i></h6>
		   <h6>Lorem ipsum dolor sit amet <i class="fa fa-check col_oran float-end"></i></h6>
		   <h6 class="mb-0 pb-0 border-0">Lorem ipsum dolor sit amet <i class="fa fa-check col_oran float-end"></i></h6>
          
         </div>
       </div>
      </div>

     </div>
</section>