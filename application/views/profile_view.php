<style>
    .navbar-right {
        background-color: #87d2c7;
        border-radius: 5px;
    }
</style>
<style>
    p { padding-bottom: 1px; }
    a { cursor: pointer;}
    .column_2 {text-align: right}
    .hidden { height: 0; overflow: hidden;}
    div > input { width: 100%;}
    .error {
        border: solid 2px red;
    }
</style>
<div class="container">
    <h2>Профиль <?php echo $data["user"]["login"] ?></h2>

    <div class="row">
        <div class="col-md-6">Фамилия Имя Отчество :</div><div class="col-md-6 column_2"><?php echo $data["user"]["user_info"] ?></div>
    </div>
    <div class="row">
        <div class="col-md-6">Контакты :</div><div class="col-md-6 column_2"><?php echo $data["user"]["contacts"] ?></div>
    </div>
    <div class="row">
        <div class="col-md-6">Статус :</div><div class="col-md-6 column_2"><?php
            switch($data["user"]["if_stuff"]) {
                case true: echo("Преподаватель"); if(!($data["user"]["rights"] & U_EDIT)) { echo(" (неподтверждено!)");
                    if($data["rights"] == U_PROFESSOR)
                        echo ("<p><a href='/admin/upgrade_rights/{$data["user"]["id"]}'>Подтвердить</a></p>"); }
                    break;
                case false: echo("Пользователь");
                    break;
            }
            ?></div>
    </div>

    <?php if($data["owner"]): ?>
        <div class="row">
            <div class="col-md-6">Пароль :</div><div class="col-md-6 column_2"><a id="change_pass">Сменить</a></div>
        </div>
        <div class="pass_container hidden">
            <div class="row">
                <div class="col-md-5"><input type="text" id="new_pass" placeholder="Новый пароль"></div>
            </div>
            <div class="row col-md-12" style="margin-top: 5px">
                <input type="button" class="col-md-3" id="submit_change" value="Сменить">
            </div>
        </div>
        <script type="text/javascript">
            $("#change_pass").bind("click", function() {
                $(".pass_container").removeClass("hidden");
            });
            $("#submit_change").bind('click',function() {
                var pass = $('#new_pass').val();
                $.ajax({
                    type: "POST",
                    url: "/profile/change_pass",
                    data: { password: pass},
                    success: function(result){
                        if(result) {
                            $(".pass_container").addClass("hidden");
                            $("#change_pass").text("Пароль изменен. Изменить ещё раз?");
                        }
                        else
                        {
                            $("#new_pass").addClass("error");
                        }
                    }
                });
            })
        </script>
    <?php endif; ?>
    <?php if($data["rights"] == U_PROFESSOR && $data["owner"]) : ?>
        <div class="row">
            <div class='col-md-6'><a href='/admin'>Перейти к администрированию</a></div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div><a href="/main/logout">Выйти из профиля</a></div>
    </div>
</div>