@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <form method="post" action="{{ $this->route }}">
        <div class="form-group">
            <label for="post">Edit your post:</label>
            {? $textareaContent = Libs\Http\Request::old("post") ? Libs\Http\Request::old("post") : $this->post->contents ?}
            @if (Libs\Config::get("posting/answers/bbcode")):
                @include partials/post_bbcode_block
            @else
                @include partials/post_default_block
            @endif
        </div>
        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
    </form>
</div>

@include partials/footer
