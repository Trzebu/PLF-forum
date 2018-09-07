@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <table class="table">

        <thead class="w-100">
            <th style="width: 50%; padding-left: 25px">

                @if (Auth()->check()):
                    <p><a href="{{ route('post.add_subject_to_category', ['sectionName' => $this->section_details->id, 'categoryId' => $this->category->id]) }}">Add new subject here</a></p>
                @endif

                Subjects

            </th>
            <th class="w-10 text-center">Votes</th>
            <th class="w-10 text-center">Answers</th>
            <th class="w-10 text-center">Views</th>
            <th style="width: 20%;">Last post</th>
        </thead>

        @if ($this->category !== NULL && $this->posts !== NULL):

            @foreach ($this->posts->results() as $post):

                <tr class="w-100">
                    <td style="width: 50%; padding-left: 25px">
                        <a href="{{ route('post.slug_index', ['sectionName' => $this->section_details->url_name, 'categoryId' => $this->category->url_name, 'postId' => $post->id, 'postSlugUrl' => Libs\Tools\SlugUrl::generate($post->subject)]) }}">{{ $post->subject }}</a>
                        <p class="small-grey-text">{{ substr(strip_tags($post->contents), 0, 80) }}...</p>
                    </td>
                    <td class="w-10 text-center">
                        @if ($this->vote->calcVotes($post->id) == 0):
                            0
                        @elseif ($this->vote->calcVotes($post->id) > 0):
                            <font color="green">+{{ $this->vote->calcVotes($post->id) }}</font>
                        @else
                            <font color="red">{{ $this->vote->calcVotes($post->id) }}</font>
                        @endif
                    </td> 
                    <td class="w-10 text-center">{{ $this->postObj->getAnswersCount($post->id, $this->category->id) }}</td>
                    <td class="w-10 text-center">{{ $post->visits }}</td>
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

    {{ $this->posts !== null ? $this->posts->paginateRender() : "" }}

@include partials/footer
