<div class="navigation">
    <div class="navigation-block">
        <div class="header">General</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('posting') ?: 'left-navigation-active' }}"><a href="{{ route('admin.contents.posting') }}">Posting</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('threads') ?: 'left-navigation-active' }}"><a href="{{ route('admin.contents.threads') }}">Threads</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('private_messages') ?: 'left-navigation-active' }}"><a href="{{ route('admin.contents.private_messages') }}">Private Messages</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('moderation') ?: 'left-navigation-active' }}"><a href="{{ route('admin.contents.moderation') }}">Moderation</a></li>
        </ul>
    </div>
    <div class="navigation-block">
        <div class="header">Uploading</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('system_registry') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.system_registry') }}">System registry</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('php_info') ?: 'left-navigation-active' }}"><a href="{{ route('admin.general_settings.php_info') }}">PHP information</a></li>
        </ul>
    </div>
</div>