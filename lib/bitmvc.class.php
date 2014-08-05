<?php
class BitMvc
{
    public function __construct()
    {
        $this->rootDir = str_replace("/lib", "", dirname(__FILE__))."/";
        $this->libDir = dirname(__FILE__)."/";
        $this->modelDir = $this->rootDir."model/";
        $this->viewDir = $this->rootDir."view/";
        $this->controllerDir = $this->rootDir."controller/";
    }

    private $rootDir;
    private $libDir;
    private $modelDir;
    private $viewDir;
    private $controllerDir;

    public function run()
    {
        $controller = @$_GET['controller'];
        $operation = @$_GET['operation'];
        $controller = $controller ? $controller : @$_GET['c'];
        $operation = $operation ? $operation : @$_GET['o'];

        $class = trim(ucwords(strtolower($controller)));
        $method = trim(ucwords(strtolower($operation)));

        if(!$class)
            die('404 Controller');
        if(!$method)
          $method = 'index';

        $instance = new $class();
        $return = $instance->$method();

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
        ob_start();
        include $file;
        $c = ob_get_contents();
        ob_end_clean();
        return $c;
    }

}
