<script type="text/javascript" src="{{ route('/') }}/public/app/js/bbcode.js"></script>

<p class="small-grey-text">BbCode: On</p>

<div class="col border rounded mb-10 bbcode" style="background-color: white">
    <i class="fas fa-bold" title="{{ trans('bbcode.bold') }}" onclick="replace('bold')"></i>
    <i class="fas fa-italic" title="{{ trans('bbcode.italica') }}" onclick="replace('italic')"></i>
    <i class="fas fa-underline" title="{{ trans('bbcode.underline') }}" onclick="replace('underline')"></i>
    <i class="fas fa-strikethrough" title="{{ trans('bbcode.strikethrough') }}" onclick="replace('strikethrough')"></i>
    <i class="fas fa-text-width" title="{{ trans('bbcode.size') }}" onclick="replace('size')"></i>
    <i class="fas fa-align-center" title="{{ trans('bbcode.center') }}" onclick="replace('center')"></i>
    <i class="fas fa-link" title="{{ trans('bbcode.link') }}" onclick="replace('link')"></i>
    <i class="fas fa-quote-left" title="{{ trans('bbcode.quote') }}" onclick="replace('quote')"></i>
    <i class="fas fa-code" title="{{ trans('bbcode.code') }}" onclick="replace('code')"></i>
    <i class="fas fa-images" title="{{ trans('bbcode.image') }}" onclick="replace('image')"></i>
    <i class="fas fa-list-ul" title="{{ trans('bbcode.list-ul') }}" onclick="replace('list-ul')"></i>
    <i class="fas fa-list-ol" title="{{ trans('bbcode.list-ol') }}" onclick="replace('list-ol')"></i>
    <i class="fas fa-palette" title="{{ trans('bbcode.color') }}" onclick="replace('color')"></i>
    <i class="fab fa-youtube" title="{{ trans('bbcode.youtube') }}" onclick="replace('youtube')"></i>
</div>

<textarea name="post" id="post" class="form-control {{ $this->errors->has('post') ? 'is-invalid' : '' }} w-100 mb-10" style="height: 300px" placeholder="Type something...">{{ isset($textareaContent) ? $textareaContent : "" }}</textarea>
@if ($this->errors->has("post")):
    <div class="invalid-feedback">
        {{ $this->errors->get("post")->first() }}
    </div>
@endif
