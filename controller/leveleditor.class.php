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
                $rzLevelPack->validate();
                $rzLevelPack->save();

                $this->redirect("index.php?c=".__CLASS__."&o=editLevelPack&name=".$rzLevelPack->name);
            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }

        return array('error' => $error, 'rzLevelPack' => $rzLevelPack);
    }

    public function editLevelPack()
    {
        $name = @$_GET['name'];
        $rzLevelPack = new RZLevelPack($name);
        $rzLevelPack->load();

        return array('rzLevelPack' => $rzLevelPack);
    }
}

