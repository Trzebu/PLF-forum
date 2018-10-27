@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>Board settings</h1>
    <p class="grey-text">Here you can change default board settings.</p>
    
    <div class="fieldset">
        <div class="legend">{{ trans("buttons.settings") }}</div>
        
        <form method="post" action="{{ route('admin.general_settings.board_settings') }}">
            <dl>
                <dt>
                    <label for="name">Board name:</label>
                    <br>
                    <span>This name is general name for your board.</span>
                    @if ($this->errors->has("name")):
                        <br><span class="error">
                            {{ $this->errors->get("name")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="name" type="text" name="name" value="{{ config('page/contents/title') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="lang">Default board language:</label>
                    <br><span>In location "resources/lang" you can install new language packages.</span>
                    @if ($this->errors->has("lang")):
                        <br><span class="error">
                            {{ $this->errors->get("lang")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="lang" name="lang">
                        @foreach ($this->lang_packs as $key => $value):
                            @if (config("page/language/default") == $key):
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="user_lang">Users language:</label>
                    <br>
                    <span>Whether users can changes language?</span>
                    @if ($this->errors->has("user_lang")):
                        <br><span class="error">
                            {{ $this->errors->get("user_lang")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <label>
                        <input type="radio" name="user_lang" class="radio" value="0" {{ !config("page/general_options/hidden") ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="user_lang" class="radio" value="1" {{ config("page/general_options/hidden") ? 'checked="checked"' : "" }}>
                        {{ trans('buttons.no') }}
                    </label>
                </dd>
            </dl>
            <p class="buttons">
                <input type="hidden" name="board_settings_token" value="{{ $this->token->generate('board_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.change') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </form>
    </div>

</div>

@include admin/partials/bot