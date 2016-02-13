<script type="text/javascript" src="//vk.com/js/api/openapi.js?117"></script>
<script type="text/javascript">
  VK.init({apiId: 5102220, onlyWidgets: true});
</script>
<div class="row">	
  <?php foreach ($data["news"] as $value) { ?>
  <div class="thumbnail">
    <div class="caption">
      <div style="margin: 0px 0px 0px 0px">
        <a href="/images/<?php print $value['image']; ?>"><img src="/images/<?php print $value['image']; ?>" class="img-rounded" width="100%"></a>
      </div>
      <div style="display: table-cell">
        <h3><?php print $value["caption"]; ?></h3>
        <p><?php print $value["ntext"]; ?></p>
      </div>
      <p align="right"><input name="button" type="button" class="btn btn-default" value="Назад" onclick="(function() {window.location.replace('/news')})()">
      <?php if ($data["rights"] & U_EDIT) {
        print '<a href="/news/editnews/'.$value['id'].'" class="btn btn-default" role="button">Редактировать</a> <a href="/news/deletenews/'.$value['id'].'" class="btn btn-default" role="button">Удалить</a>';
      } ?>
      </p>
    </div>
    <div id="vk_comments">
      <script type="text/javascript">
        VK.Widgets.Comments("vk_comments", {limit: 100, width: "auto", attach: "*"});
      </script>
    </div>
  </div>
  <?php } ?>
</div>