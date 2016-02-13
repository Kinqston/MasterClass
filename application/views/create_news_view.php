<form enctype="multipart/form-data" role="form" method="POST">
	<div class="caption">
		<h3>Добавить новость</h3>
		<p><input type="text" id="newsCaption" name="newsCaption" class="form-control" placeholder="Заголовок новости"></p>
		<p><textarea id="newsText" name="newsText" class="form-control" rows="5" placeholder="Текст новости"></textarea></p>
		<p><input name="uploadfile" type="file"></p>
		<p align="right">
			<input name="button" type="button" class="btn btn-default" value="Назад" onclick="(function() {window.location.replace('/news')})()"> 
			<input name="submit" type="submit"  class="btn btn-primary" value="Создать">
		</p>
	</div>
</form>