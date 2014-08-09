<script>
function editStructure(id)
{
    $("#frame").attr('src', 'index.php?c=<?=$C?>&o=editStructure&lp=<?=$this->lp?>&lid=<?=$this->lid?>&sid=' + id);
}
function editCharacter(id)
{
    console.log(id);
    $("#frame").attr('src', 'index.php?c=<?=$C?>&o=editCharacter&lp=<?=$this->lp?>&lid=<?=$this->lid?>&cid=' + id);
}
</script>
##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
##end##

<h1>Edit Level: <?=$this->rzLevel->title?></h1>
<table id="led">
    <tr>
        <td style="width:50%">
<table class="map">
<?php
for($i=0; $i < $this->rzLevel->rows; $i++)
{
    ?>
    <tr>
    <?php
    for($j=0; $j < $this->rzLevel->columns; $j++)
    {
        $index = $i * $this->rzLevel->columns + $j;
        $rzTile = $this->rzLevel->getTileByIndex($index);
        $rzStructure = $this->rzLevel->getStructureByIndex($index);
        $rzCharacter = $this->rzLevel->getCharacterByIndex($index);
        ?>
        <td class="cell tile type<?=$rzTile->type?>" id="tile<?=$rzTile->id?>">
            <div style="display: none" id="tile<?=$rzTile->id?>details">
            <?php
            echo "Tile: $rzTile->id, type = $rzTile->type  <a href=\"index.php?c=$C&o=editTile&lp=$this->lp&lid=$this->lid&tid=$rzTile->id\">Edit</a>";

            if($rzStructure) {
                echo "<br>Structure: $rzStructure->id, type = $rzStructure->type  <a href=\"javascript: editStructure($rzStructure->id);\">Edit</a>";
                ?><a href="index.php?c=<?=$C?>&o=deleteStructure&lp=<?=$this->lp?>&lid=<?=$this->lid?>&sid=<?=$rzStructure->id?>">Delete</a><?
            } else if($rzCharacter) {
                echo "<br>Character: $rzCharacter->id, type = $rzCharacter->type  <a href=\"javascript: editCharacter($rzCharacter->id)\">Edit</a>";
                ?><a href="index.php?c=<?=$C?>&o=deleteCharacter&lp=<?=$this->lp?>&lid=<?=$this->lid?>&cid=<?=$rzCharacter->id?>">Delete</a><?
            } else {
                echo "<br>Structure: <a href=\"index.php?c=$C&o=quickCreateStructure&lp=$this->lp&lid=$this->lid&index=$index\">Create</a>";
                echo "<br>Character: <a href=\"index.php?c=$C&o=quickCreateCharacter&lp=$this->lp&lid=$this->lid&index=$index\">Create</a>";
            }
            ?>
            </div>
            <?php
            if($rzStructure) {
                ?>
                <div class="structure structure<?=$rzStructure->type?>" id="structure<?=$rzStructure->id?>"></div>
                <script>
                $("#structure<?=$rzStructure->id?>").click(function(){
                    editStructure(<?=$rzStructure->id?>);
                });
                </script>
                <?php
            }
            else if($rzCharacter) {
                ?>
                <div class="character character<?=$rzCharacter->type?>" id="character<?=$rzCharacter->id?>"></div>
                <script>
                $("#character<?=$rzCharacter->id?>").click(function(){
                    editCharacter(<?=$rzCharacter->id?>);
                });
                </script>
                <?php
            }
            ?>
        </td>
        <script>
        $('#tile<?=$rzTile->id?>').qtip({
            content: {
                text: $('#tile<?=$rzTile->id?>details'),
                title: '<?="$index: $i,$j"?>',
            },
            hide: {
                fixed: true,
                delay:300
            },
            style: 'qtip-dark'
        });
        </script>
        <?php
    }
    ?>
    </tr>
    <?php
}
?>
</table>
        </td>
        <td>
            <iframe src="about: none" id="frame"></iframe>
        </td>
    </tr>
</table>
</ul>
