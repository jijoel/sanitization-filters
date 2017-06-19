<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;


class Address implements Filter
{
    public function apply($string, $options = [])
    {
        $delimiters = [" "];

        $exceptions = [
            'NE', 'NW', 'SE', 'SW'
        ];

        $title = new TitleCase($delimiters, $exceptions);

        return $title->apply($string, $options);
    }

}
