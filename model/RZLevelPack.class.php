<?php

class RZLevelPack extends RZBase
{
    public function __construct($name = '')
    {
        $this->name = $name;
        $this->version = RZConfig::getVersion();
        $this->levels = array();

        if($this->name)
        {
            $this->load();
        }
    }

    public $version;
    public $name;
    public $levels;

    public function getNodeName()
    {
        return 'levels';
    }

    public function getLevelById($id)
    {
        return $this->levels[$id - 1];
    }

    public function getXmlSource()
    {
        $file = RZConfig::getDataDirectory().$this->name;
        if(!is_file($file)) throw new Exception("Cant load level pack: ".$file);
        $xml = file_get_contents($file);
        $simple_xml = new SimpleXMLElement($xml);
        $dom = dom_import_simplexml($simple_xml)->ownerDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        return $dom->saveXML();
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
                $this->levels[] = $rzLevel;
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
        # $root->asXML($file);
        $dom = dom_import_simplexml($root)->ownerDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        file_put_contents($file, $dom->saveXML());
    }
}
