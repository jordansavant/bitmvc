<?php

class RZTile extends RZBase
{
    public function __construct()
    {
        $this->enterEvents = $this->exitEvents = $this->entrances = array();
    }

    # properties
    public $id;
    public $type;
    public $enterEvents;
    public $exitEvents;
    public $entrances;

    public function getNodeName()
    {
        return 'tile';
    }

    public function fromXmlNode($node)
    {
        $this->id = (string)$node->id;
        $this->type = (string)$node->type;

        foreach($node->exitEvents as $exitEvents)
        {
            foreach($exitEvents as $event)
            {
                $rzEvent = new RZEvent();
                $rzEvent->fromXmlNode($event);
                $this->exitEvents[] = $rzEvent;
            }
        }

        foreach($node->enterEvents as $enterEvents)
        {
            foreach($enterEvents as $event)
            {
                $rzEvent = new RZEvent();
                $rzEvent->fromXmlNode($event);
                $this->enterEvents[] = $rzEvent;
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
        {
            throw new Exception("Type  must be a positive number");
        }
    }
}

