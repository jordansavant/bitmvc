<?php

class RZLevelPack extends RZBase
{
    public function __construct($name = '')
    {
        $this->name = $name;
        $this->rzLevels = array();

        if($this->name)
        {
            $this->load();
        }
    }

    public $name;
    public $rzLevels;

    public function getNodeName()
    {
        return 'levels';
    }

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
        foreach($nodes->rzLevels as $levels)
        {
            foreach($levels as $level)
            {
                $rzLevel = new RZLevel();
                $rzLevel->fromXmlNode($level);
                $this->rzLevels[] = $rzLevel;
            }
        }
        #echo "<pre>".htmlentities(print_r($this, 1))."</pre>";
    }

    public function create()
    {
        # Valdiate
        if(!$this->name)
        {
            throw new Exception("Name is required.");
        }

        # Create
        $this->save();
    }

    public function save()
    {
        $root = new SimpleXMLElement('<levelpack></levelpack>');
        $this->fillNode($root);
        $file = RZConfig::getDataDirectory().$this->name;
        $root->asXML($file);
    }
}
