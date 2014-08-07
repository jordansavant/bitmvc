<?php
class LevelEditor extends BitController
{
    public function __construct()
    {
        $this->bitTemplate = 'primary';
    }

    public function index()
    {
        $dir = dirname(__FILE__)."/";
        $scan = scandir("$dir../data/");
        $this->files = array_diff($scan, array(".", ".."));
    }

    public function createLevelPack()
    {
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack();

        if(count($_POST))
        {
            $this->rzLevelPack->bind($_POST['RZLevelPack']);

            try {
                $this->rzLevelPack->create();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevelPack&lp=".$this->rzLevelPack->name);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editLevelPack()
    {
        $this->rzLevelPack = new RZLevelPack(@$_GET['lp']);
    }

    public function viewLevelPackSource()
    {
        $this->rzLevelPack = new RZLevelPack(@$_GET['lp']);
    }

    public function createLevel()
    {
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack(@$_GET['lp']);
        $this->rzLevel = new RZLevel();

        if(count($_POST))
        {
            $this->rzLevel->bind($_POST['RZLevel']);

            try {
                $newId = count($this->rzLevelPack->levels) + 1;
                $this->rzLevel->create($newId);
                $this->rzLevelPack->levels[] = $this->rzLevel;
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editLevel()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
    }

    public function createTile()
    {
        $this->error = '';
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->index = $_GET['index'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzTile = new RZTile();

        if(count($_POST))
        {
            $this->rzTile->bind($_POST['RZTile']);

            try {
                $newId = count($this->rzLevel->tiles) + 1;
                $this->rzTile->create($newId);
                $this->rzLevel->addTileAtIndex($this->rzTile, $this->index);
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editTile()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->tid = $_GET['tid'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzTile = $this->rzLevel->getTileById($this->tid);

        if(count($_POST))
        {
            $this->rzTile->bind($_POST['RZTile']);

            try {
                $this->rzTile->edit();
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }

    }

}

