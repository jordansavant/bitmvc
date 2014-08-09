##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Edit Character</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=editCharacter&lp=<?=$this->lp?>&lid=<?=$this->lid?>&cid=<?=$this->cid?>" method="post">
    <?php echo $this->rzCharacter->toForm(); ?>
    <br>
    <?php echo $this->loadRecurrence("leveleditor.itemtool", array('items' => $this->rzCharacter->items)); ?>
    <br>
    <?php echo $this->loadRecurrence("leveleditor.lighttool", array('lights' => $this->rzCharacter->lights)); ?>
    <br>
    <br>
    <input type="submit" value="Save Character" /> <input type="button" value="Delete Character" onclick="window.location.href = 'index.php?c=<?=$C?>&o=deleteCharacter&lp=<?=$this->lp?>&lid=<?=$this->lid?>&cid=<?=$this->cid?>'" />
</form>

