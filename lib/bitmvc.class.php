<?php
function __autoload($class)
{
    $dir = dirname(__FILE__)."/../";
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

class BitMvc
{
    public function __construct()
    {
        $this->rootDir = str_replace("/lib", "", dirname(__FILE__))."/";
        $this->libDir = dirname(__FILE__)."/";
        $this->modelDir = $this->rootDir."model/";
        $this->viewDir = $this->rootDir."view/";
        $this->controllerDir = $this->rootDir."controller/";

        $this->activeController = '';
        $this->activeOperation = '';
    }

    private $rootDir;
    private $libDir;
    private $modelDir;
    private $viewDir;
    private $controllerDir;
    private $activeController;
    private $activeOperation;

    public function run()
    {
        # Get controller class and opertaion from url
        $controller = @$_GET['controller'];
        $operation = @$_GET['operation'];
        $controller = $controller ? $controller : @$_GET['c'];
        $operation = $operation ? $operation : @$_GET['o'];
        $class = trim(ucwords(strtolower($controller)));
        $method = trim(ucwords(strtolower($operation)));

        # Validate url parse
        if(!$class)
            $this->HTTP404Controller();
        if(!$method)
            $method = 'index';

        # Get and validate the controller
        if (class_exists($class, $autoload = true)) {
            $instance = new $class();
        } else {
            $this->HTTP404Controller();
        }
        if(!$instance instanceof BitController)
            $this->HTTP404Controller();
        if(!method_exists($instance, $method))
            $this->HTTP404Operation();

        # Run the controller
        $this->activeController = $class;
        $this->activeOperation = $method;
        $return = $instance->$method();

        # Get the view
        $content = '';
        $template = strtolower($this->viewDir."$class.$method.php");
        if(is_file($template))
        {
            $content = $this->runTemplate($template, $return);
        }
        echo $content;
    }

    private function runTemplate($file, $args = null)
    {
        # Set some template variables
        $C = $controller = $this->activeController;
        $O = $operation = $this->activeOperation;

        # Get the view
        ob_start();
        include $file;
        $c = ob_get_contents();
        ob_end_clean();
        return $c;
    }

    private function HTTP404($message = '')
    {
        die('404: '.$message);
    }

    private function HTTP404Controller()
    {
        die('404 Controller');
    }

    private function HTTP404Operation()
    {
        die('404 Operation');
    }

}
