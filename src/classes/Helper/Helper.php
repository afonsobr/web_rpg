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

    public static function getAttributeIcon(string $attr): string
    {
        if ($attr == 'vi') {
            return 'fa-virus';
        }
        if ($attr == 'va') {
            return 'fa-syringe';
        }
        if ($attr == 'da') {
            return 'fa-sim-card';
        }
        if ($attr == 'un') {
            return 'fa-question';
        }
        return 'fa-question';
    }

    public static function getElementIcon(string $element): string
    {
        $icon['neutral'] = 'minus';
        $icon['light'] = 'star-christmas';
        $icon['dark'] = 'moon';
        $icon['fire'] = 'fire';
        $icon['water'] = 'tint';
        $icon['ice'] = 'snowflake';
        $icon['wind'] = 'wind';
        $icon['steel'] = 'cog';
        $icon['nature'] = 'leaf';
        $icon['thunder'] = 'bolt';

        return 'fa-' . $icon[$element];
    }

    public static function getFamilyIcon(string $family): string
    {
        $family = strtolower($family);
        if ($family == 'nso') {
            return 'fa-skull-cow';
        }
        if ($family == 'nsp') {
            return 'fa-paw-claws';
        }
        if ($family == 'vb') {
            return 'fa-cross';
        }
        if ($family == 'dr') {
            return 'fa-dragon';
        }
        if ($family == 'ds') {
            return 'fa-dolphin';
        }
        if ($family == 'jt') {
            return 'fa-bug';
        }
        if ($family == 'me') {
            return 'fa-gears';
        }
        if ($family == 'wg') {
            return 'fa-dove';
        }
        if ($family == 'da') {
            return 'fa-eye-evil';
        }
        return 'fa-question';
    }

    public static function getEnemyClass(int $class): string
    {
        $classes = [
            1 => 'fa-b',
            2 => 'fa-v',
            3 => 'fa-e',
            4 => 'fa-l',
            5 => 'fa-h',
        ];

        // Retorna o valor correspondente ou o padrão 'fa-b' se não existir
        return $classes[$class] ?? 'fa-b';
    }

    public static function nFormat(int $n): string
    {
        return number_format($n, 0, ".", " ");
    }

    public static function getEquipmentSlotInfo(): array
    {
        return [
            'hat' => ['display' => 'Hat', 'icon' => 'head-side'],
            'headset' => ['display' => 'Headset', 'icon' => 'headphones'],
            'glasses' => ['display' => 'Glasses', 'icon' => 'glasses'],
            'hands' => ['display' => 'Hands', 'icon' => 'hand'],
            'jacket' => ['display' => 'Jacket', 'icon' => 'vest'],
            'upper_body' => ['display' => 'Upper Body', 'icon' => 'shirt'],
            'lower_body' => ['display' => 'Lower Body', 'icon' => 'pants'],
            'boots' => ['display' => 'Boots', 'icon' => 'boot'],
            'ring' => ['display' => 'Ring', 'icon' => 'ring-diamond'],
            'bracelet' => ['display' => 'Bracelet', 'icon' => 'ring'],
            'gem' => ['display' => 'Gem', 'icon' => 'dice-d10'],
            'backpack' => ['display' => 'Backpack', 'icon' => 'backpack'],
            'digivice' => ['display' => 'Digivice', 'icon' => 'mobile'],
            'chipset' => ['display' => 'Chipset', 'icon' => 'microchip'],
            'aura' => ['display' => 'Aura', 'icon' => 'spiral'],
        ];
    }
}
