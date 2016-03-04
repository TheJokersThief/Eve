<!DOCTYPE html>
<html>
    <head>
        @if(!isset($error))
            <title>You don't have permission to access this.</title>
        @else
            <title>{{$error}}</title>
        @endif

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                @if(!isset($error))
                    <div class="title">{{_t("You don't have permission to access this.")}}</div>
                @else
                    <div class="title">{{_t($error)}}</div>
                @endif
            </div>
        </div>
    </body>
</html>
