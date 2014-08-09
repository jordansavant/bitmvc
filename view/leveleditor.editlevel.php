##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
##end##

<h1>Edit Level: <?=$this->rzLevel->title?></h1>

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

            if($rzStructure)
                echo "<br>Structure: $rzStructure->id, type = $rzStructure->type  <a href=\"index.php?c=$C&o=editStructure&lp=$this->lp&lid=$this->lid&sid=$rzStructure->id\">Edit</a>";
            else
                echo "<br>Structure: <a href=\"index.php?c=$C&o=createStructure&lp=$this->lp&lid=$this->lid&index=$index\">Create</a>";

            if($rzCharacter)
                echo "<br>Character: $rzCharacter->id, type = $rzCharacter->type  <a href=\"index.php?c=$C&o=editCharacter&lp=$this->lp&lid=$this->lid&cid=$rzCharacter->id\">Edit</a>";
            else
                echo "<br>Character: <a href=\"index.php?c=$C&o=createCharacter&lp=$this->lp&lid=$this->lid&index=$index\">Create</a>";
            ?>
            </div>
            <?php
            if($rzStructure)
            {
                ?>
                <div class="structure structure<?=$rzStructure->type?>"></div>
                <?php
            }
            if($rzCharacter)
            {
                ?>
                <div class="character character<?=$rzCharacter->type?>"></div>
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
</ul>
