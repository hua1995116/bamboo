 <div class="left_nav">
  		<div class="dh">
			<div class="n1">
				 <a href="social.php"><b>灯具</b></a>
			</div>
			<div class="n2">
				 <a href="daily.php"><b>家具用品</b></a>
		    </div>
		    <div class="n3">
				 <a href="profession.php"><b>装饰用品</b></a>
			</div>
			<div class="n4">
				 <a href="indoor.php"><b>日常用品</b></a>
			</div>
		    <div class="n5">
				 <a href="child.php"><b>其他</b></a>
			</div>
    <?
        if(!!isset($_SESSION['username'])){
			echo '<div class="n6">
                 <a href="buy_record.php"><b>订购记录</b></a>
			</div>';
        }
    ?>

	    </div>
        <div class="smallnavigation">
            <div class="smallnavigation1"> 
            	<a href="top_social.php"><b>作品排行</b></a>
            </div>
            <div class="smallnavigation2">
            		<a href="about.php"><b>关于我们</b></a>
            </div>
            <div class="smallnavigation3">
            		<a href="map.php"><b>网站地图</b></a>
            </div>
        </div>
</div>