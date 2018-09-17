<?php
    $friend = (object) $friend;
    $user = $this->user->data($friend->user_id); 
?>
<div class="col">
    <div class="media">
        <img class="media-object mr-3 rounded-circle avatar_mini_thumb" src="{{ $this->user->getAvatar($user->id, 50) }}" alt="{{ $user->username }}">
    </div>
    <a href="{{ route('profile.index_by_id', ['id' => $user->id]) }}">{{ $this->user->username($user->id) }}</a>
    @if ($friend->type == 1):
        <br>
        <a href="{{ route('friend.accept', ['userId' => $user->id, 'token' => $this->urlToken]) }}" class="btn btn-success">Accept friend request</a>
    @endif
</div>