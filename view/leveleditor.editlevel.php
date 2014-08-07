<h1>Edit Level: <?=$this->rzLevel->title?></h1>

<table class="map">
<?php
$tileMap = explode(',', $this->rzLevel->tileMap);
for($i=0; $i < $this->rzLevel->rows; $i++)
{
    ?>
    <tr>
    <?php
    for($j=0; $j < $this->rzLevel->columns; $j++)
    {
        $index = $i * $this->rzLevel->columns + $j;
        $tileId = $tileMap[$index];
        $rzTile = $this->rzLevel->getTileById($tileId);
        if(!$rzTile)
        {
            $href = "index.php?c=$C&o=createTile&lp=$this->lp&lid=$this->lid&index=$index";
            ?>
            <td class="cell notile" onclick="window.location.href = '<?= $href ?>'"></td>
            <?php
        }
        else
        {
            $href = "index.php?c=$C&o=editTile&lp=$this->lp&lid=$this->lid&tid=$rzTile->id";
            ?>
            <td class="cell tile type<?=$rzTile->type?>" id="tile<?=$rzTile->id?>" onclick="window.location.href = '<?= $href ?>'"></td>
            <?php
        }
    }
    ?>
    </tr>
    <?php
}
?>
</table>
</ul>
