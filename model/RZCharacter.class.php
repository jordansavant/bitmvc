<?php

class RZCharacter extends RZBase
{
    public function __construct()
    {
        $this->equipment = $this->items = $this->lights = array();
    }

    # properties
    public $id;
    public $type;
    public $items;
    public $lights;
    public $equipment;

    public function getNodeName()
    {
        return 'character';
    }

    public function fromXmlNode($node)
    {
        $this->id = (string)$node->id;
        $this->type = (string)$node->type;

        foreach($node->items as $items)
        {
            foreach($items as $item)
            {
                $rzItem = new RZItem();
                $rzItem->fromXmlNode($item);
                $this->items[] = $rzItem;
            }
        }

        foreach($node->lights as $lights)
        {
            foreach($lights as $light)
            {
                $rzLight = new RZLight();
                $rzLight->fromXmlNode($light);
                $this->lights[] = $rzLight;
            }
        }

        foreach($node->equipment as $items)
        {
            foreach($items as $item)
            {
                $rzItem = new RZItem();
                $rzItem->fromXmlNode($item);
                $this->equipment[] = $rzItem;
            }
        }

    }

    public function canForm($field)
    {
        return in_array($field, array('type'));
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
    }
}

