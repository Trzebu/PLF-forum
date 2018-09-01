<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <title>Forum</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ route('/') }}/public/app/css/main.css">

    </head>

    <body class="h-100 w-100">
        @include partials/top_navbar

        <div class="container h-90">
            @include partials/alert
