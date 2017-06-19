<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use Illuminate\Support\Str;
use InvalidArgumentException;


class Limit implements Filter
{
    public function apply($text, $options = [])
    {
        if (sizeof($options) == 0)
            throw new InvalidArgumentException('A length is required for limit filters');

        $length = $options[0];
        $end = isset($options[1]) ? $options[1] : '';

        return Str::limit($text, $length, $end);
    }

}
