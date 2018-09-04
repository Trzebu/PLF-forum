@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <table class="table">

        <thead class="w-100">
            <th style="width: 60%; padding-left: 25px">Subject</th>
            <th class="w-10">Answers</th>
            <th class="w-10">Views</th>
            <th style="width: 20%;">Last post</th>
        </thead>

        @if ($this->category !== NULL && $this->posts !== NULL):

            @foreach ($this->posts->results() as $post):

                <tr class="w-100">
                    <td style="width: 60%; padding-left: 25px">
                        <a href="">{{ $post->subject }}</a>
                        <p class="small-grey-text">{{ substr(strip_tags($post->contents), 0, 80) }}...</p>
                    </td>
                    <td class="w-10">{{ $this->postObj->getAnswersCount($post->id, $this->category->id) }}</td>
                    <td class="w-10">{{ $post->visits }}</td>
                    <td style="width: 20%;">
                        @if ($this->postObj->getLastPost($post->id, $this->category->id) !== null):
                            <p class="small-grey-text">Author: {{ $this->user->username($this->postObj->getLastPost($post->id, $this->category->id)->user_id) }}</p>
                            <p class="small-grey-text">{{ $this->postObj->dateTimeAlphaMonth($this->postObj->getLastPost($post->id, $this->category->id)->created_at) }}</p>
                        @else
                            This subject is empty.
                        @endif
                    </td>
                </tr>

            @endforeach

        @else
            <tr class="w-100">
                <td>Currently this section heven't posts. yet...</td>
            </tr>
        @endif

    </table>


</div>

    {{ $this->posts->paginateRender() }}

@include partials/footer
