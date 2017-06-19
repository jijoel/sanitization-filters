<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use Illuminate\Support\Str;


class UpperCase implements Filter
{
    public function apply($text, $options = [])
    {
        return Str::upper($text);
    }

}
