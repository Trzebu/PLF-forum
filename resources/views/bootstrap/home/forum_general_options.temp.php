@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">
    @if (Libs\Config::get("page/language/user_change")):
        <div class="col-12 text-center">
            <h4>Forum language:</h4>
        </div>
        <div class="col-12 border-bottom">
            <div class="form-group">
                <form method="post" action="{{ route('home.language.change') }}" class="form-vertical">
                    <select name="lang" class="form-control w-100">
                        <option selected>{{ trans("buttons.choose") }}...</option>
                        @foreach ($this->lang_packs as $key => $value):
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="lang_change_token" value="{{ $this->token->generate('lang_change_token') }}">
                    <div class="input-group-append">
                        <input type="submit" class="btn btn-success mx-auto d-block w-100 mt-10" value="{{ trans('buttons.change') }}">
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

@include partials/footer

