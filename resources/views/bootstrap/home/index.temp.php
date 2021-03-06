@include partials/top

@if ($this->sections !== null):
    
    <div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

        @if (Auth()->check()):
            <center><h5><a href="{{ route('post.add_subject') }}">Create new thread</a></h5></center>
        @else
            <center><h5><a href="{{ route('auth.login') }}">Login</a></h5></center>
        @endif

        @foreach ($this->sections as $section):
            <div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">
                <table class="table">
                    
                    <thead class="w-100">
                        <th style="width: 60%;">
                            <a href="{{ route('section.view_categories', ['sectionId' => $section->url_name]) }}">{{ $section->name }}</a>
                            <p class="small-grey-text">{{ $section->description }}</p>
                        </th>
                        <th class="w-10 text-center">Subjects</th>
                        <th class="w-10 text-center">Posts</th>
                        <th style="width: 20%;">Last post</th>
                    </thead>

                    @if ($this->section->getSectionCategories($section->id) !== null):
                        @foreach ($this->section->getSectionCategories($section->id) as $category):

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
                                    <a href="{{ route('section.category_posts', ['sectionName' => $section->url_name, 'categoryId' => $category->url_name]) }}">
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
                                        <a href="{{ route('post.slug_index', ['sectionName' => $section->url_name, 'categoryId' => $category->url_name, 'postId' => $this->postObj->getLastSubject($category->id)->id, 'postSlugUrl' => Libs\Tools\SlugUrl::generate($this->postObj->getLastSubject($category->id)->subject)]) }}">{{ substr($this->postObj->getLastSubject($category->id)->subject, 0, Libs\Config::get('forum/section_view/last_thread/subject/length/max')) }}...</a>
                                        <p class="small-grey-text">Author: <a href="{{ route('profile.index_by_id', ['id' => $this->postObj->getLastSubject($category->id)->user_id]) }}">{{ $this->user->username($this->postObj->getLastSubject($category->id)->user_id) }}</a></p>
                                        <p class="small-grey-text">{{ $this->postObj->dateTimeAlphaMonth($this->postObj->getLastSubject($category->id)->created_at, Libs\Config::get('forum/section_view/last_thread/date/short_notation')) }}</p>
                                    @else
                                        This category is empty.
                                    @endif
                                </td>
                            </tr>
                            
                        @endforeach
                    @else
                        <tr class="w-100">
                            <td>Currently this section heven't categories. yet...</td>
                        </tr>
                    @endif
                </table>

            </div>
        @endforeach

    </div>

@else
    Currently we heven't sections. yet...
@endif

@include partials/footer
