<?php

class RZLevelPack
{
    public function __construct($name = '')
    {
        $this->name = $name;
        $this->rzLevels = array();
    }

    public $name;
    public $rzLevels;

    public function load()
    {
        $file = RZConfig::getDataDirectory().$this->name;
        if(!is_file($file)) throw new Exception("Cant load level pack: ".$file);
        $xml = file_get_contents($file);

        $nodes = new SimpleXMLElement($xml);
        foreach($nodes->levels as $level)
        {
            $rzLevel = new RZLevel();
            $rzLevel->fromXmlNode($level);
            $this->rzLevels[$rzLevel->id] = $rzLevel;
        }
    }

    public function toForm()
    {
        echo 'Name: <input type="text" name="name" value="'.$this->name.'" /><br />';
    }

    /**
     * Validates the state of the current instance
     */
    public function validate()
    {
        if(!$this->name)
        {
            throw new Exception("Name is required.");
        }
    }

    /**
     * Should only be run after validate
     * Creates an empy level pack file
     * in the data dir with the given name
     */
    public function save()
    {
        $xml = <<<XML
<levels>
</levels>
XML;
        $levels = new SimpleXMLElement($xml);
        $file = RZConfig::getDataDirectory().$this->name;
        $levels->asXML($file);
    }
}
