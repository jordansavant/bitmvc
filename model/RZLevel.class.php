<?php

class RZLevel
{
    public function __Construct()
    {
    }

    const NODE_NAME = 'level';
    public $id;
    public $title;

    public function fromXmlNode($node)
    {
        $this->id = (string)$node->id;
        $this->title = (string)$node->title;
    }

    public function fillNode($node)
    {
        $node->addChild('id', $this->id);
        $node->addChild('title', $this->title);

        return $node;
    }

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

    public function toForm()
    {
        $s = 'Id: <input type="text" name="'.__CLASS__.'[id]" value="'.$this->id.'" /><br />';
        $s .= 'Title: <input type="text" name="'.__CLASS__.'[title]" value="'.$this->title.'" /><br />';
        return $s;
    }

    public function create()
    {
        # Validate
        if(!$this->title || !$this->id)
        {
            throw new Exception("Title and ID is required");
        }
    }
}
