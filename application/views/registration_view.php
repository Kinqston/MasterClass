<div class="container">
    <h2>Регистрация</h2><br>
    <div class="row">
        <form role="form" method="POST"   >
            <div class="form-group <?php if(isset($data["errors"])) echo $data["errors"]["login"];?>"">
                <label for="login">Логин</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Введите ваш логин" required>
            </div>
            <div class="form-group <?php if(isset($data["errors"])) echo $data["errors"]["pass"];?>">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Введите ваш пароль" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Повторите пароль</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Повторите ваш пароль" required>
            </div>

            <div class="form-group">
                <label for="if_stuff">Вы преподаватель?</label>
                <select class="form-control" name="if_stuff" id="if_stuff">
                    <option>Нет</option>
                    <option>Да</option>
                </select>
            </div>
            <div class="form-group">
                <label for="group">Выберите группу (если знаете)</label>
                <select class="form-control" name="group" id="group">
                    <?php
                    foreach($data["options"] as $group) {
                        echo "<option>" . $group["group_name"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group <?php if(isset($data["errors"])) echo $data["errors"]["info"];?>">
                <label for="user_info">ФИО</label>
                <input type="text" class="form-control" id="user_info" name="user_info" placeholder="Ваше фамилия имя и отчество" required>
            </div>

            <div class="form-group <?php if(isset($data["errors"])) echo $data["errors"]["contacts"];?>">
                <label for="contacts">Контактная информация</label>
                <input type="text" class="form-control" id="contacts" name="contacts" placeholder="Как мы можем найти вас?" required>
            </div>


            <input name="submit" type="submit" class="btn btn-default" value="Регистрация">
        </form>

    <script>
        var constraints = {
            password: {
                length: {
                    minimum: 4,
                    maximum: 64,
                    tooShort: "должно содержать больше 4 символов",
                    tooLong: "должно содержать меньше 64 символов"
                }
            },
            login : {
                format: {
                    pattern: /^[a-zA-Z0-9_]*$/,
                    message: "содержит недопустимые символы"
                },
                length: {
                    minimum: 4,
                    maximum: 64,
                    tooShort: "должен содержать больше 4 символов",
                    tooLong: "должен содержать меньше 64 символов"
                }
            }
        };

        console.log(validate({login: "Falscroom"}, constraints));
    </script>
    </div>
</div>