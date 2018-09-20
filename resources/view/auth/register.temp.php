@include partials/top

<h4>Register your account</h4>

<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" action="{{ route('auth.register') }}" method="post">
            <div class="form-group">
                <label for="username">{{ $this->translate->get('auth.username') }}:</label>
                <input type="text" name="username" id="username" class="form-control {{ $this->errors->has('username') ? 'is-invalid' : '' }}" value="{{ Libs\Http\Request::old('username') }}">
                @if ($this->errors->has("username")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("username")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="email">{{ $this->translate->get('auth.email') }}:</label>
                <input type="email" name="email" id="email" class="form-control {{ $this->errors->has('email') ? 'is-invalid' : '' }}" value="{{ Libs\Http\Request::old('email') }}">
                @if ($this->errors->has("email")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("email")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="password">{{ $this->translate->get('auth.password') }}:</label>
                <input type="password" name="password" id="password" class="form-control {{ $this->errors->has('password') ? 'is-invalid' : '' }}">
                @if ($this->errors->has("password")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("password")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="password_again">{{ $this->translate->get('auth.password_again') }}:</label>
                <input type="password" name="password_again" id="password_again" class="form-control {{ $this->errors->has('password_again') ? 'is-invalid' : '' }}">
                @if ($this->errors->has("password_again")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("password_again")->first() }}
                    </div>
                @endif
            </div>
            <div class="checkbox {{ $this->errors->has('rule') ? 'is-invalid' : '' }}">
                <label>
                    <input type="checkbox" name="rule"> I accept rules
                </label>
                @if ($this->errors->has('rule')):
                    <p class="text-danger">{{ $this->errors->get('rule')->first() }}</p>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">{{ $this->translate->get('buttons.register') }}!</button>
            </div>
            <input type="hidden" name="_token" value="{{ $this->token->generate('_token') }}">
        </form>
    </div>
</div>

@include partials/footer
