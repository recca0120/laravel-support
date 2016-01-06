<?php

if (function_exists('human_filesize') === false) {
    function humanFilesize($size, $precision = 2)
    {
        Helper::human_filesize($size, $precision);
    }
}
