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
            <p class="small-grey-text">Registered at: {{ $this->user->dateTimeAlphaMonth($this->data->created_at) }}</p>
            <p class="small-grey-text">Last visit: {{ $this->user->diffToHuman($this->data->updated_at) }}</p>
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
            <p class="small-grey-text">Name: {{ !is_null($this->data->full_name) ? $this->data->full_name : 'hidden' }}</p>
            <p class="small-grey-text">City: {{ !is_null($this->data->city) ? $this->data->city : 'hidden' }}</p>
            <p class="small-grey-text">From: {{ !is_null($this->data->country) ? $this->data->country : 'hidden' }}</p>
            <p class="small-grey-text">WWW: {{ !is_null($this->data->www) ? '<a href="' . $this->data->www . '">' . $this->data->www . '</a>' : 'hidden' }}</p>
        </div>
    </div>
    <div class="col-12 text-center border-bottom">
        <h5>About {{ $this->data->username }}:</h5>
    </div>
    <div class="col-12">
        @if ($this->about !== null):
            {{ $this->about }}
        @else
            {{ $this->data->username }} has not written anything about himself yet.
        @endif
    </div>
    <div class="col-12 row">
        <div class="col">
            <h5>{{ $this->data->username }} friends.</h5>
            @if ($this->friends !== null):
                @foreach ($this->friends as $friend):
                    @if ($friend['type'] == 2):
                        <?php $user = $this->user->data($friend['id']); ?>
                        <div class="col">
                            <div class="media">
                                <img class="media-object mr-3 rounded-circle avatar_mini_thumb" src="{{ $this->user->getAvatar($user->id, 50) }}" alt="{{ $user->username }}">
                            </div>
                            {{ $this->user->username($user->id) }}
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        <div class="col">
            <h5>Users blocked by {{ $this->data->username }}</h5>
            @if ($this->friends !== null):
                @foreach ($this->friends as $friend):
                    @if ($friend['type'] == 3):
                        <?php $user = $this->user->data($friend['id']); ?>
                        <div class="col">
                            <div class="media">
                                <img class="media-object mr-3 rounded-circle avatar_mini_thumb" src="{{ $this->user->getAvatar($user->id, 50) }}" alt="{{ $user->username }}">
                            </div>
                            {{ $this->user->username($user->id) }}
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-12 text-center mb-10 border-top">
        @if (Auth()->check()):
            @if (Auth()->data()->id == $this->data->id):
                Request sended to you.
            @else
                @if ($this->friend->userIsBlocekdByFriend($this->data->id)):
                    <p class="small-grey-text">You are blocked by {{ $this->data->username }}</p>
                @elseif ($this->friend->friendIsBlockedByUser($this->data->id)):
                    <a href="{{ route('friend.remove', ['userId' => $this->data->id, 'token' => $this->urlToken]) }}" class="btn btn-success">Unlock {{ $this->data->username }}</a>
                @elseif ($this->friend->checkUserAndFriendAreRelated($this->data->id)):
                    <p class="small-grey-text">You and {{ $this->data->username }} are friends!.</p>
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
</div>

@include partials/footer
