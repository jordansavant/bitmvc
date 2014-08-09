<?php
class LevelEditor extends BitController
{
    public function __construct($bitmvc)
    {
        parent::__construct($bitmvc);
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
        $this->error = '';
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

    /**
     * Structure CRUD
     */
    public function createStructure()
    {
        $this->error = '';
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->index = $_GET['index'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzStructure = new RZStructure();

        if(count($_POST))
        {
            $this->rzStructure->bind($_POST['RZStructure']);

            try {
                $newId = count($this->rzLevel->structures) + 1;
                if($this->rzLevel->getStructureById($newId))
                    throw new Exception("Structure exists with this id");
                $this->rzStructure->create($newId);
                $this->rzLevel->addStructureAtIndex($this->rzStructure, $this->index);
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editStructure()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->sid = $_GET['sid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzStructure = $this->rzLevel->getStructureById($this->sid);

        if(count($_POST))
        {
            try {
                $this->rzStructure->bind($_POST['RZStructure']);

                $this->rzStructure->items = array(); #unset
                if(isset($_POST['itemtool']) && is_array($_POST['itemtool']['items']))
                {
                    foreach($_POST['itemtool']['items'] as $i => $itemType)
                    {
                        $newId = count($this->rzStructure->items) + 1;
                        $rzItem = new RZItem();
                        $rzItem->type = $itemType;
                        $rzItem->slot = $_POST['itemtool']['item_slots'][$i];
                        $rzItem->position = $_POST['itemtool']['item_poss'][$i];
                        $rzItem->create($newId);
                        $this->rzStructure->items[] = $rzItem;
                    }
                }

                $this->rzStructure->lights = array(); #unset
                if(isset($_POST['lighttool']) && is_array($_POST['lighttool']['light_radiuses']))
                {
                    foreach($_POST['lighttool']['light_radiuses'] as $i => $lightradius)
                    {
                        $newId = count($this->rzStructure->lights) + 1;
                        $rzLight = new RZLight();
                        $rzLight->radius = $_POST['lighttool']['light_radiuses'][$i];
                        $rzLight->red = $_POST['lighttool']['light_reds'][$i];
                        $rzLight->green = $_POST['lighttool']['light_greens'][$i];
                        $rzLight->blue = $_POST['lighttool']['light_blues'][$i];
                        $rzLight->brightness = $_POST['lighttool']['light_brights'][$i];
                        $rzLight->create($newId);
                        $this->rzStructure->lights[] = $rzLight;
                    }
                }

                $this->rzStructure->edit();
                $this->rzLevelPack->save();
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function deleteStructure()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->sid = $_GET['sid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzLevel->deleteStructureById($this->sid);
        $this->rzLevelPack->save();
        $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
    }


    /**
     * Character CRUD
     */
    public function createCharacter()
    {
        $this->error = '';
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->index = $_GET['index'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzCharacter = new RZCharacter();

        if(count($_POST))
        {
            $this->rzCharacter->bind($_POST['RZCharacter']);

            try {
                $newId = count($this->rzLevel->characters) + 1;
                if($this->rzLevel->getCharacterById($newId))
                    throw new Exception("Character exists with this id");
                $this->rzCharacter->create($newId);
                $this->rzLevel->addCharacterAtIndex($this->rzCharacter, $this->index);
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editCharacter()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->cid = $_GET['cid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzCharacter = $this->rzLevel->getCharacterById($this->cid);

        if(count($_POST))
        {
            try {
                $this->rzCharacter->bind($_POST['RZCharacter']);

                $this->rzCharacter->items = array(); #unset
                if(isset($_POST['itemtool']) && is_array($_POST['itemtool']['items']))
                {
                    foreach($_POST['itemtool']['items'] as $i => $itemType)
                    {
                        $newId = count($this->rzCharacter->items) + 1;
                        $rzItem = new RZItem();
                        $rzItem->type = $itemType;
                        $rzItem->slot = $_POST['itemtool']['item_slots'][$i];
                        $rzItem->position = $_POST['itemtool']['item_poss'][$i];
                        $rzItem->create($newId);
                        $this->rzCharacter->items[] = $rzItem;
                    }
                }

                $this->rzCharacter->lights = array(); #unset
                if(isset($_POST['lighttool']) && is_array($_POST['lighttool']['light_radiuses']))
                {
                    foreach($_POST['lighttool']['light_radiuses'] as $i => $lightradius)
                    {
                        $newId = count($this->rzCharacter->lights) + 1;
                        $rzLight = new RZLight();
                        $rzLight->radius = $_POST['lighttool']['light_radiuses'][$i];
                        $rzLight->red = $_POST['lighttool']['light_reds'][$i];
                        $rzLight->green = $_POST['lighttool']['light_greens'][$i];
                        $rzLight->blue = $_POST['lighttool']['light_blues'][$i];
                        $rzLight->brightness = $_POST['lighttool']['light_brights'][$i];
                        $rzLight->create($newId);
                        $this->rzCharacter->lights[] = $rzLight;
                    }
                }

                $this->rzCharacter->edit();
                $this->rzLevelPack->save();
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function deleteCharacter()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->cid = $_GET['cid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzLevel->deleteCharacterById($this->cid);
        $this->rzLevelPack->save();
        $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
    }

}

