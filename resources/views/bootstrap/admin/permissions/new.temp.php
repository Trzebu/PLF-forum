@include admin/partials/top
@include admin/permissions/navigation

<div class="main">
    <h1>Create new permission</h1>
    <p class="grey-text">Here is where you can create new system permission. This can be used to create permission to managing forums for example.</p>

    <form method="post" action="">
        <div class="fieldset">
            <div class="legend">Permission parametrs</div>
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
                    <input id="name" type="text" name="name" placeholder="example_name">
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="setted">Set this for all group</label>
                    <br>
                    <span>If you set yes this new permission will be setted as for all groups!</span>
                    @if ($this->errors->has("setted")):
                        <br><span class="error">
                            {{ $this->errors->get("setted")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="setted" class="radio" value="1">
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="setted" class="radio" value="0" checked="checked">
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>    
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans('buttons.add') }}</div>
            <p class="buttons">
                <input type="hidden" name="add_permission_token" value="{{ $this->token->generate('add_permission_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.add') }}">
                <input type="reset" class="button" value="{{ trans('buttons.reset') }}">
            </p>
        </div>
    </form>    

</div>

@include admin/partials/bot