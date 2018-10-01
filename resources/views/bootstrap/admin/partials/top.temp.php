<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Administration Controll Panel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="{{ route('/') }}/public/framework/css/normalize.css">
        <link rel="stylesheet" href="{{ route('/') }}/public/app/css/admin/main.css">
    </head>

    <body>
        <div class="text-center">
            <h2>Administration Controll Panel</h2>
        </div>
        @include admin/partials/alerts
        <div class="page-container">
            <div class="tabs">
                <ul>
                    <li class="tab {{ !Libs\Http\Request::inUrl('general_settings') ?: 'tab-active' }}"><a href="">General</a></li>
                    <li class="tab"><a href="">Forums</a></li>
                    <li class="tab"><a href="">Posting</a></li>
                    <li class="tab"><a href="">Usera and Groups</a></li>
                    <li class="tab"><a href="">Permissions</a></li>
                </ul>
            </div>
            <div class="inside-container">
    </body>

</html>