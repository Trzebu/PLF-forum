<div class="navigation">
    <div class="navigation-block">
        <div class="header">Quick access</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('manage_users') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.manage_users') }}">Manage users</a></li>
            <li><a href="{{ route('admin.permissions.groups') }}">Manage groups</a></li>
            <li><a href="{{ route('admin.forums.manage_forums') }}">Manage forums</a></li>
        </ul>
    </div>
    <div class="navigation-block">
        <div class="header">Board configuration</div>
        <ul>
            <li><a href="{{ route('admin.contents.downloads.settings') }}">Uploading settings</a></li>
            <li><a href="{{ route('admin.contents.downloads.avatar') }}">Avatar settings</a></li>
            <li><a href="{{ route('admin.contents.private_messages') }}">Private message settings</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('default_theme') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.theme') }}">Default theme</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('board_settings') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.board_settings') }}">Board settings</a></li>
        </ul>
    </div>
    <div class="navigation-block">
        <div class="header">System</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('system_registry') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.system_registry') }}">System registry</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('php_info') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.php_info') }}">PHP information</a></li>
        </ul>
    </div>
</div>