<html>
    <head>
        <title>Doody</title>
        <link href="/assets/css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    </head>
    <body>
        <script>
            $(document).ready(function() {
                $("#search").val("<?php echo $request; ?>");
            });
        </script>
        <div class="head">
                <a href="/assets/img/logo.png">
                    <img src="/assets/img/logo.png" class="small">
                </a>
                <div class="inline">
                    <form action="/search" method="post">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="text" class="head-search" id="search" name="search" placeholder="Search...">
                        <input type="submit" class="head-submit" value="Search" />
                    </form>
                </div>
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
