<script type="text/javascript" src="{{ route('/') }}/public/app/js/smilies.js"></script>

<div class="col border rounded mb-10 bbcode" style="background-color: white">
    @foreach (Libs\Smilies::load() as $key => $value):
        <i onclick="replaceSmilies('{{ $key }}')">{{ $value }}</i>
    @endforeach
</div>