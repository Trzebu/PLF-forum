@include admin/partials/top
@include admin/permissions/navigation

<div class="main">
    <h1>Group settings :: {{ $this->data->name }}</h1>
    <p class="grey-text">Here is where you can edit permissions group.</p>

    <form method="post" action="{{ route('admin.permissions.groups.view.edit', ['id' => $this->data->id]) }}">
        <div class="fieldset">
            <div class="legend">Settings</div>
            <dl>
                <dt>
                    <label for="name">Group name</label>
                    <br>
                    <span>This name will use in forum as group name.</span>
                    @if ($this->errors->has("name")):
                        <br><span class="error">
                            {{ $this->errors->get("name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="name" type="text" name="name" value="{{ $this->data->name }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="color">Group color</label>
                    <br>
                    <span>Here you can set color for this group. Only english name or hex.</span>
                    @if ($this->errors->has("color")):
                        <br><span class="error">
                            {{ $this->errors->get("color")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="color" type="text" name="color" value="{{ $this->data->color }}">
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">Permissions</div>
            <dl>
                <dt>
                    <label for="color">Create new permission</label>
                </dt>
                <dd>
                    <a href="{{ route('admin.permissions.new') }}">{{ trans("buttons.create") }}</a>
                </dd>
            </dl>
            @foreach ($this->permissions as $key => $value):
                <dl>
                    <dt>
                        <label for="permissions">{{ !is_array(trans("permissions." . $key)) ? trans("permissions." . $key) : $key }}</label>
                        @if ($this->errors->has("permissions")):
                            <br><span class="error">
                                {{ $this->errors->get("permissions")->first() }}
                            </span>
                        @endif
                    </dt>
                    <dd>
                        <label>
                            <input type="radio" name="permissions[{{ $key }}]" class="radio" value="1" {{ $value == 1 ? 'checked="checked"' : "" }}>
                            {{ trans('buttons.yes') }}
                        </label>
                        <label>
                            <input type="radio" name="permissions[{{ $key }}]" class="radio" value="0" {{ $value == 0 ? 'checked="checked"' : "" }}>
                            {{ trans('buttons.no') }}
                        </label>
                    </dd>
                </dl>    
            @endforeach
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans('buttons.edit') }}</div>
            <p class="buttons">
                <input type="hidden" name="edit_group_token" value="{{ $this->token->generate('edit_group_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.edit') }}">
                <input type="reset" class="button" value="{{ trans('buttons.reset') }}">
            </p>
        </div>
    </form>

    <div class="fieldset">
        <div class="legend">Additional tools</div>
        <form method="post" action="{{ route('admin.permissions.groups.change_users_group.by_other_group', ['id' => $this->data->id]) }}">
            <dl>
                <dt>
                    <label for="group">Set by other group</label>
                    <br>
                    <span>Here you can set this group for users with selected group.</span>
                    @if ($this->errors->has("group")):
                        <br><span class="error">
                            {{ $this->errors->get("group")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="group" name="group">
                        @foreach ($this->groups as $group):
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </dd>
                <dd>
                    <input type="hidden" name="change_groups_by_other_token" value="{{ token('change_groups_by_other_token') }}">
                    <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                </dd>
            </dl>
        </form>
        <dl>
            <dt>
                <label for="color">Delete this group</label>
            </dt>
            <dd>
                <a href="{{ route('admin.permissions.groups.delete', ['id' => $this->data->id, 'token' => token('delete_group_token')]) }}">{{ trans("buttons.delete") }}</a>
            </dd>
        </dl>
    </div>

</div>

@include admin/partials/bot