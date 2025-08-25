<?php

if (!function_exists('addLanguageScript')) {
    /**
     * add language script
     *
     * @return void
     */
    function addLanguageScript(): void
    {
        DomiScript('assets/vendor/language/js/laravel-language.js');
    }
}
