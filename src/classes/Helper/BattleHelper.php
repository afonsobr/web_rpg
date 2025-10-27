<?php
namespace TamersNetwork\Helper;

class BattleHelper
{
    public static function checkAttributeAdvantage(string $a_attr, string $b_attr): float
    {
        // Valores centrais para fácil ajuste
        $MULT_EQUAL = 1.0;        // empate
        $MULT_ADVANTAGE = 1.5;    // A vence B
        $MULT_DISADVANTAGE = 0.5; // A perde para B
        $MULT_UK = 2.0;           // uk vence todos
        $MULT_NO = 0.5;           // no perde para todos

        // Igualdade
        if ($a_attr === $b_attr) {
            return $MULT_EQUAL;
        }

        // Atributos especiais
        if ($a_attr === 'uk')
            return $MULT_UK;   // A vence todos
        if ($b_attr === 'uk')
            return $MULT_DISADVANTAGE;   // A perde para uk
        if ($a_attr === 'no')
            return $MULT_NO;   // no perde para todos
        if ($b_attr === 'no')
            return $MULT_UK;   // tudo vence no

        // Vantagem normal
        $advantageMap = [
            'va' => 'vi',
            'vi' => 'da',
            'da' => 'va',
        ];

        if (isset($advantageMap[$a_attr]) && $advantageMap[$a_attr] === $b_attr) {
            return $MULT_ADVANTAGE; // A vence B
        }

        if (isset($advantageMap[$b_attr]) && $advantageMap[$b_attr] === $a_attr) {
            return $MULT_DISADVANTAGE; // A perde para B
        }

        return $MULT_EQUAL; // neutro
    }


}
