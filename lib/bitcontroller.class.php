<?php
abstract class BitController
{
    public function __construct($bitmvc)
    {
        $this->bitmvc = $bitmvc;
    }

    public $bitmvc;

    public function redirect($url)
    {
        header('Location: '.$url);
    }

    public function processView($bitmvc, $file, $C, $O)
    {
        # Get the view
        ob_start();
        include $file;
        $view = ob_get_contents();
        ob_end_clean();

        # See if there is a core template
        $final = '';
        if(isset($this->bitTemplate))
        {
            $template = strtolower($bitmvc->viewDir . 'template/' . get_called_class() . '.' . $this->bitTemplate . '.php');
            if(is_file($template))
            {
                $final = function($C, $O, $template) {
                    ob_start();
                    include $template;
                    $r = ob_get_contents();
                    ob_end_clean();
                    return $r;
                };
                $final = $final($C, $O, $template);

                if(preg_match_all('/##start-(?P<slot>[\a-zA-Z0-9]+)##(?P<content>.*?)##end##/is', $view, $matches))
                {
                    $view = preg_replace('/##start-(?P<slot>[\a-zA-Z0-9]+)##(?P<content>.*?)##end##/is', '', $view);
                    $slots = $matches['slot'];
                    $contents = $matches['content'];
                    foreach($slots as $i => $slot)
                    {
                        $content = trim($contents[$i]);
                        $final = str_replace("##$slot##", $content, $final);
                    }
                }

                $final = str_replace('##content##', trim($view), $final);
                $final = preg_replace('/##[\w]+##/', '', $final);
            }
        }
        else
        {
            $final = $view;
        }

        return $final;
    }

    public function loadRecurrence($name, $args)
    {
        $final = '';
        $file = strtolower($this->bitmvc->viewDir . 'recurrence/'.$name.'.php');
        if(is_file($file))
        {
            $final = function($file, $args) {
                ob_start();
                include $file;
                $r = ob_get_contents();
                ob_end_clean();
                return $r;
            };
            $final = $final($file, $args);
        }

        return $final;
    }
}
