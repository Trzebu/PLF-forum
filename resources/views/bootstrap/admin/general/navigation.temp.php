<div class="navigation">
    <div class="navigation-block">
        <div class="header">Quick access</div>
        <ul>
            <li><a href="">Manage users</a></li>
            <li><a href="">Manage groups</a></li>
            <li><a href="">Manage forums</a></li>
            <li><a href="">Moderator log</a></li>
        </ul>
    </div>
    <div class="navigation-block">
        <div class="header">Board configuration</div>
        <ul>
            <li><a href="">Attachment settings</a></li>
            <li><a href="">Board settings</a></li>
            <li><a href="">Board features</a></li>
            <li><a href="">Avatar settings</a></li>
            <li><a href="">Private message settings</a></li>
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