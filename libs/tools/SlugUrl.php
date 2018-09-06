<?php

namespace Libs\Tools;

class SlugUrl {

    public static function generate ($slug) {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^\-\s\pN\pL]+/u', '', mb_strtolower($slug, "UTF-8"));
        $slug = preg_replace('/[\-\s]+/', "-", $slug);

        return trim($slug, '-');
    }

}