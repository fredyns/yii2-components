<?php

namespace fredyns\components\widgets;

/**
 * generate text with indentation
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property string $indentChar generate indent character
 * @property string $indentation generate indentation for text
 */
class IndentedText extends \yii\base\Widget
{
    const TYPE_TAB   = 'tab';
    const TYPE_SPACE = 'space';

    // configuration
    public $type           = 'space';
    public $spacePerIndent = 4;
    public $newline        = "\n";
    // variables
    public $indentLevel    = 0;
    public $data           = [];
    public $startnewline   = false;

    public function getIndentChar()
    {
        if ($this->type == static::TYPE_TAB)
        {
            return '\t';
        }

        if ($this->type == static::TYPE_SPACE)
        {
            return str_repeat(' ', $this->spacePerIndent);
        }

        return '';
    }

    public function getIndentation()
    {
        return str_repeat($this->indentChar, $this->indentLevel);
    }

    public function getLine($index, $data)
    {
        $pattern_simple  = (is_integer($index) && is_string($data));
        $pattern_empty   = (is_integer($index) && empty($data));
        $pattern_subline = (is_string($index) && $index);

        if ($pattern_simple)
        {
            return $this->indentation.$data.$this->newline;
        }
        elseif ($pattern_empty)
        {
            return $this->indentation.$this->newline;
        }

        if ($pattern_subline)
        {
            $line = $this->indentation.$index.$this->newline;
            $line .= $this->indentation.'{'.$this->newline;

            if (is_scalar($data))
            {
                $line .= $this->indentation.$this->indentChar.$data.$this->newline;
            }
            elseif (is_array($data))
            {
                $line .= static::widget([
                        'type'           => $this->type,
                        'spacePerIndent' => $this->spacePerIndent,
                        'newline'        => $this->newline,
                        'indentLevel'    => $this->indentLevel + 1,
                        'data'           => $data,
                ]);
            }

            $line .= $this->indentation.'}'.$this->newline;

            return $line;
        }

        return $this->newline;
    }

    public function getText()
    {
        $text = $this->startnewline ? $this->newline : '';

        foreach ($this->data as $lineIndex => $lineData)
        {
            $text .= $this->getLine($lineIndex, $lineData);
        }

        return $text;
    }

    public function run()
    {
        if (is_scalar($this->data))
        {
            return $this->newline.$this->indentation.$this->data;
        }
        elseif (is_array($this->data))
        {
            return $this->getText();
        }

        return $this->newline;
    }

}