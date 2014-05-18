<h1>Управление новостями</h1>
<p>
  <a href ="/admin/add" class="btn btn-primary btn-lg">Добавить новость</a>
</p>
<?php
if (empty($news)) {
    echo "<h3>Новостей пока не добавдено</h3>";
} else {
    echo '<table class="table table-striped">';
    echo "<tr><th>Новость</th><th>Дата</th><th>Операции</th></tr>";
    foreach ($news as $new) {
        echo "<tr><td>{$new['name']}</td><td>{$new['date']}</td><td><a href = '/admin/edit/{$new['id']}' class='btn btn-success btn-sm'>Изменить</a> <a href = '/admin/del/{$new['id']}' class='btn btn-danger btn-sm'>удалить</a></td></tr>";
    }
    echo '</table>';
}