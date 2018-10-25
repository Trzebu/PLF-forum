<div class="navigation">
    <div class="navigation-block">
        <div class="header">General</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('groups') ?: 'left-navigation-active' }}"><a href="{{ route('admin.permissions.groups') }}">Manage groups</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('new') ?: 'left-navigation-active' }}"><a href="{{ route('admin.permissions.groups.new') }}">New group</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('view_permissions') ?: 'left-navigation-active' }}"><a href="{{ route('admin.permissions.view') }}">View permissions</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('new_permission') ?: 'left-navigation-active' }}"><a href="{{ route('admin.permissions.new') }}">New permission</a></li>
        </ul>
    </div>
</div>