<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;


class Country implements Filter
{
    public function apply($string, $options = [])
    {
        if (strlen($string) == 2)
            return strtoupper($string);

        $delimiters = [" "];

        $exceptions = [
            'US'
        ];

        $title = new TitleCase($delimiters, $exceptions);

        return $title->apply($string, $options);
    }

}
