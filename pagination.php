<?php
require_once('config.php');
require_once('function.php');		
$currentPage = $_GET['currentPage'];
$pageCount = $_GET['pageCount'];
//print_r($currentPage.' '.$pageCount); die();

if($pageCount>0){
?>
<div>Showing Page <?=$currentPage;?> of <?=$pageCount;?></div>
<ul class="pagination" style="visibility: visible;">
    <li class="prev <?php if($currentPage<=1){ echo 'disabled';}?>">
    <?php if($currentPage<=1){ ?>
        <a title="First" class="btnPage" data-page="javascript:;"><i class="fa fa-angle-double-left"></i></a>
    <?php }else{ ?>
        <a title="First" class="btnPage" data-page="1"><i class="fa fa-angle-double-left"></i></a>
    <?php } ?>
    </li>
    <li class="prev <?php if($currentPage<=1){ echo 'disabled';}?>">
    <?php if($currentPage<=1){ ?>
    <a title="Prev" data-page="javascript:;"><i class="fa fa-angle-left"></i></a>
    <?php }else{ ?>
        <a title="Prev" class="btnPage" data-page="<?php echo ($currentPage-1); ?>"><i class="fa fa-angle-left"></i></a>
    <?php } ?>
    </li>
    
    <?php if($pageCount<=5){
        for($i=1;$i<=$pageCount;$i++){ ?>
        <li>
           <a title="<?=$i;?>" data-page="<?=$i?>" class="btn btnPage <?php if($currentPage==$i){echo "blue";}?>"><?=$i;?></a>
        </li>
     <?php }}else{
        if(($currentPage-2)>=1 && ($currentPage+2)<=$pageCount){
            for($i=($currentPage-2);$i<=($currentPage+2);$i++){ ?>
            <li>
               <a title="<?=$i;?>" data-page="<?=$i?>" class="btn btnPage <?php if($currentPage==$i){echo "blue";}?>"><?=$i;?></a>
            </li>
      <?php  }}elseif(($currentPage-2)<1){
        for($i=1;$i<=5;$i++){ ?>
            <li>
               <a title="<?=$i;?>" data-page="<?=$i?>" class="btn btnPage <?php if($currentPage==$i){echo "blue";}?>"><?=$i;?></a>
            </li>
     <?php }}elseif(($currentPage+2)>$pageCount){
        for ($i=($pageCount-4);$i<=$pageCount;$i++){ ?>
            <li>
               <a title="<?=$i;?>" class="btn btnPage <?php if($currentPage==$i){echo "blue";}?>" data-page="<?=$i?>"><?=$i;?></a>
            </li>
    <?php }}} ?>
    
    <li class="next <?php if($currentPage>=$pageCount){echo 'disabled';}?>">
    <?php if($currentPage>=$pageCount){ ?>
    <a data-page="javascript:;" title="Next" class="btnPage"><i class="fa fa-angle-right"></i></a>
    <?php }else{ ?>
    <a title="Next" class="btnPage" data-page="<?php echo ($currentPage+1);?>"><i class="fa fa-angle-right"></i></a>
    <?php } ?></li>
    <li class="next <?php if($pageCount==0 || $pageCount==1){ echo "disabled"; }?>">
    <?php if($pageCount==0 || $pageCount==1){ ?>
    <a title="Last" class="btnPage" data-page="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
    <?php }else{ ?>
    <a title="Last" class="btnPage" data-page="<?php echo $pageCount;?>"><i class="fa fa-angle-double-right"></i></a>
    <?php } ?></li>
</ul>
<?php } ?>