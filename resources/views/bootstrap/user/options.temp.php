@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">
    <div class="col-12 text-center">
        <h4>Base settings:</h4>
    </div>
    <div class="col-12 border-bottom">
        <form class="form-vertical" action="{{ route('auth.base_settings') }}" method="post">
            <div class="form-group">
                <label for="email">Your email adress:</label>
                <input type="email" name="email" id="email" class="form-control {{ $this->errors->has('email') ? 'is-invalid' : '' }}" value="{{ $this->errors->has('email') ? Libs\Http\Request::old('email') : $this->data->email }}">
                @if ($this->errors->has("email")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("email")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="old_password">Old password:</label>
                <input type="password" name="old_password" id="old_password" class="form-control {{ $this->errors->has('old_password') ? 'is-invalid' : '' }}">
                @if ($this->errors->has("old_password")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("old_password")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="new_password">New password:</label>
                <input type="password" name="new_password" id="new_password" class="form-control {{ $this->errors->has('new_password') ? 'is-invalid' : '' }}">
                @if ($this->errors->has("new_password")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("new_password")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="new_password_again">New password again:</label>
                <input type="password" name="new_password_again" id="new_password_again" class="form-control {{ $this->errors->has('new_password_again') ? 'is-invalid' : '' }}">
                @if ($this->errors->has("new_password_again")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("new_password_again")->first() }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="base_settings_token" value="{{ $this->token->generate('base_settings_token') }}">
            <div class="form-group">
                <button type="submit" class="btn btn-success mx-auto d-block w-100">{{ $this->translate->get('buttons.change') }}!</button>
            </div>
        </form>
    </div>
    <div class="col-12 text-center">
        Your signature:
    </div>
    <div class="col-12 border-bottom">
        @if (Auth()->permissions("signature")):
            <form method="post" action="{{ route('auth.options.signature') }}">
                <div class="form-group">
                    <label for="post">Write something nice:</label>
                    {? $textareaContent = $this->data->signature ?}
                    @if (config("user/auth/signature/contents/smilies")):
                        @include partials/smilies_block
                    @endif
                    @if (config("user/auth/signature/contents/bbcode")):
                        @include partials/post_bbcode_block
                    @else
                        @include partials/post_default_block
                    @endif
                </div>
                <input type="hidden" name="signature_user_token" value="{{ token('signature_user_token') }}">
                <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="{{ trans('buttons.save') }}">
            </form>
        @else
            <p class="small-grey-text">You have no permissions to use signature.</p>
        @endif
    </div>
    <div class="col-12 text-center">
        About You:
    </div>
    <div class="col-12 border-bottom">
        <form method="post" action="{{ route('auth.options.about_user') }}">
            <div class="form-group">
                <label for="post">Write something nice:</label>
                {? $textareaContent = $this->data->about ?}
                @if (config("user/auth/about/contents/smilies")):
                    @include partials/smilies_block
                @endif
                @if (config("user/auth/about/contents/bbcode")):
                    @include partials/post_bbcode_block
                @else
                    @include partials/post_default_block
                @endif
            </div>
            <input type="hidden" name="about_user_token" value="{{ token('about_user_token') }}">
            <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="{{ trans('buttons.save') }}">
        </form>
    </div>
    <div class="col-12 text-center">
        <h4>General settings:</h4>
    </div>
    <div class="col-12 border-bottom">
        <form class="form-vertical" action="{{ route('auth.general_settings') }}" method="post">
            <div class="form-group">
                <label for="full_name">Full name:</label>
                <input type="text" name="full_name" id="full_name" class="form-control {{ $this->errors->has('full_name') ? 'is-invalid' : '' }}" value="{{ $this->errors->has('full_name') ? Libs\Http\Request::old('full_name') : $this->data->full_name }}">
                @if ($this->errors->has("full_name")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("full_name")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" name="city" id="city" class="form-control {{ $this->errors->has('city') ? 'is-invalid' : '' }}" value="{{ $this->errors->has('city') ? Libs\Http\Request::old('city') : $this->data->city }}">
                @if ($this->errors->has("city")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("city")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="country">Your country:</label>
                <input type="text" name="country" id="country" class="form-control {{ $this->errors->has('country') ? 'is-invalid' : '' }}" value="{{ $this->errors->has('country') ? Libs\Http\Request::old('country') : $this->data->country }}">
                @if ($this->errors->has("country")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("country")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="www">Your WWW:</label>
                <input type="text" name="www" id="www" class="form-control {{ $this->errors->has('www') ? 'is-invalid' : '' }}" value="{{ $this->errors->has('www') ? Libs\Http\Request::old('www') : $this->data->www }}">
                @if ($this->errors->has("www")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("www")->first() }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="general_settings_token" value="{{ $this->token->generate('general_settings_token') }}">
            <div class="form-group">
                <button type="submit" class="btn btn-success mx-auto d-block w-100">{{ $this->translate->get('buttons.save') }}!</button>
            </div>
        </form>
    </div>
    <div class="col-12 text-center">
        <h4>Avatar:</h4>
    </div>
    <div class="col-12 border-bottom">
        <form action="{{ route('auth.change_avatar') }}" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" accept="image/*" class="custom-file-input {{ $this->errors->has('image') ? 'is-invalid' : '' }}" name="image" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ $this->translate->get('buttons.choose_image') }}</label>
                </div>
            </div>
            @if ($this->errors->has("image")):
                <p class="text-danger">{{ $this->errors->get("image")->first() }}</p>
            @endif
            <input type="hidden" name="avatar_change_token" value="{{ $this->token->generate('avatar_change_token') }}">
            <div class="form-group">
                <button type="submit" class="btn btn-success mx-auto d-block w-100">{{ trans('buttons.save') }}!</button>
            </div>
        </form>
        @if (Auth()->data()->avatar > 0):
            <p><a href="{{ route('auth.disable_avatar', ['token' => $this->token->generate('disable_avatar')]) }}">Disable current avatar</a></p>
        @endif
        <p><a href="{{ route('user_files.index') }}">Set avatar from uploaded files</a></p>
    </div>
</div>

<script type="text/javascript" src="{{ route('/') }}/public/app/js/showFileName.js"></script>

@include partials/footer
