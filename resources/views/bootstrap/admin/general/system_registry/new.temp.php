@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>Add new system registry</h1>
    <p class="grey-text">Here is where you can add new system registry. This options should be used only by developers!</p>
    
    <form method="post" action="{{ route('admin.general_settings.system_registry.new.post') }}">
        <div class="fieldset">
            <div class="legend">System registry parametrs</div>
            <dl>
                <dt>
                    <label for="registry_name">Registry name</label>
                    <br>
                    <span>This name will use in code.</span>
                    @if ($this->errors->has("registry_name")):
                        <br><span class="error">
                            {{ $this->errors->get("registry_name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="registry_name" type="text" name="registry_name">
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="registry_value">Registry value</label>
                    <br>
                    <span>Here you can set values for your registry.</span>
                    @if ($this->errors->has("value")):
                        <br><span class="error">
                            {{ $this->errors->get("value")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <textarea id="registry_value" name="value" style="width:300px;height:150px;"></textarea>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="registry_type">Registry type</label>
                    <br>
                    <span>Here you can set data type for your registry.</span>
                    @if ($this->errors->has("type")):
                        <br><span class="error">
                            {{ $this->errors->get("type")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="registry_type" name="type">
                        @foreach (trans('acp.registry_types') as $key => $value):
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">Registry permissions</div>
            <dl>
                <dt>
                    <label for="registry_name">Reading</label>
                    <br>
                    <span>Registry can be reading anywhere.</span>
                    @if ($this->errors->has("reading")):
                        <br><span class="error">
                            {{ $this->errors->get("reading")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="reading" class="radio" value="1">
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="reading" class="radio" value="0" checked="checked">
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="registry_name">Editing value</label>
                    <br>
                    <span>Registry value can be editing anywhere.</span>
                    @if ($this->errors->has("editing_value")):
                        <br><span class="error">
                            {{ $this->errors->get("editing_value")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="editing_value" class="radio" value="1">
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="editing_value" class="radio" value="0" checked="checked">
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="registry_name">Editing registry</label>
                    <br>
                    <span>Registry can be editing anywhere.</span>
                    @if ($this->errors->has("editing_registry")):
                        <br><span class="error">
                            {{ $this->errors->get("editing_registry")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="editing_registry" class="radio" value="1">
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="editing_registry" class="radio" value="0" checked="checked">
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">Add</div>
            <p class="buttons">
                <input type="hidden" name="registry_token" value="{{ $this->token->generate('registry_token') }}">
                <input type="submit" class="button" value="Add">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>

    </form>

</div>

@include admin/partials/bot