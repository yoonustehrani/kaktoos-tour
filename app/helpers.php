<?php

define('SPACE', ' ');

if (! function_exists('slugify')) {
    function slugify(string $string): string {
        return str_replace(SPACE, '-', $string);
    }
}