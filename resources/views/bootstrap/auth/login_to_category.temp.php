@include partials/top

<h4>Login to category</h4>

<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" action="{{ route('section.login.post', ['sectionName' => $this->data->parent, 'categoryId' => $this->data->id]) }}" method="post">
            <div class="form-group">
                <label for="password">{{ $this->translate->get('auth.password') }}:</label>
                <input type="password" name="password" id="password" class="form-control {{ $this->errors->has('password') ? 'is-invalid' : '' }}" value="{{ Libs\Http\Request::old('password') }}">
                @if ($this->errors->has("password")):
                    <div class="invalid-feedback">
                        {{ $this->errors->get("password")->first() }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">{{ $this->translate->get('buttons.login') }}!</button>
            </div>
            <input type="hidden" name="login_to_category_token" value="{{ $this->token->generate('login_to_category_token') }}">
        </form>
    </div>
</div>

@include partials/footer
