<!DOCTYPE html>
<html lang="en">

    <head>
        <title>{{ $this->title }}</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ route('/') }}/public/framework/css/normalize.css">
        <link rel="stylesheet" href="{{ route('/') }}/public/app/css/admin/main.css">
    </head>

    <body>
        <div class="text-center">
            <h2>Administration Controll Panel</h2>
        </div>
        <div class="page-container">
            @include admin/partials/alerts
            <div class="tabs">
                <ul>
                    <li class="tab {{ !Libs\Http\Request::inUrl('general_settings') ?: 'tab-active' }}"><a href="{{ route('admin.general_settings') }}">General</a></li>
                    <li class="tab {{ !Libs\Http\Request::inUrl('forums') ?: 'tab-active' }}"><a href="{{ route('admin.forums') }}">Forums</a></li>
                    <li class="tab {{ !Libs\Http\Request::inUrl('contents') ?: 'tab-active' }}"><a href="{{ route('admin.contents.view') }}">Contents</a></li>
                    <li class="tab"><a href="">Usera and Groups</a></li>
                    <li class="tab"><a href="">Permissions</a></li>
                </ul>
            </div>
            <div class="inside-container">
    </body>

</html>