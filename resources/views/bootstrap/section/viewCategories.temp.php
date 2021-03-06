@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <table class="table">

        <thead class="w-100">
            <th style="width: 60%; padding-left: 25px">
                @if ($this->categories !== null):
                    {{ $this->section_details->name }}
                    <p class="small-grey-text">{{ $this->section_details->description }}</p>
                @else
                    This section does not exist, yet...
                @endif
            </th>
            <th class="w-10 text-center">Subjects</th>
            <th class="w-10 text-center">Posts</th>
            <th style="width: 20%;">Last post</th>
        </thead>

        @if ($this->categories !== null):
            @foreach ($this->categories as $category):

                @if ($category->status == 2):
                    @if (Auth()->check()):
                        @if (!$this->section->checkPermissions($category->id)):
                            <?php continue; ?>
                        @endif
                    @else
                        <?php continue; ?>
                    @endif
                @endif

                <tr class="w-100">
                    <td style="width: 60%; padding-left: 25px">
                        <a href="{{ route('section.category_posts', ['sectionName' => $this->section_details->url_name, 'categoryId' => $category->url_name]) }}">
                            @if ($category->status == 1):
                                <i class="fas fa-lock"></i>
                            @elseif ($category->status == 2):
                                <i class="fas fa-exclamation-triangle"></i>
                            @elseif (!is_null($category->password)):
                                <i class="fas fa-key"></i>
                            @else
                                <i class="fab fa-wpforms"></i>
                            @endif
                            {{ $category->name }}
                        </a>
                        <p class="small-grey-text">{{ $category->description }}</p>
                        <p  class="small-grey-text">
                            Moderators:
                            @foreach ($this->section->getSectionModerators($category->id) as $key => $value):
                                <a href="{{ route('profile.index_by_id', ['id' => $value['id']]) }}"><font color="{{ $value['color'] }}">{{ $key }}</font></a>
                            @endforeach
                        </p>
                    </td>
                    <td class="w-10 text-center">{{ $this->postObj->getSubjectsCount($category->id) }}</td>
                    <td class="w-10 text-center">{{ $this->postObj->getPostsCount($category->id) }}</td>
                    <td style="width: 20%;">
                        @if (!is_null($category->password) && !$this->user->isLoggedToCategory($category->id)):
                            <p class="small-grey-text">This category is secured by password.</p>
                        @elseif ($this->postObj->getLastSubject($category->id) !== null):
                            <a href="{{ route('post.slug_index', ['sectionName' => $this->section_details->url_name, 'categoryId' => $category->url_name, 'postId' => $this->postObj->getLastSubject($category->id)->id, 'postSlugUrl' => Libs\Tools\SlugUrl::generate($this->postObj->getLastSubject($category->id)->subject)]) }}">{{ substr($this->postObj->getLastSubject($category->id)->subject, 0, Libs\Config::get('forum/section_view/last_thread/subject/length/max')) }}...</a>
                            <p class="small-grey-text">Author: <a href="{{ route('profile.index_by_id', ['id' => $this->postObj->getLastSubject($category->id)->user_id]) }}">{{ $this->user->username($this->postObj->getLastSubject($category->id)->user_id) }}</a></p>
                            <p class="small-grey-text">{{ $this->postObj->dateTimeAlphaMonth($this->postObj->getLastSubject($category->id)->created_at, Libs\Config::get('section/categorys/last_thread/date/short_notation')) }}</p>
                        @else
                            This category is empty.
                        @endif
                    </td>
                </tr>
                            
            @endforeach
        @else
            <tr class="w-100">
                <td>
                    <p class="small-grey-text">This section does not exist, yet...</p>
                </td>
            </tr>
        @endif

    </table>

</div>

@include partials/footer
