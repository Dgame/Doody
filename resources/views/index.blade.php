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
                <div class"col-md-12">
                     <a href="/assets/img/logo.png">
                        <img src="/assets/img/logo.png">
                    </a>
                </div>
                <form action="/search" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Search...">
                        <button type="submit" class="btn btn-default" aria-label="Search">
                             <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                </form>

                {{ Form::open(['url' => '/search']) }}
                {{ Form::text('username', '', ['class' => 'form-control', 'placeholder' => 'Search...']) }}
                {{ Form::close() }}
            </div>
        </div>
    </body>
</html>
