<?php

abstract class RZBase
{
    public function bind($array)
    {
        foreach($array as $key => $value)
        {
            if(property_exists($this, $key) && $this->canForm($key))
            {
                $this->$key = $value;
            }
        }
    }

    public function fromXmlNode($node)
    {
        foreach($this as $key => $value)
        {
            $this->$key = (string)$node->$key;
        }
    }

    public function fillNode($node)
    {
        foreach($this as $key => $value)
        {
            self::populateNode($key, $value, $node);
        }
    }

    private static function populateNode($key, $value, $node)
    {
        # If another model
        if($value instanceof RZBase)
        {
            $new = $node->addChild($value->getNodeName());
            $value->fillNode($new);
        }
        # If a collection
        elseif(is_array($value))
        {
            $new = $node->$key ? $node->$key : $node->addChild($key);
            foreach($value as $value)
            {
                self::populateNode($key, $value, $new);
            }
        }
        # If a property
        else
        {
            $node->addChild($key, (string)$value);
        }
    }


    public function toForm($only = array())
    {
        $s = '';
        foreach($this as $key => $value)
        {
            if(!$this->canForm($key))
                continue;

            $hidden = (is_array($only) && !empty($only) && !in_array($key, $only));

            if($value instanceof RZBase)
            {
                # recursion not tested
                #$s .= $value->toForm();
            }
            elseif(!is_array($value) && !is_object($value))
            {
                if($hidden)
                {
                    $s .= '<input type="hidden" name="'.get_called_class().'['.$key.']" value="'.$value.'" />';
                }
                else
                {
                    if($key == 'type')
                    {
                        $s .= '<label class="formLabel">'.$key.':</label> ';
                        $method = 'build'.str_replace('RZ', '', get_called_class()).'DD';
                        if(method_exists('RZConfig', $method))
                        {
                            $s .= RZConfig::$method(get_called_class().'['.$key.']', $value).'<br />';
                        }
                    }
                    else
                    {
                        $s .= '<label class="formLabel">'.$key.':</label> <input type="text" name="'.get_called_class().'['.$key.']" value="'.$value.'" /><br />';
                    }
                }
            }
        }
        return $s;
    }

    public function canForm($field)
    {
        return true;
    }

    public function validateUnsignedInt($value, $positive = true)
    {
        return is_numeric($value) && (int)$value == $value && (($positive && $value > 0) || (!$positive && $value >= 0));
    }

    public function validateBool($value)
    {
        return (string)$value == '1' || (string)$value == '0';
    }

    public function validate255($value)
    {
        return $this->validateUnsignedInt($value, false) && $value < 256;
    }

    public function validate01Range($value)
    {
        return is_numeric($value) && $value >= 0 && $value <= 1;
    }

}
