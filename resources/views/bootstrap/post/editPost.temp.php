@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <form method="post" action="{{ route('post.edit_send', ['postId' => $this->post->id]) }}">
        <div class="form-group">
            <label for="post">Edit your post:</label>
            <textarea name="post" id="post" class="form-control {{ $this->errors->has('post') ? 'is-invalid' : '' }} w-100 mb-10" style="height: 300px" placeholder="Type something...">{{ $this->post->contents }}</textarea>
            @if ($this->errors->has("post")):
                <div class="invalid-feedback">
                    {{ $this->errors->get("post")->first() }}
                </div>
            @endif
        </div>
        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
    </form>
</div>

@include partials/footer
