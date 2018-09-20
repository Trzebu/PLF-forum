<?php

namespace Libs\Validation\Rules;

use Libs\Validation\Rule;
use Libs\Str;
use Libs\Tools\HumanFileSize;

class File extends Rule {

    private $_file = [];
    private $_imagesMime = [
        "image/gif",
        "image/jpeg",
        "image/png",
        "image/bmp",
        "image/x-icon",
    ];

    protected function file () {
        $this->_file = (object) $this->__fields[$this->__input];

        if (count($this->_file) == 0) {
            $this->error("Unknown file type.");
        }
    }

    protected function image ($forbidden = null) {
        $forbidden = $forbidden === null ? (array) [] : (array) explode(",", $forbidden);

        if (!in_array(mime_content_type($this->_file->tmp_name), $this->_imagesMime)) {
            $this->error(Str::replace(trans("validation.image.unknown_mime"), [
                ":attribute" => $this->__attribute
            ]));
        }

        if (in_array(explode("/", $this->_file->type)[1], $forbidden)) {
            $this->error(Str::replace(trans("validation.image.forbidden_mime"), [
                ":attribute" => $this->__attribute,
                ":type" => $this->_file->type
            ]));
        }

    }

    protected function max_size ($value) {
        if ($this->_file->size > $value) {
            $this->error(Str::replace(trans("validation.file.size.max"), [
                ":attribute" => $this->__attribute,
                ":max" => HumanFileSize::get($value)
            ]));
        }
    }

    protected function max_resolution ($value) {
        $value = explode(",", $value);
        $size = getimagesize ($this->_file->tmp_name);

        if (($size[0] > $value[0]) ||
            ($size[1] > $value[1])) {
            $this->error(Str::replace(trans("validation.image.resolution.max"), [
                ":attribute" => $this->__attribute,
                ":max_width" => "{$value[0]}px",
                ":max_height" => "{$value[1]}px",
            ]));
        }
    }

    protected function min_resolution ($value) {
        $value = explode(",", $value);
        $size = getimagesize ($this->_file->tmp_name);

        if (($size[0] < $value[0]) ||
            ($size[1] < $value[1])) {
            $this->error(Str::replace(trans("validation.image.resolution.min"), [
                ":attribute" => $this->__attribute,
                ":min_width" => "{$value[0]}px",
                ":min_height" => "{$value[1]}px",
            ]));
        }
    }

}