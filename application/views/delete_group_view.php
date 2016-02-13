<style>
    .success{
        margin-top: 20px;
        border-top: 1px solid;
    }
    .err {
        color: red;
    }
    .suc {
        color: green;
    }
</style>
<div class="container">
    <form role="form" method="POST"   >
    <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group">Выберите группу</label>
                    <select class="form-control" name="group" id="group">
                        <?php
                        foreach($data["groups"] as $group) {
                            echo "<option>" . $group["group_name"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
    </div>
        <input name="button" type="button" class="btn btn-default" value="<<< Назад" onclick="(function() {window.location.replace('/admin')})()">
        <input name="submit" type="submit" class="btn btn-default" value="Удалить">
        <?php
        if(isset($data["success"]))
            if($data["success"])
                echo "<p class='success'><span class='suc'>Группа была успешно удалена</span></p>";
            else
                echo "<p class='success'><span class='err'>Что-то пошло не так</span></p>";
        ?>
    </form>
</div>