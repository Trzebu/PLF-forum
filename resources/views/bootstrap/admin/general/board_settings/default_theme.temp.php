@include admin/partials/top
@include admin/general/navigation

<div class="main">
    <h1>Default theme</h1>
    <p class="grey-text">Here you can change default forum theme. All themes are located in "resources/views".</p>
    
    <div class="fieldset">
        <div class="legend">{{ trans("buttons.settings") }}</div>
        
        <form method="post" action="{{ route('admin.general_settings.theme') }}">
            <dl>
                <dt>
                    <label for="theme">Themes</label>
                    <br><span>In location "resources/views" you can install new themes.</span>
                    @if ($this->errors->has("theme")):
                        <br><span class="error">
                            {{ $this->errors->get("theme")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <select id="theme" name="theme">
                        @foreach (scandir(__ROOT__ . "/resources/views") as $dir):
                            @if (strpos($dir, ".") !== false):
                                {? continue ?}
                            @endif
                            @if (config("forum/theme/default_theme") == $dir):
                                <option value="{{ $dir }}" selected>{{ $dir }}</option>
                            @else
                                <option value="{{ $dir }}">{{ $dir }}</option>
                            @endif
                        @endforeach
                    </select>
                </dd>
                <dd>
                    <input type="hidden" name="set_theme_token" value="{{ token('set_theme_token') }}">
                    <input type="submit" value="{{ trans('buttons.set') }}">
                </dd>
            </dl>
        </form>
    </div>

</div>

@include admin/partials/bot