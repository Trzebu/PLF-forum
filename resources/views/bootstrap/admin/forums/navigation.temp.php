<div class="navigation">
    <div class="navigation-block">
        <div class="header">Manage Forums</div>
        <ul>
            <li class="{{ !Libs\Http\Request::inUrl('manage_forums') ?: 'left-navigation-active' }}"><a href="{{ route('admin.forums.manage_forums') }}">Manage Forums</a></li>
            <li class="{{ !Libs\Http\Request::inUrl('new_forum') ?: 'left-navigation-active' }}"><a href="{{ route('admin.forums.new_forum') }}">New forum</a></li>
        </ul>
    </div>
    <div class="navigation-block">
        <div class="header">Forum Based Permissions</div>
        <ul>
            <li><a href="">Forum Permissions</a></li>
            <li><a href="">Copy Forum Permissions</a></li>
            <li><a href="">Forum Moderators</a></li>
        </ul>
    </div>
</div>