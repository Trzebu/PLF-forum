@include admin/partials/top
@include admin/contents/navigation

<div class="main">
    
    <h1>Uploading settings</h1>
    <p class="grey-text">Here is where you can change general uploading settings.</p>

    <form method="post" action="{{ route('admin.contents.downloads.settings') }}">
        <div class="fieldset">
            <div class="legend">Settings</div>

            @if (!is_writable(__ROOT__ . config('uploading/upload_dir'))):
                <div class="alert error">The entered path “{{ config('uploading/upload_dir') }}” is not writable.</div>
            @endif

            <dl>
                <dt>
                    <label for="uploaded_dir">Upload directory:</label>
                    <br>
                    <span>Storage path for downloads. Please note that if you change this directory while already having uploaded files you need to manually copy the files to their new location.</span>
                    @if ($this->errors->has("uploaded_dir")):
                        <br><span class="error">
                            {{ $this->errors->get("uploaded_dir")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="uploaded_dir" type="text" name="uploaded_dir" value="{{ config('uploading/upload_dir') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="min_file_size">Minimum file size:</label>
                    <br>
                    <span>Minimum size of each file.</span>
                    @if ($this->errors->has("min_file_size")):
                        <br><span class="error">
                            {{ $this->errors->get("min_file_size")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="min_file_size" type="number" name="min_file_size" value="{{ config('uploading/size/min') }}">
                </dd>
            </dl>

            <dl>
                <dt>
                    <label for="max_file_size">Maximum file size:</label>
                    <br>
                    <span>Maximum size of each file.</span>
                    @if ($this->errors->has("max_file_size")):
                        <br><span class="error">
                            {{ $this->errors->get("max_file_size")->first() }}
                        </span>
                    @endif
                </dt>
                <dd>
                    <input id="max_file_size" type="number" name="max_file_size" value="{{ config('uploading/size/max') }}">
                </dd>
            </dl>
        </div>
        <div class="fieldset">
            <div class="legend">{{ trans("buttons.set") }}</div>
            <p class="buttons">
                <input type="hidden" name="uploading_settings_token" value="{{ token('uploading_settings_token') }}">
                <input type="submit" class="button" value="{{ trans('buttons.set') }}">
                <input type="reset" class="button" value="Reset">
            </p>
        </div>
    </form>


</div>

@include admin/partials/bot