<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use Illuminate\Support\Str;


class LowerCase implements Filter
{
    public function apply($text, $options = [])
    {
        return Str::lower($text);
    }

}
