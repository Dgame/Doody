<html>
    <head>
        <title>Doody</title>
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="result-header row">
            <div class="col-md-1 col-xl-1">
                <a href="/assets/img/logo.png" class="thumbnail">
                    <img src="/assets/img/logo.png">
                </a>
            </div>
            <div class="col-md-11 col-xl-11 result-header-search">
                <form action="/search" method="post" class="form-inline">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="text" class="form-control result-header-search-bar" name="search" placeholder="Search...">
                        <input type="submit" value="Search" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
        <div>
            @foreach($results as $result)
                <h1>{{ $result->url }}</h1>
                <p>{{ $result->content }}</p>
            @endforeach
        </div>
    </body>
</html>
