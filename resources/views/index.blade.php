<!DOCTYPE html>
<html>
    <head>
        <title>Doody</title>
        <link href="/assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="content">
            <div class="center">
                 <a href="/">
                    <img src="/assets/img/logo.png">
                </a>
                <form action="/search" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="text" name="search" class="search-bar" placeholder="Search...">
                    <input type="submit" value="Search" class="search-button" />
                </form>
            </div>
        </div>
    </body>
</html>
