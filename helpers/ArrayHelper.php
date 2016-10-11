<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace fredyns\components\helpers;

/**
 * Description of ArrayHelper
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class ArrayHelper
{

    public static function keyLength($array)
    {
        $keys       = array_keys($array);
        $keyLengths = array_map(function($key)
        {
            return strlen($key);
        }, $keys);

        arsort($keyLengths);

        return array_shift($keyLengths);
    }

    public static function keyTab($array, $space = "    ", $tabsize = 4)
    {
        $length     = static::keyLength($array);
        $indentSize = ($space == "\t") ? $tabsize : strlen($space);
        $tabs       = ($length / $indentSize);
        $modulo     = ($length % $indentSize);

        return ($modulo == 0) ? ($tabs + 1) : ceil($tabs);
    }

    public static function keyWidth($array, $space = "    ", $tabsize = 4)
    {
        $indent = static::keyTab($array, $space);

        return $indent * $tabsize;
    }

}