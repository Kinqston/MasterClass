<style>
    .button {
        border-radius: 4px;
        cursor: pointer;
        background-color: white;
        height: 25px;
        text-align: center;
        border: 1px solid;
        margin-right: 2px;
    }
    .button:hover {
        cursor: pointer;
        border-color: dodgerblue;
    }
    label {
        margin-top: 10px;
    }
    a:hover {
        color: black;
        text-decoration: none;
    }
    .button > a {
        color: black;
        padding: 0;
        font-size: 14px;
    }
</style>
<div class="container">
    <p><h2>Панель администратора</h2></p>
    <label for="#group">Редактирование групп</label>
    <div class="row" id="group">
        <div class="col-md-2 button" onclick="(function(e){ window.location.replace('/admin/create_group'); })(event)">Добавить</div>
        <div class="col-md-2 button" onclick="(function(e){ window.location.replace('/admin/delete_group'); })(event)">Удалить</div>
    </div>

    <label for="#event">Списки</label>
    <div class="row" id="event">
        <div class="col-md-5 button"><a href="/admin/list_professors">Преподаватели без подтверждения</a></div>
    </div>
</div>