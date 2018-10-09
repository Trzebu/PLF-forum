@include admin/partials/top
@include admin/forums/navigation

<div class="main">
    
    <h1>{{ trans("acp.new_forum") }} :: {{ $this->name }}</h1>
    <p class="grey-text">{{ trans("acp.new_forum_description") }}.</p>    

    <form method="" action="">

        <div class="fieldset">
            <div class="legend">{{ trans("general.forum_settings") }}</div>
            <dl>
                <dt>
                    <label for="parent">{{ trans("acp.parent_forum") }}:</label>
                    @if ($this->errors->has("parent")):
                        <br><span class="error">
                            {{ $this->errors->get("parent")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="parent" name="parent">
                        <option value="0">{{ trans("acp.no_parent") }}</option>
                        @foreach ($this->section->getSections() as $section):
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="forum_name">{{ trans("general.forum_name") }}:</label>
                    @if ($this->errors->has("forum_name")):
                        <br><span class="error">
                            {{ $this->errors->get("forum_name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="forum_name" type="text" name="forum_name">
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="forum_description">{{ trans('general.forum_description') }}:</label>
                    <br>
                    <span>{{ trans("acp.forum_description") }}</span>
                    @if ($this->errors->has("forum_description")):
                        <br><span class="error">
                            {{ $this->errors->get("forum_description")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <textarea id="forum_description" name="forum_description" style="width:300px;height:150px;"></textarea>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="password">{{ trans("general.forum_password") }}:</label>
                    <br><span>{{ trans("acp.forum_password") }}</span>
                    @if ($this->errors->has("password")):
                        <br><span class="error">
                            {{ $this->errors->get("password")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="password" type="password" name="password">
                </dd>
            </dl>
            <dl>
                <dt>
                    <label for="password_again">{{ trans("auth.password_again") }}:</label>
                    <br><span>{{ trans("acp.forum_password_again") }}</span>
                    @if ($this->errors->has("password_again")):
                        <br><span class="error">
                            {{ $this->errors->get("password_again")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="password_again" type="password" name="password_again">
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans("general.forum_settings_generel") }}</div>
            <dl>
                <dt>
                    <label for="status">Status</label>
                    @if ($this->errors->has("status")):
                        <br><span class="error">
                            {{ $this->errors->get("status")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="status" name="status">
                        @foreach (trans("acp.forum_status") as $key => $value):
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </dd>
            </dl>
        </div>

        <div class="fieldset">
            <div class="legend">{{ trans("general.permissions") }}</div>
            @foreach ($this->permissions->translated() as $key => $value):
                <dl>
                    <dt>
                        <label for="">{{ $value }}</label>
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

    </form>

</div>

@include admin/partials/bot