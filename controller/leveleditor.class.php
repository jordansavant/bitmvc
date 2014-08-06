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
        $files = array_diff($scan, array(".", ".."));

        return array("files" => $files);
    }

    public function createLevelPack()
    {
        $error = '';
        $rzLevelPack = new RZLevelPack();

        if(count($_POST))
        {
            $rzLevelPack->name = @$_POST['name'];

            try {
                $rzLevelPack->create();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevelPack&lp=".$rzLevelPack->name);
            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }

        return array('error' => $error, 'rzLevelPack' => $rzLevelPack);
    }

    public function editLevelPack()
    {
        $rzLevelPack = new RZLevelPack(@$_GET['lp']);
        $rzLevelPack->load();

        return array('rzLevelPack' => $rzLevelPack);
    }

    public function viewLevelPackSource()
    {
        $rzLevelPack = new RZLevelPack(@$_GET['lp']);

        return array('rzLevelPack' => $rzLevelPack);
    }

    public function createLevel()
    {
        $error = '';
        $rzLevelPack = new RZLevelPack(@$_GET['lp']);
        $rzLevel = new RZLevel();

        if(count($_POST))
        {
            $rzLevel->bind($_POST['RZLevel']);

            try {
                $rzLevel->create();
                $rzLevelPack->rzLevels[] = $rzLevel;
                $rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$rzLevelPack->name."&id=".$rzLevel->id);
            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }

        return array('error' => $error, 'rzLevelPack' => $rzLevelPack, 'rzLevel' => $rzLevel);
    }

    public function editLevel()
    {
        $this->redirect('index.php?c=leveleditor&o=viewlevelpacksource&lp='.$_GET['lp']);
    }
}

