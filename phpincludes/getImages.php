<?php 
require("../config.php");
	
	$images = Image::getImagesByArticleId( $_POST['articleId'] );

 foreach ($images as $image)  { ?>
			<div class="image-thumb">
			
			<form action="" method="post"
				id="image-options-<?php echo $image->id  ?>" 
				class="image-options-form">
			
				<input type="hidden" name="id" value="<?php echo $image->id ?>">
				
				<label for="image<?php echo $image->id ?>"><img src="<?php echo THUMBS_IMAGE_PATH . "/" . $image->source ?>" alt=""></label>
				<input type="checkbox" id="image<?php echo $image->id ?>">
				
				<div class="image-options">
					
					<h3>Image Options</h3>
					<div class="image-size-wrapper">
						<p>Size</p>
						<label for="image_size_small">Small</label>
							<input type="radio" name="radio_image_size_<?php echo $image->id ?>" value="0"
								id="image_size_small" <?php echo ($image->presentation_size == 0) ? "checked" : "" ?> >
						<label for="image_size_medium">Medium</label>
							<input type="radio" name="radio_image_size_<?php echo $image->id ?>" value="1"
							id="image_size_medium"  <?php echo ($image->presentation_size == 1) ? "checked" : "" ?> >
						<label for="image_size_large">Large</label>
							<input type="radio" name="radio_image_size_<?php echo $image->id ?>" value="2"
							id="image_size_large" <?php echo ($image->presentation_size == 2) ? "checked" : "" ?> >
					</div>
					
					<div class="image-subtitle-wrapper">
						<label for="image_subtitle">Untertitel</label>
							<input type="text" id="image_subtitle" name="image-subtitle" placeholder="subtitle"
								value="<?php echo $image->subtitle ?>">
					</div>
				
				</div>	
				<button type="button" onclick="if (confirm('Dieses Bild wirklich löschen?'))deleteImageFromArticle(<?php echo $image->id ?>, <?php echo $_POST['articleId'] ?>) ">LÖSCHEN</button>
				</form>	
				</div>
				<div class="clearfloat"></div>
			
			<?php }  ?>
