<tr class="w-100">
    <td style="width: 50%; padding-left: 25px">
        <a href="{{ route('post.slug_index', ['sectionName' => $this->section_details->url_name, 'categoryId' => $this->category->url_name, 'postId' => $post->id, 'postSlugUrl' => Libs\Tools\SlugUrl::generate($post->subject)]) }}">
            @if ($post->category == 0):
                <i class="fas fa-globe-americas"></i>
            @endif
            @if ($post->sticky == 1):
                <i class="fas fa-bullhorn"></i>
            @endif
            @if ($post->status == 1):
                <i class="fas fa-lock"></i>
            @else
                <i class="fab fa-wpforms"></i>
            @endif
            <font color="{{ $post->subject_color }}">
                {{ $post->subject }}
            </font>
        </a>
        <p class="small-grey-text">{{ substr(stripBbCodeTags($post->contents), 0, Libs\Config::get('category/posts/contents/short_descript/length/max')) }}...</p>
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
    <td class="w-10 text-center">{{ $this->postObj->getAnswersCount($post->id) }}</td>
    <td class="w-10 text-center">{{ $post->visits }}</td>
    <td style="width: 20%;">
        @if ($this->postObj->getLastPost($post->id) !== null):
            <p class="small-grey-text">Author: <a href="{{ route('profile.index_by_id', ['id' => $this->postObj->getLastPost($post->id)->user_id]) }}">{{ $this->user->username($this->postObj->getLastPost($post->id)->user_id) }}</a></p>
            <p class="small-grey-text">{{ $this->postObj->dateTimeAlphaMonth($this->postObj->getLastPost($post->id)->created_at, Libs\Config::get('category/view/last_post/date/short_notation')) }}</p>
        @else
            This subject is empty.
        @endif
    </td>
</tr>