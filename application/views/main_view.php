<style>
  .main_li {
    background-color: #87d2c7;
    border-radius: 5px;
  }
</style>
<div class="row">
  <h3>Последние новости</h3>
  <?php if(empty($data["news"])): ?>
      <p> Нет ни одной новости </p>
  <?php endif; ?>
  <?php foreach ($data["news"] as $value) { ?>
  <div class="col-sm-4 col-md-4">
    <div class="thumbnail">
      <img src="/images/<?php print $value['image']; ?>" class="img-rounded" alt="...">
      <div class="caption" style="overflow: hidden;">
        <h3><?php print $value["caption"]; ?></h3>
        <p><?php print $value["ntext"]; ?></p>
      </div>
      <p align="right"><a href='/news/viewnews/<?php print $value["id"]?>'>Перейти к новости</a></p>
    </div>
  </div>
  <?php } ?>
</div>