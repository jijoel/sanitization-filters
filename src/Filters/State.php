<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use Illuminate\Support\Str;


class State implements Filter
{
    public function apply($text, $options = [])
    {
        if (mb_strpos($text, '.') == 2)
            $text = Str::substr($text, 3);

        if (Str::length($text) == 2)
            return Str::upper($text);

        return Str::title($text);
    }

}
