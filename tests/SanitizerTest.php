<?php

use Waavi\Sanitizer\Sanitizer;
use PHPUnit\Framework\TestCase;


class SanitizerTest extends TestCase
{
    protected $customFilters;

    public function setUp() : void
    {
        $this->customFilters = [
            'alpha' => \Jijoel\Sanitizer\Filters\Alphabetic::class,
            'address' => \Jijoel\Sanitizer\Filters\Address::class,
            'cast' => \Jijoel\Sanitizer\Filters\Cast::class,
            'country' => \Jijoel\Sanitizer\Filters\Country::class,
            'date' => \Jijoel\Sanitizer\Filters\Date::class,
            'limit' => \Jijoel\Sanitizer\Filters\Limit::class,
            'lower' => \Jijoel\Sanitizer\Filters\LowerCase::class,
            'money' => \Jijoel\Sanitizer\Filters\Money::class,
            'name' => \Jijoel\Sanitizer\Filters\Name::class,
            'number' => \Jijoel\Sanitizer\Filters\Number::class,
            'phone' => \Jijoel\Sanitizer\Filters\Phone::class,
            'proper' => \Jijoel\Sanitizer\Filters\TitleCase::class,
            'state' => \Jijoel\Sanitizer\Filters\State::class,
            'strip' => \Jijoel\Sanitizer\Filters\Strip::class,
            'title-case' => \Jijoel\Sanitizer\Filters\TitleCase::class,
            'upper' => \Jijoel\Sanitizer\Filters\UpperCase::class,
            'zip' => \Jijoel\Sanitizer\Filters\Zip::class,
        ];
    }

    /**
     * @test
     * @dataProvider getTestData
     */
    public function data_is_correctly_sanitized(
        $test_rules, $test_data, $expected
    ){
        $data = [
            'test' => $test_data
        ];
        $filters = [
            'test' => $test_rules
        ];

        $sanitizer = new Sanitizer($data, $filters, $this->customFilters);
        $result = $sanitizer->sanitize();

        // This is how to run it with a Laravel facade:
        // $result = Sanitizer::make($data, $rules)
        //     ->sanitize();

        $this->assertSame($expected, $result['test']);
    }

    public function getTestData()
    {
        return array(
            ['alpha', 'x', 'x'],
            ['alpha', '1', ''],
            ['alpha', '1a', 'a'],
            ['alpha', '1a x', 'a x'],

            ['address', 'x sw', 'X SW'],
            ['address', 'x nw x', 'X NW X'],
            ['address', 'x Se x', 'X SE X'],
            ['address', 'x NE x', 'X NE X'],
            ['address', 'x nesw x', 'X Nesw X'],
            ['address', '128 ne foo st. #4', '128 NE Foo St. #4'],

            ['country', 'x', 'X'],
            ['country', 'xx', 'XX'],
            ['country', 'canada', 'Canada'],
            ['country', 'CANADA', 'Canada'],
            ['country', 'trinidad and tobago', 'Trinidad and Tobago'],
            ['country', 'us minor outlying islands', 'US Minor Outlying Islands'],

            ['date', 'Feb 14, 2017', '2017-02-14 00:00:00'],
            ['date', '2017-02-14T10:00:00.000Z', '2017-02-14'],
            ['date', new \DateTime('2/14/2017'), '2017-02-14 00:00:00'],
            ['date', new \Carbon\Carbon('2/14/2017'), '2017-02-14 00:00:00'],

            ['limit:5', '123456789', '12345'],
            ['limit:5,...', '123456789', '12345...'],

            ['lower', 'X X', 'x x'],

            ['money', "123.4567", 123.45],

            ['name', 'b b b', 'B B B'],
            ['name', 'b bb', 'B Bb'],
            ['name', 'bbb', 'Bbb'],
            ['name', 'foo bar', 'Foo Bar'],
            ['name', 'king henry vii', 'King Henry VII'],
            ['name', 'pope john xxiv', 'Pope John XXIV'],
            ['name', 'foo o\'bar', 'Foo O\'Bar'],

            ['number', 'xxx', 0],
            ['number', '123a', 123],
            ['number', '12.3a', 12.3],
            ['number', '-123a', -123],
            ['number', '(123a)', -123],
            ['number', 'ax1sa2s3a', 123],

            ['title-case', 'a simple test', 'A Simple Test'],
            ['title-case', 'people like us', 'People Like Us'],

            ['lowercase', 'J@c.com', 'j@c.com'],

            ['phone', '+01 11 1234', '+01 11 1234'],
            ['phone', '01 11 1234', '01 11 1234'],
            ['phone', '9990000', '999-0000'],
            ['phone', '999.0000', '999-0000'],
            ['phone', '999 0000', '999-0000'],
            ['phone', '8089990000', '808-999-0000'],
            ['phone', '808 999 0000', '808-999-0000'],
            ['phone', '808.999.0000', '808-999-0000'],
            ['phone', '(808) 999-0000', '808-999-0000'],
            ['phone', '(808) 999-0000 extension 34', '808-999-0000 x34'],
            ['phone', '18089990000', '808-999-0000'],
            ['phone', '1 (808) 999-0000', '808-999-0000'],
            ['phone', '1.808.999.0000', '808-999-0000'],
            ['phone', '808-999-0000 ext 24', '808-999-0000 x24'],
            ['phone', '808-999-0000 x 24', '808-999-0000 x24'],
            ['phone', '+14155552671', '415-555-2671'],
            ['phone', 'none',''],
            ['phone', '',''],

            ['proper', 'people like us', 'People Like Us'],
            ['proper', 'this is a test', 'This Is a Test'],

            ['state', 'x', 'X'],
            ['state', 'xx', 'XX'],
            ['state', 'xxx', 'Xxx'],
            ['state', 'US.HI', 'HI'],
            ['state', 'US.hi', 'HI'],
            ['state', 'us.hi', 'HI'],

            ['strip', "'Foo'", ' Foo '],
            ['strip', 'Foo;', 'Foo'],
            ['strip', 'Foo?', 'Foo'],
            ['strip', 'Foo--', 'Foo-'],
            ['strip', 'Foo<', 'Foo'],
            ['strip', 'Foo>', 'Foo'],
            ['strip', 'Foo&', 'Foo and'],
            ['strip', 'Foo/', 'Foo'],

            ['upper', 'us.hi', 'US.HI'],

            ['zip', '96778', '96778'],
            ['zip', '96778a', '96778a'],
            ['zip', '96778 4481', '96778-4481'],
            ['zip:GB', '123456789', '123456789'],
            ['zip:bk', 'foo123456789', 'foo123456789'],

            // Multiple filters
            ['trim|limit:4', '  testing  ', 'test'],
            ['escape|name', '<strong>DOE</strong>', 'Doe'],

            // Standard filters
            ['capitalize', 'This is a test', 'This Is A Test'],
            ['escape', '<div>one test</div>', 'one test'],
            ['escape', '<h2>one test</h2>', 'one test'],
            ['escape', '\'-- 31337', '&#39;-- 31337'],
            ['lowercase', 'One Test', 'one test'],
            ['uppercase', 'one test', 'ONE TEST'],
            ['trim', ' one test  ', 'one test'],
            ['trim|escape|lower', '  JOHn@DoE.com', 'john@doe.com'],
        );
    }

}
