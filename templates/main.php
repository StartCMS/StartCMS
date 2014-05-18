<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/static/favicon.ico">

        <title>StartCMS</title>

        <!-- Bootstrap core CSS -->
        <link href="/static/css/bootstrap.min.css" rel="stylesheet">


        <!-- Custom styles for this template -->
        <link href="/static/css/bootstrap-theme.min.css" rel="stylesheet">

        <link href="/static/css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">StartCMS</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/news">News</a></li>
                    </ul>
                    <?php if (empty($_SESSION['admin'])) { ?>
                        <form class="navbar-form navbar-right" role="search" method = 'POST'>
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="password">
                            </div>
                            <button type="submit" class="btn btn-default">Sign in</button>
                        </form>
                    <?php } else { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/admin">Admin</a></li>
                            <li><a href="?logout=1">logout</a></li>
                        </ul>
                    <?php } ?>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">
            <?php if (!empty($_SESSION['msgs'])): ?>
                <?php foreach ($_SESSION['msgs'] as $msg): ?>
                    <div class='alert alert-<?= $msg['type'] ?> alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <?= $msg['text'] ?>
                    </div>
                <?php endforeach; ?>
                <?php $_SESSION['msgs'] = array(); ?>
            <?php endif; ?>
            <?php echo $content; ?>

        </div><!-- /.container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script src="/static/ckeditor/ckeditor.js"></script>
        <script src="/static/js/jquery-1.11.1.min.js"></script>
        <script src="/static/js/bootstrap.min.js"></script>
        <script src="/static/script.js"></script>
    </body>
</html>
