<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use Illuminate\Support\Str;


class Phone implements Filter
{
    public function apply($text, $options = [])
    {
        if (! $text)
            return '';

        if ($this->isInternationalNumber($text))
            return $text;

        $text = $this->swapCommonStyles($text);

        if (! $text)
            return '';

        $pos = strpos($text, 'x');
        $ext = ($pos === false) ? '' : ' '.substr($text, $pos);
        $phone = ($pos === false) ? $text : substr($text,0,$pos);

        if (Str::length($phone) == 10)
            return Str::substr($phone, 0, 3)
                . '-' . Str::substr($phone, 3, 3)
                . '-' . Str::substr($phone, 6)
                . $ext;

        return Str::substr($phone, 0, 3)
            . '-' . Str::substr($phone, 3)
            . $ext;
    }

    private function isInternationalNumber($text)
    {
        return Str::substr($text,0,2) == '+0'
            || $text[0] == '0';
    }

    private function swapCommonStyles($text)
    {
        // Remove anything but numbers and x:
        // (808) 391-6682 ext 41 -> 808-391-6682x41
        $text = preg_replace('/[^0-9x]/','', $text);

        // Remove a 1 from the beginning:
        // 1-808-391-6682 -> 808-391-6682
        $text = preg_replace('/^1?/','', $text);

        return $text;
    }

    private function getExtension($text)
    {
        $pos = strpos($text, 'x');

        return ($pos === false) ? '' : ' '.substr($text, $pos);
    }
}
