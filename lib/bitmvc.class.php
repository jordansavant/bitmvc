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
