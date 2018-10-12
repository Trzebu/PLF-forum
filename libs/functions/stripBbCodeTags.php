<?php

function stripBbCodeTags ($text_to_search) {
    return preg_replace("|[[\/\!]*?[^\[\]]*?]|si", "", $text_to_search);
}