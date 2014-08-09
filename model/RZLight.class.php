<?php

class RZLight extends RZBase
{
    # properties
    public $id;
    public $radius;
    public $red;
    public $green;
    public $blue;
    public $brightness;

    public function getNodeName()
    {
        return 'light';
    }

    public function canForm($field)
    {
        return $field != 'id';
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
        if(!$this->validateUnsignedInt($this->radius))
            throw new Exception("radius must be positive");

        if(!$this->validate255($this->red))
            throw new Exception("red must be between 0 and 255");
        if(!$this->validate255($this->green))
            throw new Exception("green must be between 0 and 255");
        if(!$this->validate255($this->blue))
            throw new Exception("blue must be between 0 and 255");

        if(!$this->validate01Range($this->brightness))
            throw new Exception("brightness must be between 0 and 1");
    }
}

