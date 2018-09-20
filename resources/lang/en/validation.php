<?php

return [
    "max" => [
        "numeric" => "The :attribute may not be greater than :max.",
    ],
    "min" => [
        "numeric" => "The :attribute must be at least :min.",
    ],
    "numeric" => "The :attribute must be a number.",
    "string" => [
        "str" => "The :attribute must be a string.",
        "min" => "The :attribute must be at least :min characters.",
        "max" => "The :attribute may not be greater than :max characters."
    ],
    "alpha" => [
        "letters" => "The :attribute may only contain letters.",
        "num" => "The :attribute may only contain letters and numbers.",
    ],
    "is_valid" => [
        "email" => "The :attribute field must be a valid e-mail address.",
        "url" => "The :attribute must be valid URL address.",
    ],
    "same" => "The :attribute and :other must match.",
    "required" => "The :attribute field is required.",
    "unique" => "The :attribute has already been taken.",
    "token" => "Token expired. Try again.",
    "accepted" => "The :attribute must be accepted.",
    "image" => "The :attribute must be an image.",
];