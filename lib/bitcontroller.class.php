<?php
abstract class BitController
{
    public function redirect($url)
    {
        header('Location: '.$url);
    }

    public function processView($file, $args, $C, $O)
    {
        # Get the view
        ob_start();
        include $file;
        $c = ob_get_contents();
        ob_end_clean();
        return $c;
    }
}
