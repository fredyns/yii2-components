<?php

namespace fredyns\components\helpers;

/**
 * Description of IndentText
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class IndentationHelper
{

    /**
     * remove surrounding empty lines
     *
     * @param string $text
     * @return string
     */
    public static function stripLines($text)
    {
        $emptyLines[] = '/^( *\n)*/';
        $emptyLines[] = '/ *\n*$/';

        $text = preg_replace($emptyLines, '', $text);
        $text = preg_replace('/ *\n/', "\n", $text);

        return $text."\n";
    }

    public static function text($text, $indent = 1, $space = "    ")
    {
        if (is_array($text))
        {
            $text = implode("\n", $text);
        }
        elseif (is_string($text))
        {
            // remove surrounding empty line

            $text = static::stripLines($text);
        }

        if ($indent > 0)
        {
            // set indent to be added

            $indentation = "\n".str_repeat($space, $indent);

            // put indentation to every line

            $text = $indentation.str_replace("\n", $indentation, $text);
        }

        // result

        return $text;
    }

    public static function arrays($array, $indent = 1, $space = "    ")
    {
        $lines    = ['['];
        $keyWidth = ArrayHelper::keyWidth($array, $space);

        foreach ($array as $key => $value)
        {
            if (is_integer($key))
            {
                $lines[] = $space.$value;
            }
            elseif (is_string($key))
            {
                $infix   = str_repeat(' ', ($keyWidth - strlen($key)));
                $lines[] = $space.$key.$infix.'=> '.$value;
            }
        }

        $lines[] = ']';

        return static::text($lines, $indent, $space);
    }

}