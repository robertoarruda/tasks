<?php

echo implode('<br>', Q1::printNumbers());

class Q1
{
    public static function printNumbers($from = 1, $to = 100)
    {
        $numbers = array();

        for ($number = $from; $number <= $to; $number++) {
            $numbers[] = self::parseMultiples($number);
        }

        return $numbers;
    }

    private static function parseMultiples($number)
    {
        if (empty($number)) {
            return 0;
        }

        $response = self::isMultiple3($number) ? 'Fizz' : '';
        $response .= self::isMultiple5($number) ? 'Buzz' : '';

        return $response ?: $number;
    }

    private static function isMultiple3($number)
    {
        if (!is_numeric($number)) {
            return false;
        }

        return ($number % 3 == 0);
    }

    private static function isMultiple5($number)
    {
        if (!is_numeric($number)) {
            return false;
        }

        return ($number % 5 == 0);
    }
}
