<?php

class RZStructure extends RZBase
{
    public function __construct()
    {
        $this->items = $this->lights = array();
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

    public function canForm($field)
    {
        return in_array($field, array('type', 'isOpen', 'isLocked'));
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

