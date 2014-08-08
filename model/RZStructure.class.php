<?php

class RZStructure extends RZBase
{
    public function __construct()
    {
        $this->items = $this->lights = array();
        $this->isOpen = $this->isLocked = '0';
    }

    # properties
    public $id;
    public $type;
    public $isOpen;
    public $isLocked;
    public $items;
    public $lights;

    public function getNodeName()
    {
        return 'structure';
    }

    public function fromXmlNode($node)
    {
        $this->id = (string)$node->id;
        $this->type = (string)$node->type;
        $this->isOpen = (string)$node->isOpen;
        $this->isLocked = (string)$node->isLocked;

        foreach($node->items as $items)
        {
            foreach($items as $item)
            {
                $rzItem = new RZItem();
                $rzItem->fromXmlNode($item);
                $this->items[] = $rzItem;
            }
        }
    }

    public function canForm($field)
    {
        return in_array($field, array('type', 'isOpen', 'isLocked'));
    }

    public function buildItemForm()
    {
        $s = "<div id='items$this->id'>";
        foreach($this->items as $item)
        {
        }
        $s .= "</div>";
        $s .= "<script>$('#items$this->id').append()</script>";
    }

    public function create($id)
    {
        $this->validate();
        $this->id = $id;
    }

    public function edit()
    {
        $this->validate();
    }

    public function validate()
    {
        if(!$this->validateUnsignedInt($this->type))
            throw new Exception("Type  must be a positive number");

        if(!$this->validateBool($this->isOpen))
            throw new Exception("isOpen must be 1 or 0");

        if(!$this->validateBool($this->isLocked))
            throw new Exception("isLocked must be 1 or 0");
    }
}

