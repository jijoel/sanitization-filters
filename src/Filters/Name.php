<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;


class Name implements Filter
{
    public function apply($string, $options = [])
    {
        $delimiters = [" ","O'"];
        $exceptions = [];

        $title = new TitleCase($delimiters, $exceptions);

        return $title->apply($string, $options);
    }

}
