<h1>Создание новости</h1>
<form role="form" method = 'POST'>
  <div class="form-group">
    <label for="name">Название</label>
    <input type="text" name ="name" class="form-control">
  </div>
  <div class="form-group">
    <label>Текст</label>
    <textarea  class="ckeditor" name="text"></textarea>
  </div>
  <button type="submit" class="btn btn-default">Добавить</button>
</form>
