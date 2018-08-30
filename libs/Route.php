<?php

namespace Libs;
use Libs\Http\Request;

class Route {

    public static $get = array();
    public static $post = array();

    public static function get ($route, $params) {
        array_push(self::$get, [$route, $params]);
    }

    public static function post ($route, $params) {
        array_push(self::$post, [$route, $params]);
    }

    public static function getRouteUrl ($routeName) {
        foreach (self::$get as $get) {
            if ($get[1]['as'] == $routeName) {
                return $get[0];
            }
        }

        foreach (self::$post as $post) {
            if ($post[1]['as'] == $routeName) {
                return $post[0];
            }
        }

        return false;
    }

    public static function getRoutes ($path) {

        if (Request::method("POST")) {
            $type = "post";
        } else if (Request::method("GET")) {
            $type = "get";
        } else {
            Throw new Error("Unknown request method.");
        }

        if (count(self::$get) == 0 &&
            count(self::$post) == 0) {
            array_push(self::$get, ["/", [
                "uses" => "Libs\Templates\Framework\Demo\Main@index"
            ]]);
        }

        $type = $type == "get" ? self::$get : self::$post;

        if ($path[strlen($path) - 1] == "/" && (strlen($path) - 1) !== 0) {
            $path = rtrim($path, "/");
        }

        $url_chunks = self::parseUrl($path);

        foreach ($type as $route) {
            $route_chunks = explode("/", $route[0]);
            $route_ok = true;
            $params = [];
            if (count($url_chunks) == count($route_chunks)) {
                for ($i = 0; $i < count($route_chunks); $i++) {
                    if (substr($route_chunks[$i], 0, 1) == "{") {
                        array_push($params, $url_chunks[$i]);
                        continue;
                    } else if ($route_chunks[$i] == $url_chunks[$i]) {
                        continue;
                    } else {
                        $route_ok = false;
                    }
                }
            } else {
                $route_ok = false;
            }

            if ($route_ok) {
                return [
                    "route" => $route,
                    "params" => $params
                ];                
            }
        }

        return [
            "route" => ["", [
                "uses" => "Libs\Templates\Framework\Errors\Error_404\Error@index"
            ]],
            "params" => []
        ];

    }

    private function parseUrl ($url) {
        return explode('/', filter_var(strlen($url) === 1 ? $url : rtrim($url), FILTER_SANITIZE_URL));
    }

}