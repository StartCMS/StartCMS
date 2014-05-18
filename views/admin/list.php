<h1>news Management</h1>
<p>
  <a href ="/admin/add" class="btn btn-primary btn-lg">Add news</a>
</p>
<?php
if (empty($news)) {
    echo "<h3>Новостей пока не добавдено</h3>";
} else {
    echo '<table class="table table-striped">';
    echo "<tr><th>News</th><th>Date</th><th></th></tr>";
    foreach ($news as $new) {
        echo "<tr><td>{$new['name']}</td><td>{$new['date']}</td><td><a href = '/admin/edit/{$new['id']}' class='btn btn-success btn-sm'>Edit</a> <a href = '/admin/del/{$new['id']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
    }
    echo '</table>';
}
