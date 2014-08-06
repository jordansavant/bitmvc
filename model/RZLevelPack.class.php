<?php

class RZLevelPack
{
    public function __construct($name = '')
    {
        $this->name = $name;
        $this->rzLevels = array();
    }

    const NODE_NAME = 'levels';
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
        foreach($nodes->levels as $levels)
        {
            foreach($levels as $level)
            {
                $rzLevel = new RZLevel();
                $rzLevel->fromXmlNode($level);
                $this->rzLevels[] = $rzLevel;
            }
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
<levelpack>
<levels>
</levels>
</levelpack>
XML;
        $levels = new SimpleXMLElement($xml);
        $file = RZConfig::getDataDirectory().$this->name;
        $levels->asXML($file);
    }

    public function save()
    {
        $root = new SimpleXMLElement('<levelpack><levels></levels></levelpack>');
        foreach($this->rzLevels as $rzLevel)
        {
            $levelNode = $root->levels->addChild(RZLevel::NODE_NAME);
            $levelNode = $rzLevel->fillNode($levelNode);
        }
        $file = RZConfig::getDataDirectory().$this->name;
        $root->asXML($file);
    }
}
