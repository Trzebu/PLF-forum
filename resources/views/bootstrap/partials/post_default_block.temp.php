<p class="small-grey-text">BbCode: Off</p>

<textarea name="post" id="post" class="form-control {{ $this->errors->has('post') ? 'is-invalid' : '' }} w-100 mb-10" style="height: 300px" placeholder="Type something...">{{ isset($textareaContent) ? $textareaContent : "" }}</textarea>
@if ($this->errors->has("post")):
    <div class="invalid-feedback">
        {{ $this->errors->get("post")->first() }}
    </div>
@endif