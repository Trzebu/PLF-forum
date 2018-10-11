<?php

return [
    "string" => [
        "str" => ":attribute musi być ciągiem znaków.",
        "min" => ":attribute nie może mieć mniej niż :min znaków.",
        "max" => ":attribute nie może mieć więcej niż :max znaków.",
        "equals" => "Wartość :attribute nie może być inna niż :value."
    ],
    "integre" => [
        "num" => ":attribute musi być liczbą.",
        "min" => ":attribute nie może być mniejszy niż :min.",
        "max" => ":attribute nie może być większy niż :max.",
        "equals" => ":attribute musi być równy :value."
    ],
    "alpha" => [
        "letters" => ":attribute może zawierać tylko litery.",
        "num" => ":attribute może zaiwerać tylko litery i liczby.",
    ],
    "is_valid" => [
        "email" => ":attribute musi być poprawnym adresem e-mail.",
        "url" => ":attribute musi być poprawnym adresem URL.",
    ],
    "same" => ":attribute i :other muszą być takie same.",
    "required" => ":attribute jest wymagane.",
    "unique" => ":attribute jest już zajęty.",
    "token" => "Token wygasł. Spróbuj ponownie.",
    "accepted" => ":attribute musi być zaakceptowany.",
    "image" => [
        "forbidden_mime" => ":attribute nie może być obrazem typu :type ",
        "unknown_mime" => ":attribute posiada nieznany typ MIME.",
        "resolution" => [
            "max" => "Rozdzielczość :attribute nie może przekroczyć więcej niż :max_width szerokości i :max_height wysokości.",
            "min" => "Rozdzielczość :attribute nie może być mniejsza niż :min_width szerokości i :min_height wysokości."
        ],
    ],
    "file" => [
        "size" => [
            "min" => ":attribute nie może mieć mniej niż :min .",
            "max" => ":attribute nie może mieć więcej niż :max .",
        ],
    ],
];