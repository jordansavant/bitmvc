<?php

abstract class RZBase
{
    public function bind($array)
    {
        foreach($array as $key => $value)
        {
            if(property_exists($this, $key))
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
            var_dump($value);
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


    public function toForm()
    {
        $s = '';
        foreach($this as $key => $value)
        {
            if($value instanceof RZBase)
            {
                # recursion not tested
                #$s .= $value->toForm();
            }
            elseif(!is_array($value) && !is_object($value))
            {
                $s .= (string)$value;
                $s .= $key.': <input type="text" name="'.get_called_class().'['.$key.']" value="'.$value.'" /><br />';
            }
        }
        return $s;
    }

}
