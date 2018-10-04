@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">
    <div class="col-12 border-bottom">
        <h4>All about {{ $this->user->username($this->data->id) }}</h4>
    </div>
    <div class="col-12 row">
        <div class="col">
            <div class="media mt-10 mb-10">
                <img class="profile_avatar" src="{{ $this->user->getAvatar($this->data->id, 160) }}" alt="{{ $this->data->username }}">
            </div>
        </div>
        <div class="col">
            <h4>{{ $this->user->username($this->data->id) }}</h4>
            <p class="small-grey-text">Rank: <font color="{{ $this->user->permissions($this->data->id)->color }}">{{ $this->user->permissions($this->data->id)->name }}</font></p>
            <p class="small-grey-text">Registered from: {{ $this->user->diffToHuman($this->data->created_at) }} ({{ $this->user->dateTimeAlphaMonth($this->data->created_at, true) }})</p>
            <p class="small-grey-text">{{ $this->user->online($this->data->updated_at) }}</p>
            <p class="small-grey-text">Threads: {{ $this->threads }}</p>
            <p class="small-grey-text">Answers: {{ $this->answers }}</p>
            <p class="small-grey-text">Casted votes: {{ $this->user->calcGivenVotes($this->data->id) }}</p>
            <p class="small-grey-text">Reputation: {{ $this->user->calcReputation($this->data->id) }}</p>
        </div>
        <div class="col">
            <h4>Permissions</h4>
            @foreach ($this->user->allPermissions($this->data->id) as $perm):
                <p class="small-grey-text">{{ $this->translate->get("permissions." . $perm) }}</p>
            @endforeach
        </div>
        <div class="col">
            <h5>Basic information</h5>
            <p class="small-grey-text">Name: {{ strlen($this->data->full_name) > 0 ? $this->data->full_name : 'hidden' }}</p>
            <p class="small-grey-text">City: {{ strlen($this->data->city) > 0 ? $this->data->city : 'hidden' }}</p>
            <p class="small-grey-text">From: {{ strlen($this->data->country) > 0 ? $this->data->country : 'hidden' }}</p>
            <p class="small-grey-text">WWW: {{ strlen($this->data->www) > 0 ? '<a href="' . $this->data->www . '" target="_blank">' . $this->data->www . '</a>' : 'hidden' }}</p>
        </div>
    </div>
    <div class="col-12 text-center border-bottom">
        <h5>About {{ $this->data->username }}:</h5>
    </div>
    <div class="col-12 border-bottom">
        @if ($this->about !== null):
            {{ $this->about }}
        @else
            {{ $this->data->username }} has not written anything about himself yet.
        @endif
    </div>
    @if (Auth()->check()):
        @if (Auth()->data()->id != $this->data->id):
            <div class="col-12 text-center border-bottom mt-10">
                <a href="{{ route('message.thread', ['userId' => $this->data->id]) }}" class="btn btn-success mb-10">Send private message</a>
                <a href="{{ route('report.contents', ['id' => $this->data->id, 'contents' => 'profile', 'token' => $this->token->generate('report_token')]) }}" class="btn btn-danger mb-10">Report user</a>
            </div>
        @endif
    @endif
    <div class="col-12 row">
        <div class="col">
            <h5>{{ $this->data->username }} friends:</h5>
            @if (count($this->friends) > 0):
                @foreach ($this->friends as $friend):
                    @if ($friend['type'] == 2):
                        @include partials/user_friend_block
                    @endif
                @endforeach
            @endif
        </div>
        <div class="col">
            <h5>Users blocked by {{ $this->data->username }}:</h5>
            @if (count($this->friends) > 0):
                @foreach ($this->friends as $friend):
                    @if ($friend['type'] == 3):
                        @include partials/user_friend_block
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-12 text-center mb-10 border-top">
        @if (Auth()->check()):
            @if (Auth()->data()->id == $this->data->id):
                @if (count($this->friend->getRequestSendedToUser()) > 0):
                    <p class="small-grey-text">Your friends requests:</p>
                    <div class="row text-left mt-10">
                        @foreach ($this->friend->getRequestSendedToUser() as $friend):
                            @include partials/user_friend_block
                        @endforeach
                    </div>
                @else
                    <p class="small-grey-text">You have no new friend requests.</p>
                @endif
            @else
                @if ($this->friend->userIsBlocekdByFriend($this->data->id)):
                    <p class="small-grey-text">You are blocked by {{ $this->data->username }}</p>
                @elseif ($this->friend->friendIsBlockedByUser($this->data->id)):
                    <a href="{{ route('friend.remove', ['userId' => $this->data->id, 'token' => $this->urlToken]) }}" class="btn btn-success">Unlock {{ $this->data->username }}</a>
                @elseif ($this->friend->checkUserAndFriendAreRelated($this->data->id)):
                    <p class="small-grey-text">You and {{ $this->data->username }} are friends!</p>
                    <a href="{{ route('friend.remove', ['userId' => $this->data->id, 'token' => $this->urlToken]) }}" class="btn btn-danger">Remove {{ $this->data->username }} from friends</a>
                @elseif ($this->friend->userSendRequestToFriend($this->data->id)):
                    <p class="small-grey-text">You must wait until {{ $this->data->username }} accept your request.</p>
                    <a href="{{ route('friend.remove', ['userId' => $this->data->id, 'token' => $this->urlToken]) }}" class="btn btn-danger">Remove friend request</a>
                @elseif ($this->friend->friendSendRequestToUser($this->data->id)):
                    <a href="{{ route('friend.accept', ['userId' => $this->data->id, 'token' => $this->urlToken]) }}" class="btn btn-success">Accept friend request</a>
                    <a href="{{ route('friend.remove', ['userId' => $this->data->id, 'token' => $this->urlToken]) }}" class="btn btn-danger">Remove friend request</a>
                @else
                    <a href="{{ route('friend.add', ['type' => 'friend', 'userId' => $this->data->id, 'token'=> $this->urlToken]) }}" class="btn btn-success">Add {{ $this->data->username }} to friend</a>
                    <a href="{{ route('friend.add', ['type' => 'block', 'userId' => $this->data->id, 'token'=> $this->urlToken]) }}" class="btn btn-danger">Add {{ $this->data->username }} to block list</a>
                @endif
            @endif
        @endif
    </div>
    @if (Auth()->check()):
        @if (Auth()->data()->id == $this->data->id || Auth()->permissions("moderator")):
            @if (Auth()->permissions("moderator")):
                <div class="col-12 text-center mb-10 border-top">
                    <form method="post" action="{{ route('moderation_notes.add_personal_note', ['userId' => $this->data->id]) }}">
                        <div class="form-group">
                            <label for="post">Add presonal note for {{ $this->data->username }}:</label>
                            @if (Libs\Config::get("moderation/moderation_notes/personal_notes/contents/bbcode")):
                                @include partials/post_bbcode_block
                            @else
                                @include partials/post_default_block
                            @endif
                        </div>
                        <input type="hidden" name="post_token" value="{{ $this->token->generate('post_token') }}">
                        <input type="submit" class="btn btn-success btn-lg w-100 mb-10" value="Send">
                    </form>
                </div>
            @endif
            @if (Auth()->data()->id == $this->data->id):
                <div class="col-12 text-center mb-10 border-top">
                    <a href="{{ route('report.my_reports') }}" class="btn btn-info btn-lg w-100 mt-10">My reports</a>
                </div>
            @endif
            <div class="col-12 text-center mb-10 border-top">
                <h5>Moderation notes for {{ $this->data->username }} (visible only for mods and user)</h5>
            </div>
            <div class="col-12 mb-10 border-top">
                @foreach ($this->notes->getNotes($this->data->id) as $note):
                    <div class="col mt-10 border">
                        <p class="small-grey-text">Created by <a href="{{ route('profile.index_by_id', ['id' => $note->mod_id]) }}">{{ $this->user->username($note->mod_id) }}</a></p>
                        <p class="small-grey-text">Created at: {{ $this->user->dateTimeAlphaMonth($note->created_at) }}</p>
                        <div class="col border-top">
                            @if (Libs\Config::get("moderation/moderation_notes/personal_notes/contents/bbcode")):
                                {? $this->bb->parse($note->contents, false) ?}
                                {{ $this->bb->getHtml() }}
                            @else
                                {{ $note->contents }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

@include partials/footer
