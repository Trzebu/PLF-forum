@include partials/top

<h4>Login</h4>

<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" action="{{ route('auth.login') }}" method="post">
            <div class="form-group">
                <label for="username">{{ $this->translate->get('auth.username_or_email') }}:</label>
                <input type="text" name="username" id="username" class="form-control {{ $this->errors->has('username') ? 'is-invalid' : '' }}" value="{{ Libs\Http\Request::old('username') }}">
                @if ($this->errors->has("username")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("username")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="password">{{ $this->translate->get('auth.password') }}:</label>
                <input type="password" name="password" id="password" class="form-control {{ $this->errors->has('password') ? 'is-invalid' : '' }}" value="{{ Libs\Http\Request::old('password') }}">
                @if ($this->errors->has("password")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("password")->first() }}
                    </div>
                @endif
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> {{ $this->translate->get("auth.remember") }}
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">{{ $this->translate->get('buttons.login') }}!</button>
            </div>
            <input type="hidden" name="_token" value="{{ $this->token->generate('_token') }}">
        </form>
    </div>
</div>

@include partials/footer
