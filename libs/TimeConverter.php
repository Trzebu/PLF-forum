<?php

namespace Libs;
use Libs\Str;
use Libs\Translate;

class TimeConverter {

    public function diffToHuman ($time) {
        $time = is_string($time) ? strtotime($time) : $time;
        $now = time();

        $human_diff = $time > $now ? self::clacDiff($time - $now, Translate::get("time.from_now")) : self::clacDiff($now - $time, Translate::get("time.ago"));

        return $human_diff;
    }

    private static function clacDiff ($diff, $diff_type) {
        $time = self::calcTime($diff);

        $form = [];

        if ($time["m"] == 0 && $time["h"] == 0) {
            $form = explode("|", Translate::get("time.second"));
            $time = $time["s"];
        } else if ($time["h"] == 0) {
            $form = explode("|", Translate::get("time.minute"));
            $time = $time["m"];
        } else {
            $form = explode("|", Translate::get("time.hour"));
            $time = $time["h"];

            if ($time > 24) {
                return Str::replace($diff_type, ["time:" => self::longDiff($time)]);
            }

        }

        if (($time >= 5) && ($time <= 20)) {
            if (count($form) == 3) {
                $form = $form[2];
            } else {
                $form = $form[1];
            }
        } else if ($time == 1) {
            $form = $form[0];
        } else {
            $time = strval($time);
            $last_digit = $time[strlen($time) - 1];
            if (($last_digit >= 2) && ($last_digit <= 4)) {
                $form = $form[1];
            } else {
                if (count($form) == 3) {
                    $form = $form[2];
                } else {
                    $form = $form[1];
                }
            }
        }

        return Str::replace($diff_type, ["time:" => Str::replace($form, ["count:" => $time])]);
    }

    private static function longDiff ($hours) {
        $days = round($hours / 24);

        if ($days <= 31) {
            $form = explode("|", Translate::get("time.day"));
            if ($days == 1) {
                $form = $form[0];
            } else {
                $form = $form[1];
            }
        } else {
            $month = round($days / 31);

            if ($month <= 12) {
                $form = explode("|", Translate::get("time.month"));
            } else {
                $form = explode("|", Translate::get("time.year"));
                $month = round($month / 12);
            }

            $month = strval($month);
            if (($month >= 5) && ($month <= 20)) {
                if (count($form) == 3) {
                    $form = $form[2];
                } else {
                    $form = $form[1];
                }
            } else if ($month == 1) {
                $form = $form[0];
            } else {
                $last_digit = $month[strlen($month) - 1];
                if (($last_digit >= 2) && ($last_digit <= 4)) {
                    $form = $form[1];
                } else {
                    if (count($form) == 3) {
                        $form = $form[2];
                    } else {
                        $form = $form[1];
                    }
                }
            }

            $days = $month;
        }

        return Str::replace($form, ["count:" => $days]);
    }

    private static function calcTime ($time) {
        $h = floor($time / 3600);
        $m = floor(($time / 60) % 60);
        $s = $time % 60;

        return (array) [
            "s" => $s,
            "m" => $m,
            "h" => $h
        ];
    }

}