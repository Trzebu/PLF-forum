@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

    @if ($this->parent_post !== null):
        <h4>{{ $this->parent_post->subject }}</h4>

        <div id="post_{{ $this->parent_post->id }}" class="row border border-primary rounded mt-10 mb-10" style="background-color: #cccccc">
            <div class="col-10">
                <h6 style="color: blue">{{ $this->parent_post->subject }}</h6>
                {{ strip_tags($this->parent_post->contents) }}
            </div>
            <div class="col-2 mt-10 mb-10">
                <div class="media">
                    <img class="media-object mr-3 rounded avatar_thumb" src="{{ $this->user->getAvatar($this->parent_post->user_id) }}" alt="{{ strip_tags($this->user->username($this->parent_post->user_id)) }}">
                </div>
                <p class="small-grey-text">Nick: {{ $this->user->username($this->parent_post->user_id) }}</p>
                <p class="small-grey-text">{{ $this->user->permissions($this->parent_post->user_id)->name }}</p>
                <div class="col">
                    <a href="{{ route('vote.give', ['type' => 'up', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $this->parent_post->id, 'token' => $this->urlToken]) }}" title="Give vote up!">
                        <img class="{{ $this->vote->checkGivenVoteType($this->parent_post->id) == '1' ? 'border border-primary rounded bg-green' : '' }}" src="{{ route('/') }}/public/app/img/vote_up.png">
                    </a>
                    <a href="{{ route('vote.give', ['type' => 'down', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $this->parent_post->id, 'token' => $this->urlToken]) }}" title="Give vote down!">
                        <img class="{{ $this->vote->checkGivenVoteType($this->parent_post->id) == '0' ? 'border border-primary rounded bg-red' : '' }}" src="{{ route('/') }}/public/app/img/vote_down.png">
                    </a>
                    <p>Votes: 
                        @if ($this->vote->calcVotes($this->parent_post->id) == 0):
                            0
                        @elseif ($this->vote->calcVotes($this->parent_post->id) > 0):
                            <font color="green">+{{ $this->vote->calcVotes($this->parent_post->id) }}</font>
                        @else
                            <font color="red">{{ $this->vote->calcVotes($this->parent_post->id) }}</font>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if ($this->answers !== null):

            @foreach ($this->answers as $answer):

                <div id="post_{{ $answer->id }}" class="row border border-primary rounded mt-10 mb-10">
                    <div class="col-10">
                        <h6 style="color: blue">Re: {{ $this->parent_post->subject }}</h6>
                        {{ strip_tags($answer->contents) }}
                    </div>
                    <div class="col-2 mt-10 mb-10">
                        <div class="media">
                            <img class="media-object mr-3 rounded avatar_thumb" src="{{ $this->user->getAvatar($answer->user_id) }}" alt="{{ strip_tags($this->user->username($answer->user_id)) }}">
                        </div>
                        <p class="small-grey-text">Nick: {{ $this->user->username($answer->user_id) }}</p>
                        <p class="small-grey-text">{{ $this->user->permissions($answer->user_id)->name }}</p>
                        <div class="col">
                            <a href="{{ route('vote.give', ['type' => 'up', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $answer->id, 'token' => $this->urlToken]) }}" title="Give vote up!">
                                <img class="{{ $this->vote->checkGivenVoteType($answer->id) == '1' ? 'border border-primary rounded bg-green' : '' }}" src="{{ route('/') }}/public/app/img/vote_up.png">
                            </a>
                            <a href="{{ route('vote.give', ['type' => 'down', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $answer->id, 'token' => $this->urlToken]) }}" title="Give vote down!">
                                <img class="{{ $this->vote->checkGivenVoteType($answer->id) == '0' ? 'border border-primary rounded bg-red' : '' }}" src="{{ route('/') }}/public/app/img/vote_down.png">
                            </a>
                            <p>Votes: 
                                @if ($this->vote->calcVotes($answer->id) == 0):
                                    0
                                @elseif ($this->vote->calcVotes($answer->id) > 0):
                                    <font color="green">+{{ $this->vote->calcVotes($answer->id) }}</font>
                                @else
                                    <font color="red">{{ $this->vote->calcVotes($answer->id) }}</font>
                                @endif
                            </p>
                        </div>
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