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

    public function getXmlSource()
    {
        $file = RZConfig::getDataDirectory().$this->name;
        if(!is_file($file)) throw new Exception("Cant load level pack: ".$file);
        return file_get_contents($file);
    }

    public function load()
    {
        $xml = $this->getXmlSource();

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
        return 'Name: <input type="text" name="name" value="'.$this->name.'" /><br />';
    }

    public function create()
    {
        # Valdiate
        if(!$this->name)
        {
            throw new Exception("Name is required.");
        }

        # Create
        $xml = <<<XML
<levels>
</levels>
XML;
        $levels = new SimpleXMLElement($xml);
        $file = RZConfig::getDataDirectory().$this->name;
        $levels->asXML($file);
    }
}
