##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Edit Structure</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=editStructure&lp=<?=$this->lp?>&lid=<?=$this->lid?>&sid=<?=$this->sid?>" method="post">
    <?php echo $this->rzStructure->toForm(); ?>
    <br>
    <?php echo $this->loadRecurrence("leveleditor.itemtool", array('items' => $this->rzStructure->items)); ?>
    <br>
    <?php echo $this->loadRecurrence("leveleditor.lighttool", array('lights' => $this->rzStructure->lights)); ?>
    <br>
    <br>
    <input type="submit" value="Save Structure" />
</form>

