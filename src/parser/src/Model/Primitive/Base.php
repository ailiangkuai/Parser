<?php

namespace WhichBrowser\Model\Primitive;

class Base
{
    public function __construct($defaults = null)
    {
        if (is_array($defaults)) {
            foreach ($defaults as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    public function toJavaScript()
    {
        $lines = [];

        foreach ($this as $key => $value) {
            if (!is_null($value)) {
                $line = $key . ": ";

                if ($key == 'version') {
                    $line .= 'new Version({ ' . $value->toJavaScript() . ' })';
                } elseif ($key == 'family') {
                    $line .= 'new Family({ ' . $value->toJavaScript() . ' })';
                } elseif ($key == 'using') {
                    $line .= 'new Using({ ' . $value->toJavaScript() . ' })';
                } else {
                    switch (gettype($value)) {
                        case 'boolean':
                            $line .= $value ? 'true' : 'false';
                            break;
                        case 'string':
                            $line .= '"' . addslashes($value) . '"';
                            break;
                        case 'integer':
                            $line .= $value;
                            break;
                    }
                }

                $lines[] = $line;
            }
        }

        return implode($lines, ", ");
    }
}
