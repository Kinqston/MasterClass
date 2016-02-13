<div class="container">
    <div class="row">
        <h2>Список</h2>
        <?php
            foreach($data["list"] as $professor) {
                echo "<p><div class='col-md-6'> {$professor["user_info"]}</div><div class='col-md-6'><a href='/profile/{$professor["login"]}'>{$professor["login"]}</a></div> </p>";
            }
        ?>
    </div>
</div>