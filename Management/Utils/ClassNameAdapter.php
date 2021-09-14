<?php

namespace Management\Utils;

class ClassNameAdapter {

    public static function toString(string $className) {
        return str_replace(['\\', 'App_Models_'], ['_', ''], $className);
    }

    public static function fromString(string $className) {
        if (\class_exists('App\\Models\\' . $className)) {
            return 'App\\Models\\' . $className;
        } else {
            return str_replace(['_'], ['\\'], $className);
        }
    }

}
