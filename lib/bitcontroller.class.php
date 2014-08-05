<?php
abstract class BitController
{
    public function redirect($url)
    {
        header('Location: '.$url);
    }
}
