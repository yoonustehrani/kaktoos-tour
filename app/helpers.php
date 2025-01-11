<?php

define('SPACE', ' ');

function slugify(string $string): string {
    return str_replace(SPACE, '-', $string);
}