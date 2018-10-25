@include partials/top

<div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">

    <table class="table">

        <thead class="w-100">
            <th style="width: 50%; padding-left: 25px">

                @if ($this->category !== NULL):
                    @if (Auth()->check()):
                        @if ($this->category->status == 1 && !$this->hasPermissions):
                            <h5><font color="red">You can not write anything because this category is closed.</font></h5>
                        @else
                            <p><a href="{{ route('post.add_subject_to_category', ['sectionName' => $this->section_details->id, 'categoryId' => $this->category->id]) }}">Add new subject here</a></p>
                        @endif
                    @endif
                    <p class="small-grey-text">{{ $this->section_details->name }}/{{ $this->category->name }}</p>
                    <p  class="small-grey-text">
                        Moderators:
                        @foreach ($this->section->getSectionModerators($this->category->id) as $key => $value):
                            <a href="{{ route('profile.index_by_id', ['id' => $value['id']]) }}"><font color="{{ $value['color'] }}">{{ $key }}</font></a>
                        @endforeach
                    </p>
                    Subjects
                @else
                    This category dosn't exists.
                @endif

            </th>
            <th class="w-10 text-center">Votes</th>
            <th class="w-10 text-center">Answers</th>
            <th class="w-10 text-center">Views</th>
            <th style="width: 20%;">Last post</th>
        </thead>

        @if ($this->category !== NULL):
        
            @foreach ((array) $this->postObj->getGlobalThreads() as $post):
                @include partials/category_posts_view_table_row
            @endforeach
            
            @foreach ((array) $this->postObj->getStickyThreads($this->category->id) as $post):
                @include partials/category_posts_view_table_row
            @endforeach

            @foreach ((array) $this->postObj->getPosts($this->category->id) as $post):
                @include partials/category_posts_view_table_row
            @endforeach

        @else
            <tr class="w-100">
                <td>Currently this section heven't posts. yet...</td>
            </tr>
        @endif

    </table>


</div>

    {{ $this->postObj->paginateRender() }}

@include partials/footer
