<?php
namespace TamersNetwork\Helper;

class Helper
{
    public static function formatCoin(int $coin): string
    {
        if ($coin <= 0) {
            return '0';
        }

        // sempre 3 blocos fixos: T, M, B
        $b = $coin % 1000;
        $coin = intdiv($coin, 1000);

        $m = $coin % 1000;
        $coin = intdiv($coin, 1000);

        $t = $coin; // tudo que sobrar fica em T

        $result = [];
        if ($t > 0) {
            $result[] = $t . 'T';
        }
        if ($m > 0 || $t > 0) { // mostra M se tiver ou se já teve T
            $result[] = $m . 'M';
        }
        $result[] = $b . 'B';

        return implode(' ', $result);
    }

    public static function formatCoinClassic(float|int $num, int $decimals = 1): string
    {
        if ($num < 1000) {
            return (string) $num;
        }

        $units = ['', 'k', 'M', 'B', 'T', 'Q'];
        // pode continuar a lista se quiser mais: Quintilhões, etc.

        $power = floor(log($num, 1000));
        $power = min($power, count($units) - 1);

        $value = $num / pow(1000, $power);

        return number_format($value, $decimals) . $units[$power];
    }

}
