<form enctype="multipart/form-data" role="form" method="POST">
  <div class="row">	
  	<?php foreach ($data["news"] as $value) { ?>
  	 	<div class="thumbnail">
        		<div class="caption">
            <h3>Заголовок новости:</h3>
          	<h3><textarea id="newsCaption" name="newsCaption" type="text" rows="1" class="form-control" placeholder=""><?php print $value["caption"]; ?></textarea></h3>
            <p>Текст новости:</p>
          	<p><textarea id="newsText" name="newsText" type="textarea" rows="5" class="form-control" placeholder=""><?php print $value["ntext"]; ?></textarea></p>
            <p><input name="uploadfile" type="file"></p>
            <p align="right">
              <input name="button" type="button" class="btn btn-default" value="Назад" onclick="(function() {window.location.replace('/news')})()">
              <input name="submit" type="submit"  class="btn btn-primary" value="Изменить">
            </p>
        		</div>
      	</div>
      	<?php } ?>
  </div>
</form>