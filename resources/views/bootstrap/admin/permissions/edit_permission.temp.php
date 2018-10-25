@include admin/partials/top
@include admin/permissions/navigation

<div class="main">
    <h1>Edit permission :: {{ $this->permission_name }}</h1>
    <p class="grey-text">Here is where you can edit permission.</p>

    <div class="fieldset">
        <div class="legend">{{ trans("buttons.edit") }}</div>

        <form method="post" action="{{ route('admin.permissions.edit_permission', ['name' => $this->permission_name]) }}">
            <dl>
                <dt>
                    <label for="name">Permission name</label>
                    <br>
                    <span>This name will use in system code.</span>
                    @if ($this->errors->has("name")):
                        <br><span class="error">
                            {{ $this->errors->get("name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="name" type="text" name="name" value="{{ $this->permission_name }}">
                </dd>
                <dd>
                    <input type="hidden" name="edit_permission_token" value="{{ token('edit_permission_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.edit') }}">
                </dd>
            </dl>
        </form>

        <dl>
            <dt>
                <label for="name">{{ trans("buttons.delete") }}</label>
                <br>
                <span>Delete this permission.</span>
                @if ($this->errors->has("name")):
                    <br><span class="error">
                        {{ $this->errors->get("name")->first() }}
                    </span>
                @endif
            </dt>
            <dd>
                <a href="{{ route('admin.permissions.delete_permission', ['name' => $this->permission_name, 'token' => token('delete_permission_token')]) }}">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>
    </div>

</div>

@include admin/partials/bot