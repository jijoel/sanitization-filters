<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;

/**
 * adapted from https://gist.github.com/ahmednuaman/1297873
 */
class TitleCase implements Filter
{
    protected $delimiters;
    protected $exceptions;

    function __construct(
        $delimiters=[], $exceptions=[]
    ){
        $this->delimiters = array_merge(
            [" ", "-"],
            $delimiters
        );

        $this->exceptions = array_merge(
            [
                "a", "an", "the",
                "at", "by", "for",
                "in", "of", "on",
                "to", "up", "and",
                "as", "but", "or",
                "nor"
            ],
            $exceptions
        );
    }

    public function apply($string, $options = [])
    {
        $delimiters = $this->delimiters;
        $exceptions = $this->exceptions;

       /*
        * Exceptions in lower case are words we don't want converted
        * Exceptions all in upper case are any words we don't want converted to title case
        *   but should be converted to upper case, e.g.:
        *   king henry viii or king henry Viii should be King Henry VIII
        */
        $string = strtolower($string);
        foreach ($delimiters as $delimiter){
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $word){
                if (in_array(strtoupper($word), $exceptions)){
                    // check exceptions list for any words that should be in upper case
                    $word = strtoupper($word);
                } elseif ($this->isRomanNumeral($word)) {
                    $word = strtoupper($word);
                } elseif (!in_array($word, $exceptions)){
                    // convert first letter to uppercase
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }
        return $string;
    }

    private function isRomanNumeral($word)
    {
        return preg_match(
            '/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/',
            strtoupper($word)
        ) === 1;
    }

}
