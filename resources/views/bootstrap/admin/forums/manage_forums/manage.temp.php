@include admin/partials/top
@include admin/forums/navigation

<div class="main">
    <h1>Forum administration</h1>
    <p class="grey-text">Here you can create new section/category or edit exist forum.</p>
    
    <form method="get" action="{{ route('admin.forums.new_forum') }}/">
        <div class="fieldset">

            <div class="legend">Create new forum</div>
            <dl>
                <dt>
                    <label for="name">Forum name</label>
                </dt>
                <dd>
                    <input id="name" type="text" name="name">
                </dd>
                <dd>
                    <input type="submit" class="button" value="{{ trans('buttons.create') }}">
                </dd>
            </dl>
        </div>
    </form>

    <table class="table-responsive">
        <tbody>
            @foreach ((array) $this->section->getSections() as $section):
                <tr class="forums_table">
                    <td style="width: 95%">
                        <p class="big-text">{{ $section->name }}</p>
                        <p class="small-grey-text">{{ $section->description }}</p>
                    </td>
                    <td  style="width: 5%">
                        <a href="{{ route('admin.forums.manage_forums.queue', ['dir' => 'up', 'id' => $section->id, 'token' => $this->url_token]) }}">
                            <i class="fas fa-arrow-up i_blue"></i>
                        </a>
                        <a href="{{ route('admin.forums.manage_forums.queue', ['dir' => 'down', 'id' => $section->id, 'token' => $this->url_token]) }}">
                            <i class="fas fa-arrow-down i_blue"></i>
                        </a>
                        <a href="{{ route('admin.forums.manage_forums.options', ['id' => $section->id]) }}">
                            <i class="fas fa-cogs i_green"></i>
                        </a>
                        <a href="{{ route('admin.forums.new_forum.by_section', ['sectionId' => $section->id]) }}">
                            <i class="far fa-plus-square i_green"></i>
                        </a>
                    </td>
                </tr>

                @foreach ((array) $this->section->getSectionCategories($section->id) as $category):
                    <tr>
                        <td style="width: 95%;padding-left:30px">
                            {{ $category->name }}
                            <p class="small-grey-text">{{ $category->description }}</p>
                        </td>
                        <td  style="width: 5%">
                            <a href="{{ route('admin.forums.manage_forums.queue', ['dir' => 'up', 'id' => $category->id, 'token' => $this->url_token]) }}">
                                <i class="fas fa-arrow-up i_blue"></i>
                            </a>
                            <a href="{{ route('admin.forums.manage_forums.queue', ['dir' => 'down', 'id' => $category->id, 'token' => $this->url_token]) }}">
                                <i class="fas fa-arrow-down i_blue"></i>
                            </a>
                            <a href="{{ route('admin.forums.manage_forums.options', ['id' => $category->id]) }}">
                                <i class="fas fa-cogs i_green"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </ol>

</div>

@include admin/partials/bot