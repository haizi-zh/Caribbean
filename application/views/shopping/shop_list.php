<?php foreach ($shops as $key => $val) :?> 
<li>
    <a class="search_result result-block" href="javascript:;">
        <i class="icon_spot spot_blue"><?php echo $key+1 ; ?></i>
        <div class="shop_info">
            <p class="name"><?php echo $val['name'] ; ?></p>
            <p class="addr">地址：<?php echo $val['address'] ; ?></p>
        </div>
    </a>
</li>
<?php endforeach ; ?>

<ul id="pagination-digg">
    <?php for($i = 1 ;$i<=$pages ;$i++):?>
        <?php if($cpage == $i):?>
            <li class="active"><?php echo $i ;?></li>
        <?php else : ?>
            <li><a href="javascript:datainit(<?php echo $i ;?>);"><?php echo $i ;?></a></li>
        <?php endif; ?>
    <?php endfor; ?>
</ul>