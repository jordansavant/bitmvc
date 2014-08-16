<?php
class LevelEditor extends BitController
{
    public function __construct($bitmvc)
    {
        parent::__construct($bitmvc);
        $this->bitTemplate = 'frame';
    }

    public function index()
    {
        $this->bitTemplate = 'primary';
        $dir = dirname(__FILE__)."/";
        $scan = scandir("$dir../data/");
        $this->files = array_diff($scan, array(".", ".."));
    }

    public function createLevelPack()
    {
        $this->bitTemplate = 'primary';
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
        $this->bitTemplate = 'primary';
        $this->rzLevelPack = new RZLevelPack(@$_GET['lp']);
    }

    public function viewLevelPackSource()
    {
        $this->bitTemplate = 'primary';
        $this->rzLevelPack = new RZLevelPack(@$_GET['lp']);
    }

    public function createLevel()
    {
        $this->bitTemplate = 'primary';
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
        $this->bitTemplate = 'primary';
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
        $this->bitTemplate = 'primary';
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->tid = $_GET['tid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzTile = $this->rzLevel->getTileById($this->tid);

        if(count($_POST))
        {
            try {
                $this->rzTile->bind($_POST['RZTile']);
                $this->rzTile->enterEvents = array(); #unset
                if(isset($_POST['eventtool']) && is_array($_POST['eventtool']['events']))
                {
                    foreach($_POST['eventtool']['events'] as $i => $eventType)
                    {
                        $newId = count($this->rzTile->enterEvents) + 1;
                        $rzEvent = new RZEvent();
                        $rzEvent->type = $eventType;
                        $rzEvent->targetLevelId = $_POST['eventtool']['event_tli'][$i];
                        $rzEvent->targetEntranceId = $_POST['eventtool']['event_tei'][$i];
                        $rzEvent->create($newId);
                        $this->rzTile->enterEvents[] = $rzEvent;
                    }
                }
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
        $this->bitTemplate = 'primary';
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
                $newId = $this->rzLevel->getNextStructureId();
                $this->rzStructure->create($newId);
                $this->rzLevel->addStructureAtIndex($this->rzStructure, $this->index);
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function quickCreateStructure()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->index = $_GET['index'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzStructure = new RZStructure();

        $this->rzStructure->type = '1';
        $newId = $this->rzLevel->getNextStructureId();
        $this->rzStructure->create($newId);

        $this->rzLevel->addStructureAtIndex($this->rzStructure, $this->index);
        $this->rzLevelPack->save();

        $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
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
        $this->bitTemplate = 'primary';
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
                $newId = $this->rzLevel->getNextCharacterId();
                $this->rzCharacter->create($newId);
                $this->rzLevel->addCharacterAtIndex($this->rzCharacter, $this->index);
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function quickCreateCharacter()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->index = $_GET['index'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzCharacter = new RZCharacter();

        $this->rzCharacter->type = '1';
        $newId = $this->rzLevel->getNextCharacterId();
        $this->rzCharacter->create($newId);

        $this->rzLevel->addCharacterAtIndex($this->rzCharacter, $this->index);
        $this->rzLevelPack->save();

        $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
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

                $this->rzCharacter->equipment = array(); #unset
                if(isset($_POST['equipment']) && is_array($_POST['equipment']['slots']))
                {
                    foreach($_POST['equipment']['slots'] as $i => $slot)
                    {
                        if($_POST['equipment']['items'][$i])
                        {
                            $newId = count($this->rzCharacter->equipment) + 1;
                            $rzItem = new RZItem();
                            $rzItem->type = $_POST['equipment']['items'][$i];
                            $rzItem->slot = $_POST['equipment']['slots'][$i];
                            $rzItem->create($newId);
                            $this->rzCharacter->equipment[] = $rzItem;
                        }
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


    /**
     * Light CRUD
     */
    public function createLight()
    {
        $this->bitTemplate = 'primary';
        $this->error = '';
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->index = $_GET['index'];
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzLight = new RZLight();

        if(count($_POST))
        {
            $this->rzLight->bind($_POST['RZLight']);

            try {
                $newId = $this->rzLevel->getNextLightId();
                $this->rzLight->create($newId);
                $this->rzLevel->addLightAtIndex($this->rzLight, $this->index);
                $this->rzLevelPack->save();
                $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function editLight()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->hid = $_GET['hid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzLight = $this->rzLevel->getLightById($this->hid);

        if(count($_POST))
        {
            try {
                $this->rzLight->bind($_POST['RZLight']);
                $this->rzLight->edit();
                $this->rzLevelPack->save();
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }

    public function deleteLight()
    {
        $this->lp = $_GET['lp'];
        $this->lid = $_GET['lid'];
        $this->hid = $_GET['hid'];
        $this->error = '';
        $this->rzLevelPack = new RZLevelPack($this->lp);
        $this->rzLevel = $this->rzLevelPack->getLevelById($this->lid);
        $this->rzLevel->deleteLightById($this->hid);
        $this->rzLevelPack->save();
        $this->redirect("index.php?c=".__CLASS__."&o=editLevel&lp=".$this->rzLevelPack->name."&lid=".$this->rzLevel->id);
    }
}

