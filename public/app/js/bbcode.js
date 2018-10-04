var bbTags = {
    "bold": "[b][/b]",
    "italic": "[i][/i]",
    "underline": "[u][/u]",
    "strikethrough": "[s][/s]",
    "size": "[size][/size]",
    "center": "[center][/center]",
    "link": '[url="http://example.com"][/url]',
    "quote": "[quote][/quote]",
    "code": "[code][/code]",
    "image": "[img]http://example.com/my_image.jpg[/img]",
    "list-ul": "[ul][li]First element[/li][li]next element[/li][/ul]",
    "list-ol": "[ol][li]First element[/li][li]next element[/li][/ol]",
    "youtube": "[youtube]Youtube link[/youtube]",
}

function replace (tagName) {
    $("#post").val($("#post").val() + bbTags[tagName]);
}