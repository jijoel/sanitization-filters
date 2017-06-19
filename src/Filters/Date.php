<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use KDB\Utilities\DateTime\Date as SystemDate;
use Carbon\Carbon;


class Date implements Filter
{
    public function apply($string, $options = [])
    {
        if(is_object($string))
            return $string->format('Y-m-d H:i:s');

        if (strpos($string, 'T'))
            return substr($string, 0, strpos($string, 'T'));

        $date = new Carbon($string);

        return $date->startOfDay()
            ->format('Y-m-d H:i:s');
    }

}
