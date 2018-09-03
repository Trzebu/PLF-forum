@include partials/top

@if ($this->sections !== null):
    
    <div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

        @foreach ($this->sections as $section):
            <div class="col border border-primary rounded mt-10 mb-10 border-5" style="padding: 0">
                <table class="table">
                    
                    <thead class="w-100">
                        <th style="width: 70%;">
                            <a href="{{ route('section.view_categories', ['sectionId' => $section->url_name]) }}">{{ $section->name }}</a>
                            <p class="small-grey-text">{{ $section->description }}</p>
                        </th>
                        <th class="w-10">Topics</th>
                        <th class="w-10">Posts</th>
                        <th class="w-10">Last post</th>
                    </thead>

                    @if ($this->section->getSectionCategories($section->id) !== null):
                        @foreach ($this->section->getSectionCategories($section->id) as $category):

                            <tr class="w-100">
                                <td style="width: 70%; padding-left: 25px">
                                    <a href="">{{ $category->name }}</a>
                                    <p class="small-grey-text">{{ $category->description }}</p>
                                </td>
                                <td class="w-10">0</td>
                                <td class="w-10">0</td>
                                <td class="w-10"><a href="">-</a></td>
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
