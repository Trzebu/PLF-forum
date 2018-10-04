@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <div class="col-12 row">
        <div class="col-2">
            <p>Threads:</p>
            @if (count($this->threads) > 0):
                @foreach ($this->threads as $thread):
                    <div class="col text-center {{ is_object($this->thread) ? $this->threadId == $thread ? 'border' : '' : '' }}">
                        <a href="{{ route('message.thread', ['userId' => $thread]) }}">
                            <div class="media">
                                <img class="mx-auto d-block media-object mr-3 rounded-circle avatar_mini_thumb" src="{{ $this->user->getAvatar($thread, 50) }}">
                            </div>
                            {{ $this->user->username($thread) }} {{ $this->message->getUnreadedMessagesByUser($thread) > 0 ? '(' . $this->message->getUnreadedMessagesByUser($thread) . ')' : '' }}
                        </a>
                    </div>
                @endforeach
            @else
                <p class="small-grey-text">You have no open threads.</p>
            @endif
        </div>
        <div class="col-10 border-left">
            @if ($this->thread === null):
                Select thread
            @elseif (is_object($this->thread) || !$this->thread):
                <div class="col messages_container" id="messages">
                    @if (is_object($this->thread)):
                        <?php $unreaded_line = false; ?>
                        @foreach ($this->thread as $data):

                            @if ($data->readed == 0 && !$unreaded_line):
                                <?php $unreaded_line = true; ?>
                                <div class="col">
                                    <center><p class="small-grey-text">Unreaded</p></center>
                                </div>
                            @endif

                            <div class="row mt-10" title="{{ $data->readed == 1 ? $data->user_id == Auth()->data()->id ? 'Readed at: ' . $this->user->dateTimeAlphaMonth($data->updated_at) : 'Sended at: ' . $this->user->dateTimeAlphaMonth($data->created_at) : 'Sended at: ' . $this->user->dateTimeAlphaMonth($data->created_at) }}">
                                <div class="col-1">
                                    <div class="media">
                                        <img class="mx-auto d-block media-object mr-3 rounded-circle avatar_mini_thumb" src="{{ $this->user->getAvatar($data->user_id, 50) }}">
                                    </div>
                                </div>
                                <div class="col-11">
                                    @if (Libs\Config::get("private_message/contents/bbcode")):
                                        {? $this->bb->parse($data->contents, false); ?}
                                        {{ $this->bb->getHtml() }}
                                    @else
                                        {{ $data->contents }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col">
                            <center><p class="small-grey-text">You have not written any messages yet!</p></center>
                        </div>
                    @endif
                </div>
                <div class="col h-25">
                    <form method="post" action="{{ route('message.thread', ['userId' => $this->threadId]) }}">
                        <div class="form-group">
                            <label for="post">Write something nice:</label>
                            @if (Libs\Config::get("private_message/contents/bbcode")):
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
        </div>
    </div>

</div>

<script type="text/javascript" src="{{ route('/') }}/public/app/js/scrollMessages.js"></script>

@include partials/footer
