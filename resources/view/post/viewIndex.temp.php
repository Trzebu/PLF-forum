@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

    @if ($this->parent_post !== null):
        <h4>{{ $this->parent_post->subject }}</h4>

        <div class="row border border-primary rounded mt-10 mb-10" style="background-color: #cccccc">
            <div class="col-10">
                <h6 style="color: blue">{{ $this->parent_post->subject }}</h6>
                {{ strip_tags($this->parent_post->contents) }}
            </div>
            <div class="col-2">
                <p class="small-grey-text">Nick: {{ $this->user->username($this->parent_post->user_id) }}</p>
                <p class="small-grey-text">{{ $this->user->permissions($this->parent_post->user_id)->name }}</p>
            </div>
        </div>

        @if ($this->answers !== null):

            @foreach ($this->answers as $answer):

                <div class="row border border-primary rounded mt-10 mb-10">
                    <div class="col-10">
                        <h6 style="color: blue">Re: {{ $this->parent_post->subject }}</h6>
                        {{ strip_tags($answer->contents) }}
                    </div>
                    <div class="col-2">
                        <p class="small-grey-text">Nick: {{ $this->user->username($answer->user_id) }}</p>
                        <p class="small-grey-text">{{ $this->user->permissions($answer->user_id)->name }}</p>
                    </div>
                </div>

            @endforeach

        @else
            <h3>It seems that no one answered in this thread, be first!</h3>
        @endif

    @else
        <h3>Sorry, but looks like this subject doesn't exist!</h3>
    @endif

</div>

@include partials/footer
