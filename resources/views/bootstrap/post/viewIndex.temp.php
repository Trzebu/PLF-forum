@include partials/top

<div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

    @if ($this->parent_post !== null):
        <h4>{{ $this->parent_post->subject }}</h4>

        <div id="post_{{ $this->parent_post->id }}" class="row border border-primary rounded mt-10 mb-10" style="background-color: #cccccc">
            <div class="col-10">
                <h6 style="color: blue">{{ $this->parent_post->subject }}</h6>
                <p class="small-grey-text">Created at: {{ $this->postObj->dateTimeAlphaMonth($this->parent_post->created_at, config('post/contents/date/short_notation')) }}</p>
                @if ($this->parent_post->created_at != $this->parent_post->updated_at):
                    <p class="small-grey-text">Edited at: {{ $this->parent_post->updated_at }}</p>
                @endif
                {? $content = $this->parent_post->contents ?}
            
                @if (config("posting/bbcode")):
                    {? $this->bb->parse($content, false) ?}
                    {? $content = $this->bb->getHtml() ?}
                @endif

                @if (config("posting/smilies")):
                    {? $content = Libs\Smilies::parse($content) ?}
                @endif

                {{ $content }}

                @if ($this->user->signature($this->parent_post->user_id)):
                    <hr>
                    {{ $this->user->signature($this->parent_post->user_id) }}
                @endif
            </div>
            <div class="col-2 mt-10 mb-10">
                <div class="media">
                    <img class="media-object mr-3 rounded avatar_thumb" src="{{ $this->user->getAvatar($this->parent_post->user_id) }}" alt="{{ strip_tags($this->user->username($this->parent_post->user_id)) }}">
                </div>
                <p class="small-grey-text">Nick: <a href="{{ route('profile.index_by_id', ['id' => $this->parent_post->user_id]) }}">{{ $this->user->username($this->parent_post->user_id) }}</a></p>
                <p class="small-grey-text">Posts: <b>{{ $this->user->calcPosts($this->parent_post->user_id) }}</b></p>
                <p class="small-grey-text">Reputation: <b>{{ $this->user->calcReputation($this->parent_post->user_id) }}</b></p>
                <p class="small-grey-text">{{ $this->user->permissions($this->parent_post->user_id)->name }}</p>
                <div class="col">
                    @if (Auth()->check()):

                        @if ($this->hasPermissions || ($this->parent_post->user_id == Auth()->data()->id && $this->parent_post->status != 1)):
                            <div class="col">
                                <a href="{{ route('post.edit.answer', ['section' => $this->section_id, 'category' => $this->category_id, 'postId' => $this->parent_post->id, 'postId' => $this->parent_post->id]) }}">Edit</a>
                            </div>
                        @endif

                        <a href="{{ route('vote.give', ['type' => 'up', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $this->parent_post->id, 'token' => $this->urlToken]) }}" title="Give vote up!">
                            <img class="{{ $this->vote->checkGivenVoteType($this->parent_post->id) == '1' ? 'border border-primary rounded bg-green' : '' }}" src="{{ route('/') }}/public/app/img/vote_up.png">
                        </a>
                        <a href="{{ route('vote.give', ['type' => 'down', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $this->parent_post->id, 'token' => $this->urlToken]) }}" title="Give vote down!">
                            <img class="{{ $this->vote->checkGivenVoteType($this->parent_post->id) == '0' ? 'border border-primary rounded bg-red' : '' }}" src="{{ route('/') }}/public/app/img/vote_down.png">
                        </a>
                    @endif
                    <p>
                        Votes: 
                        @if ($this->vote->calcVotes($this->parent_post->id) == 0):
                            0
                        @elseif ($this->vote->calcVotes($this->parent_post->id) > 0):
                            <font color="green">+{{ $this->vote->calcVotes($this->parent_post->id) }}</font>
                        @else
                            <font color="red">{{ $this->vote->calcVotes($this->parent_post->id) }}</font>
                        @endif
                    </p>
                </div>

                @if (Auth()->check()):
                    <a href="{{ route('report.contents', ['id' => $this->parent_post->id, 'contents' => 'post', 'token' => $this->reportToken]) }}">Report this thread!</a>
                @endif

            </div>
        </div>

        @if ($this->postObj->getAnswers($this->parent_post->id) !== null):

            @foreach ($this->postObj->getAnswers($this->parent_post->id) as $answer):

                <div id="post_{{ $answer->id }}" class="row border border-primary rounded mt-10 mb-10">
                    <div class="col-10">
                        <h6 style="color: blue">Re: {{ $this->parent_post->subject }}</h6>
                        <p class="small-grey-text">Created at: {{ $this->postObj->dateTimeAlphaMonth($answer->created_at, config('post/contents/date/short_notation')) }}</p>
                        @if ($answer->created_at != $answer->updated_at):
                            <p class="small-grey-text">Edited at: {{ $answer->updated_at }}</p>
                        @endif
                        {? $this->bb->parse($answer->contents, false) ?}
                        @if ($answer->status == 1):
                            <font  color="red"><h4>This answer has been deleted by moderator!</h4></font>
                            @if ($this->hasPermissions):
                                @if (config("posting/answers/bbcode")):
                                    {{ $this->bb->getHtml() }}
                                @else
                                    {{ $answer->contents }}
                                @endif
                            @endif
                        @else
                            {? $content = $answer->contents ?}
            
                            @if (config("posting/answer/bbcode")):
                                {? $this->bb->parse($content, false) ?}
                                {? $content = $this->bb->getHtml() ?}
                            @endif

                            @if (config("posting/answers/smilies")):
                                {? $content = Libs\Smilies::parse($content) ?}
                            @endif

                            {{ $content }}
                        @endif
                        @if ($this->user->signature($answer->user_id)):
                            <hr>
                            {{ $this->user->signature($answer->user_id) }}
                        @endif
                    </div>
                    <div class="col-2 mt-10 mb-10">
                        <div class="media">
                            <img class="media-object mr-3 rounded avatar_thumb" src="{{ $this->user->getAvatar($answer->user_id) }}" alt="{{ strip_tags($this->user->username($answer->user_id)) }}">
                        </div>
                        <p class="small-grey-text">
                            {{ $answer->user_id == $this->parent_post->user_id ? 'Nick (OP)' : 'Nick' }}: <a href="{{ route('profile.index_by_id', ['id' => $answer->user_id]) }}">{{ $this->user->username($answer->user_id) }}</a>
                        </p>
                        <p class="small-grey-text">Posts: <b>{{ $this->user->calcPosts($answer->user_id) }}</b></p>
                        <p class="small-grey-text">Reputation: <b>{{ $this->user->calcReputation($answer->user_id) }}</b></p>
                        <p class="small-grey-text">{{ $this->user->permissions($answer->user_id)->name }}</p>
                        <div class="col">
                            @if (Auth()->check()):
                                <div class="col">
                                    @if ($this->hasPermissions || ($answer->user_id == Auth()->data()->id && $this->parent_post->status != 1)):
                                        <a href="{{ route('post.edit.answer', ['section' => $this->section_id, 'category' => $this->category_id, 'postId' => $answer->id, 'token' => $this->urlToken]) }}">Edit</a>
                                    @else
                                        <a href="{{ route('report.contents', ['id' => $answer->id, 'contents' => 'post', 'token' => $this->reportToken]) }}">Report this answer!</a>
                                    @endif
                                </div>

                                <a href="{{ route('vote.give', ['type' => 'up', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $answer->id, 'token' => $this->urlToken]) }}" title="Give vote up!">
                                    <img class="{{ $this->vote->checkGivenVoteType($answer->id) == '1' ? 'border border-primary rounded bg-green' : '' }}" src="{{ route('/') }}/public/app/img/vote_up.png">
                                </a>
                                <a href="{{ route('vote.give', ['type' => 'down', 'sectionId' => $this->section_id, 'categoryId' => $this->category_id, 'parentPostId' => $this->parent_post->id, 'postId' => $answer->id, 'token' => $this->urlToken]) }}" title="Give vote down!">
                                    <img class="{{ $this->vote->checkGivenVoteType($answer->id) == '0' ? 'border border-primary rounded bg-red' : '' }}" src="{{ route('/') }}/public/app/img/vote_down.png">
                                </a>
                            @endif
                            <p>Votes:
                                <?php $voteAmount = $this->vote->calcVotes($answer->id); ?>
                                @if ($voteAmount == 0):
                                    0
                                @elseif ($voteAmount > 0):
                                    <font color="green">+{{ $voteAmount }}</font>
                                @else
                                    <font color="red">{{ $voteAmount }}</font>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

            @endforeach

            {{ $this->postObj->paginateRender() }}

        @else
            <h3>It seems that no one answered in this thread, be first!</h3>
        @endif

        @if (strlen($this->threadBlockedReason) == 0 || $this->hasPermissions):
            <form method="post" action="{{ route('post.add_answer', ['sectionName' => $this->section_id, 'categoryId' => $this->category_id, 'postId' => $this->parent_post->id]) }}">
                <div class="form-group">
                    <label for="post">Your answer:</label>
                    @if (config("posting/answers/smilies")):
                        @include partials/smilies_block
                    @endif
                    @if (config("posting/answers/bbcode")):
                        @include partials/post_bbcode_block
                    @else
                        @include partials/post_default_block
                    @endif
                </div>
                <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
                <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
            </form>
        @else
            <h5><font color="red">{{ $this->threadBlockedReason }}</font></h5>
        @endif

    @else
        <h3>Sorry, but looks like this subject doesn't exist!</h3>
    @endif

</div>

@include partials/footer
