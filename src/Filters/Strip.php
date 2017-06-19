<?php namespace Jijoel\Sanitizer\Filters;

use Illuminate\Support\Str;
use Waavi\Sanitizer\Contracts\Filter;


class Strip implements Filter
{

    private $illegals = [
        '\'' => ' ',  // TODO: remove when we leave Access
        '?' => '',
        ';' => '',
        '--' => '-',
        '<' => '',
        '>' => '',
        '/' => '',
        '&' => ' and'
    ];


    public function apply($string, $options = [])
    {
        foreach($this->illegals as $illegal => $replacement) {
            $string = str_replace(
                $illegal,
                $replacement ?: '',
                $string
            );
        }

        return $string;
    }

}
