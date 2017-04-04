<?php 
require("../config.php");
	
	$images = Image::getImagesByArticleId( $_POST['articleId'] );

 foreach ($images as $image)  { ?>
			<div class="image-thumb">
				<label for="image<?php echo $image->id ?>"><img src="<?php echo THUMBNAILS_PATH . "/" . $image->source ?>" alt=""></label>
				<input type="checkbox" id="image<?php echo $image->id ?>">
				<div class="image-options">
					<h3>Image Options</h3>
					
				<button type="button" onclick="deleteImageFromArticle(<?php echo $image->id ?>, <?php echo $_POST['articleId'] ?>)">LÖSCHEN</button>
					
				</div>
			
			<?php }  ?>
		</div>