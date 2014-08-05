<?php

class RZLevel
{
    public function __Construct()
    {
    }

    public $id;
    public $title;

    public function fromXmlNode($node)
    {
        $this->id = $node->id;
        $this->title = $node->title;
    }

    public function toForm()
    {
        $s = 'Id: <input type="text" name="'.__CLASS__.'[id]" value="'.$this->id.'" /><br />';
        $s .= 'Title: <input type="text" name="'.__CLASS__.'[title]" value="'.$this->title.'" /><br />';
        return $s;
    }
}
