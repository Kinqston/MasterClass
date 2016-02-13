<style>
    .form-control {
        border: none;
        border-bottom: 1px solid;
        box-shadow: none;
        border-radius: 0;
    }
    .form-control:focus {
        box-shadow: none;
    }
    #event_text {
        border-radius: 4px;
        border: 1px solid;
    }
    #event_text:focus {
        border-color: dodgerblue;
    }
</style>
<h2>
   Создать событие
</h2>
<div class="container">
   <div class="row">
      <form role="form" method="POST"   >
         <div class="col-md-6">
             <div class="form-group">
                 <label for="professor">Выберите профессора</label>
                 <select class="form-control" name="professor" id="professor">
                     <?php
                     foreach($data["professors"] as $professor) {
                         echo "<option>" . $professor["user_info"] . "</option>";
                     }
                     ?>
                 </select>
             </div>
          </div>

         <div class="col-md-3">
              <div class="form-group">
                  <label for="group">Группа</label>
                  <select class="form-control" name="group" id="group">
                      <?php
                      foreach($data["groups"] as $group) {
                          echo "<option>" . $group["group_name"] . "</option>";
                      }
                      ?>
                  </select>
              </div>
         </div>

         <div class="col-md-3">
              <div class="form-group">
                  <label for="date">Дата</label>
                  <input type="text" class="form-control" id="date" name="date" value='<?php if(isset($data["date"])) echo $data["date"] ?>'>
              </div>
         </div>
         <div class="form-group">
             <div class="form-group">
                 <label for="event_text">Информация</label>
                 <textarea id="event_text" name="event_text" class="form-control" rows="3" placeholder="Введите информацию о событии"></textarea>
             </div>
         </div>
         <input name="submit" type="submit" class="btn btn-default" value="Создать">
      </form>
   </div>
</div>