<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;


class Money implements Filter
{
    public function apply($value, $options = [])
    {
        return floor($value * 100) / 100;
    }
}
