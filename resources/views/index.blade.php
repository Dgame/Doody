<!DOCTYPE html>
<html>
    <head>
        <title>Doody</title>
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="col-md-12">
                     <a href="/assets/img/logo.png">
                        <img src="/assets/img/logo.png">
                    </a>
                </div>
                <form action="/search" method="post" class="form-inline">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                    </div>
                    <input type="submit" value="Search" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </body>
</html>
