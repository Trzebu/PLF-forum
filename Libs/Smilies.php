<?php

namespace Libs;

class Smilies {

    public static function load () {
        return [
            " xD" => self::returnImg("XD_Face", trans("bbcode.smilies.xd"), "xD"),
            " :D" => self::returnImg("icon_e_biggrin", trans("bbcode.smilies.very_happy"), ":D"),
            " :)" => self::returnImg("icon_e_smile", trans("bbcode.smilies.smile"), ":)"),
            " ;)" => self::returnImg("icon_e_wink", trans("bbcode.smilies.wink"), ";)"),
            " :(" => self::returnImg("icon_e_sad", trans("bbcode.smilies.sad"), ":("),
            " :O" => self::returnImg("icon_e_surprised", trans("bbcode.smilies.surprised"), ":O"),
            " :shock:" => self::returnImg("icon_eek", trans("bbcode.smilies.shocked"), ":shock:"),
            " :?" => self::returnImg("icon_e_confused", trans("bbcode.smilies.confused"), ":?"),
            " 8-)" => self::returnImg("icon_cool", trans("bbcode.smilies.cool"), "8-)"),
            " :lol:" => self::returnImg("icon_lol", trans("bbcode.smilies.laughing"), ":lol:"),
            " :x" => self::returnImg("icon_mad", trans("bbcode.smilies.mad"), ":x"),
            " :P" => self::returnImg("icon_razz", trans("bbcode.smilies.razz"), ":P"),
            " :oops:" => self::returnImg("icon_redface", trans("bbcode.smilies.embarrassed"), ":oops:"),
            " :cry:" => self::returnImg("icon_cry", trans("bbcode.smilies.crying_or_sad"), ":cry:"),
            " :evil:" => self::returnImg("icon_evil", trans("bbcode.smilies.evil_or_mad"), ":evil:"),
            " :twisted:" => self::returnImg("icon_twisted", trans("bbcode.smilies.twisted_evil"), ":twisted:"),
            " :roll:" => self::returnImg("icon_rolleyes", trans("bbcode.smilies.rolling_eyes"), ":roll:"),
            " ?:" => self::returnImg("icon_question", trans("bbcode.smilies.question"), "?:"),
            " :idea:" => self::returnImg("icon_idea", trans("bbcode.smilies.idea"), ":idea:"),
            " :arrow:" => self::returnImg("icon_arrow", trans("bbcode.smilies.arrow"), ":arrow:"),
            " :|" => self::returnImg("icon_neutral", trans("bbcode.smilies.neutral"), ":|"),
            " :mrgreen:" => self::returnImg("icon_mrgreen", trans("bbcode.smilies.mr_green"), ":mrgreen:"),
            " :geek:" => self::returnImg("icon_e_geek", trans("bbcode.smilies.geek"), ":geek:"),
            " :ugeek:" => self::returnImg("icon_e_ugeek", trans("bbcode.smilies.uber_geek"), ":ugeek:"),
        ];
    }

    private static function returnImg ($name, $title, $alt) {
        $root = route("/");
        return " <img src=\"{$root}/public/app/img/smilies/{$name}.gif\" title=\"{$title}\" alt=\"{$alt}\"> ";
    }

    public static function parse ($text) {
        $emo = self::load();
        return str_replace(array_keys($emo), array_values($emo), " {$text}");
    }

}