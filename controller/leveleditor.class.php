<?php
class LevelEditor extends BitController
{
    /**
     * List all levels that it can find
     * in the levels folder
     */
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
                $this->rzLevel->create();
                $this->rzLevelPack->levels[] = $this->rzLevel;
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&id=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editLevel()
    {
        $this->redirect('index.php?c=leveleditor&o=viewlevelpacksource&lp='.$_GET['lp']);
    }
}

