<div class="navigation">
    <div class="navigation-block">
        <div class="header">Manage Forums</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('manage_forums') ?: 'left-navigation-active' }}"><a href="{{ route('admin.forums.manage_forums') }}">Manage Forums</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('new_forum') ?: 'left-navigation-active' }}"><a href="{{ route('admin.forums.new_forum') }}">New forum</a></li>
        </ul>
    </div>
    <div class="navigation-block">
        <div class="header">Forums settings</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('settings') ?: 'left-navigation-active' }}"><a href="{{ route('admin.forums.settings.view') }}">{{ trans("general.general_settings") }}</a></li>
        </ul>
    </div>
</div>