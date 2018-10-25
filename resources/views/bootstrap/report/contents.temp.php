@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">
    <p class="small-grey-text">Content id: {{ $this->data->id }}</p>
    @if (isset($this->data->subject)):
        @if (strlen($this->data->subject) > 0):
            <p class="small-grey-text">Subject name: {{ $this->data->subject }}</p>
        @else
            <p class="small-grey-text">Answer: #post_{{ $this->data->id }}</p>
        @endif
    @elseif (isset($this->data->original_name)):
        <p class="small-grey-text">File name: {{ $this->data->original_name }}</p>
    @elseif (isset($this->data->username)):
        <p class="small-grey-text">profile.id.{{ $this->data->id }}.username.{{ $this->data->username }}</p>
    @endif

    <p class="small-grey-text">Created by: {{ $this->user->username(isset($this->data->user_id) ? $this->data->user_id : $this->data->id) }}</p>
    <form method="post" action="{{ route('report.contents_post', ['id' => $this->data->id, 'contents' => $this->contents]) }}">
        <div class="form-group">
            <label for="post">Report reason:</label>
            <textarea name="post" id="post" class="form-control {{ $this->errors->has('post') ? 'is-invalid' : '' }} w-100 mb-10" style="height: 300px" placeholder="Type something..."></textarea>
            @if ($this->errors->has("post")):
                <div class="invalid-feedback">
                    {{ $this->errors->get("post")->first() }}
                </div>
            @endif
        </div>
        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Report">
    </form>
</div>

@include partials/footer
