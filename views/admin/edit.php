<h1>Редактирование новости</h1>
<form role="form" method = 'POST'>
  <div class="form-group">
    <label for="name">Название</label>
    <input type="text" name ="name" class="form-control" value = '<?php echo $new['name'];?>'>
  </div>
  <div class="form-group">
    <label>Текст</label>
    <textarea  class="ckeditor" name="text"><?php echo $new['text'];?></textarea>
  </div>
  <button type="submit" class="btn btn-default">Сохранить</button>
</form>
