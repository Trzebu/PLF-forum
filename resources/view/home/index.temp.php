@include partials/top

@if ($this->sections !== null):
    
    <div class="col border border-primary rounded border-5" style="background-color: #f2f2f2;">

        @foreach ($this->sections as $section):
            <div class="col border border-primary rounded mt-10 mb-10 border-5 border-top-10" style="padding: 0">
                <div class="section_title" style="padding-left: 15px">{{ $section->name }}</div>
                <p class="font-weight-light font-italic" style="padding-left: 15px">{{ $section->description }}</p>
                
                @if ($this->section->getSectionCategories($section->id) !== null):
                    @foreach ($this->section->getSectionCategories($section->id) as $category):
                        <div class="col category">
                            <a href="">{{ $category->name }}</a>
                        </div>
                    @endforeach
                @else
                    Currently this section heven't categories. yet...
                @endif

            </div>
        @endforeach

    </div>

@else
    Currently we heven't sections. yet...
@endif

@include partials/footer
