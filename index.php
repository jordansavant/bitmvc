<?php
function __autoload($class)
{
    $dir = dirname(__FILE__)."/";
    foreach(array($dir."lib/", $dir."model/", $dir."controller/") as $path)
    {
        $path = realpath($path);
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach($objects as $name => $object)
        {
            if(strpos(strtolower($name), strtolower("/$class.class.php")) !== false)
            {
                include($name);
            }
        }
    }
}

$bitmvc = new BitMvc();
$bitmvc->run();
