##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Edit Light</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=editLight&lp=<?=$this->lp?>&lid=<?=$this->lid?>&hid=<?=$this->hid?>" method="post">
    <?php echo $this->rzLight->toForm(); ?>
    <br>
    <input type="submit" value="Save Light" /> <input type="button" value="Delete Light" onclick="window.location.href = 'index.php?c=<?=$C?>&o=deleteLight&lp=<?=$this->lp?>&lid=<?=$this->lid?>&hid=<?=$this->hid?>'" />
</form>

