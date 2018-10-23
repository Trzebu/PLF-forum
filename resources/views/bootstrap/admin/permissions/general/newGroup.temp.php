@include admin/partials/top
@include admin/permissions/navigation

<div class="main">
    <h1>New group</h1>
    <p class="grey-text">Here is where you can add new permissions group.</p>

    <form method="post" action="{{ route('admin.permissions.groups.new') }}">
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
                    <input id="name" type="text" name="name">
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
                    <input id="color" type="text" name="color" value="black">
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">Permissions</div>
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
                            <input type="radio" name="permissions[{{ $key }}]" class="radio" value="1">
                            {{ trans('buttons.yes') }}
                        </label>
                        <label>
                            <input type="radio" name="permissions[{{ $key }}]" class="radio" value="0" checked="checked">
                            {{ trans('buttons.no') }}
                        </label>
                    </dd>
                </dl>    
            @endforeach
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans('buttons.add') }}</div>
            <p class="buttons">
                <input type="hidden" name="add_group_token" value="{{ $this->token->generate('add_group_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.add') }}">
                <input type="reset" class="button" value="{{ trans('buttons.reset') }}">
            </p>
        </div>
    </form>

</div>

@include admin/partials/bot