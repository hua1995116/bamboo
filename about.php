<?
define('SCRIPT','about');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-关于我们</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" type="text/css" href="styles/about.css" />
	<script type="text/javascript" src="scripts/about.js"></script>
</head>
<body>
	<?
		require 'includes/header.inc.php';
	?>
    <?
		require 'includes/head.php';
	?>


	<div id="body_area">
		
		<?
	        require 'includes/left_nav.inc.php';
	    ?>

	    <div id="body_r">
	    	<div class="box_area">
	            <div class="block box_1"><img src="images/ico/our.png" alt="" /><p class="left1">关于艺竹</p></div>
	            <div class="block box_2"><img src="images/ico/lock.png" alt="" /><p class="left1">隐私条款</p></div>
	            <div class="block box_3"><img src="images/ico/help.png" alt="" /><p class="left1">帮助中心</p></div>
	            <div class="block box_4"><img src="images/ico/say.png" alt="" /><p class="left2">免责声明</p></div>
	            <div class="block box_5"><img src="images/ico/tel.png" alt="" /><p class="left2">联系我们</p></div>
	            <div class="block box_6"><img src="images/ico/link.png" alt="" class="link" /><p class="left3">友情链接</p></div>
	            <div class="block box_7"><img src="images/ico/map.png" alt="" class="map" /><p class="left4">全站导航</p></div>
	            <?
					if (isset($_SESSION['username'])){
						$rs = _fetch_array("SELECT level FROM user WHERE username='{$_SESSION['username']}'");
						if($rs['level'] == 1){
							echo '<a href="admin.php"><div class="box_8"><img src="images/ico/manage.png" alt="" class="link" /><p class="left3">后台管理</p></div></a>';
						} else {
							echo '<div class="box_8 common_user"><img src="images/ico/manage.png" alt="" class="link" /><p class="left3">后台管理</p></div>';
						}
					} else {
						echo '<div class="box_8 no_login"><img src="images/ico/manage.png" alt="" class="link" /><p class="left3">后台管理</p></div>';
					}
				?>
	        </div>
	        <div class="detail_area">
	            <div class="hide detail_1" style="display:none">
	                <p class="_title">关于艺竹</p>
	                <div class="close">关闭</div>
	                <p class="survey">艺竹是一个竹工艺设计展示网站，在这里我们将用炫丽的视觉效果为大家呈现各式各样的竹工艺。</p>
	                <p class="content">凡是对竹工艺设计有兴趣的爱好者或者有所心得的探索者，抑或是已有建树的团队个人，都可以来这儿逛逛，一起丰富我们的艺竹。在这里，我们将竹工艺品分为五类，大家不仅能领略到其他优秀设计师的作品，还可以通过上传自己的作品来向大家展示自己的设计作品和分享心得体会。</p>
	                <p class="content">在这里，只要你注册一个账号便可以轻轻松松地管理你在艺竹的点点滴滴，当然如果是路过的朋友，可以不用注册亦可以浏览我们的竹工艺品。</p>
					<p class="content">快来收获你们的果实吧！！！</p>
	            </div>
	            <!--隐私条款-->
	            <div class="hide detail_2" style="display:none">
	            	<p class="_title">隐私条款</p>
	                <div class="close">关闭</div>
	                <p class="survey">尊敬的艺竹用户，我们非为您专门制定了艺竹隐私政策，在您使用艺竹提供的服务前，请您仔细阅读以下声明。</p>
	                <strong>一、保护隐私原则</strong>
	                <p class="content">艺竹将对用户所提供的资料进行严格的管理及保护，本网站将使用相应的技术，防止您的个人资料丢失、被盗用或遭篡改，在未得到您的许可之前，本网站不会把您的任何个人信息披露给无关的第三方。</p>
	                <strong>二、适用范围</strong>
	                <p class="content">艺竹会在您自愿选择服务或提供信息的情况下收集您的个人信息，并将这些信息进行整合，其中注册用户需提交昵称、邮箱等信息，以此来鉴定会员资格并向会员发送与艺竹服务有关的邮件通知。注册成功后可选择性的提交性别、生日、个人简介、联系方式等，目的是促进会员之间的联系与交流。</p>
	    			<p class="content">当您通过浏览器访问艺竹，服务器会自动收集一些信息，如URL、IP 地址、浏览器类型、浏览器语言、访问的日期和时间等，艺竹将以此确定用户流量，了解网站服务状况，及时优化网站性能，为您提供更加高质的服务。</p>
	    			<p class="content">艺竹使用Cookie服务存储用户的偏好及记录登录session等信息，通过使用Cookie所收集的任何内容均以集合的、匿名的方式进行，且不关联到任何与用户身份有关的个人资料。如果您拒绝cookies，你可以通过设置浏览器的选项来限制部分或所有cookies的接收，但是此时您可能无法登录或使用依赖于cookies 的艺竹服务或功能。</p>
	    			<p class="content">艺竹为您提供的个人主页等服务对所有注册用户公开，在这些区域内，您公布的任何信息都会成为公开的信息。因此，我们提醒并请您慎重考虑是否有必要在这些区域公开您的个人信息。</p>
	                <strong>三、信息共享与披露</strong>
	                <p class="content">我们会遵照您的意愿或法律的规定，不对外公开或向第三方提供非公开内容，但下列情况除外：</p>
					<p class="content">（1）事先获得用户共享资料的明确授权；</p>
					<p class="content">（2）根据法律的有关规定，或者行政或司法机构的要求，向第三方或者行政、司法机构披露；</p>
					<p class="content">（3）用户违反了艺竹服务条款或任何其他产品服务的使用规定，要求向相关部门披露；</p>
					<p class="content">（4）只有披露个人资料，才能提供相应的产品和服务。</p>
	                <strong>四、隐私政策更新</strong>
	                <p class="content">当我们的隐私政策有内容更新时，我们会在社区里发布公告让用户了解最新的改动。公告生效后，用户需遵守。</p>
	    			<p class="content">如果您对本隐私政策有任何疑问或建议，请与我们联系。</p>
	            </div>
	            <!--帮助中心-->
	            <div class="hide detail_3" style="display:none">
	            	<p class="_title">帮助中心</p>
	                <div class="close">关闭</div>
	                <p class="_help">如何上传自己的竹工艺品？</p>
	                <p class="content">登录后，把鼠标移入右下角的头像，点击个人中心，再点击我的进行竹工艺发布。</p>
	                <strong>如何给他人的竹工艺评分？</strong>
	                <p class="content">登录后，在查看内容页面，点击右上角的详细信息按钮，即可在评分栏进行评分。</p>
	                <strong>如何评论他人的竹工艺？</strong>
	                <p class="content">登录后，在查看内容页面，点击右上角的详细信息按钮，即可在评论栏进行评论。</p>
	                <strong>如何进入个人中心？</strong>
	                <p class="content">登录后，把鼠标移入右下角的头像，点击个人中心。</p>
	                <strong>如何添加他人为好友？</strong>
	                <p class="content">登录后，进入他人的个人主页，点击左侧加为好友按钮即可。</p>
	                <strong>为何无法查看首页展示的竹工艺信息？</strong>
	                <p class="content">十分的抱歉，首页的竹工艺仅供展示使用，无法对其进行收藏、评价等操作。</p>
	            </div>
	            <!--免责声明-->
	            <div class="hide detail_4" style="display:none">
	            	<p class="_title">免责声明</p>
	                <div class="close">关闭</div>
	                <p class="survey">用户在使用艺竹前，请务必仔细阅读并透彻理解本声明。凡以任何方式登录艺竹或直接、间接使用艺竹资源，视为自愿接受本声明所有条款。</p>
					<p class="content">第一条 由于用户帐号保管疏忽或同意公开个人资料，导致的个人资料泄露、丢失、被盗用或被篡改等，艺竹不承担任何法律责任。</p>
					<p class="content">第二条 任何由于黑客政击、计算机病毒侵入等而造成的个人资料泄露、丢失、被盗用或被篡改等，艺竹不承担任何法律责任。</p>
					<p class="content">第三条 由于与本网站链接的其它网站所造成之个人资料泄露及由此而导致的任何法律争议和后果，艺竹不承担任何法律责任。</p>
					<p class="content">第四条 由于政府司法机关依照法定程序要求本社区披露个人资料下之任何披露，艺竹不承担泄漏资料的法律责任。</p>
					<p class="content">第五条 用户在艺竹发布的所有内容仅表其个人的观点，并不代表艺竹的立场或观点。发布者自行对所发表内容的真实性、准确性和合法性负责，艺竹不承担任何法律及连带责任。</p>
					<p class="content">第六条 用户在艺竹发布侵犯他人知识产权或其他合法权益的内容，艺竹有权予以删除，并保留移交司法机关处理的权利。</p>
					<p class="content">第七条 用户若认为艺竹上存在侵犯自身合法权益的内容，应该及时向艺竹提出书面权利通知，并提供身份证明、权属证明及详细侵权情况证明，以便艺竹迅速做出处理。</p>
					<p class="content">第八条 由于网络状况、通讯线路等任何原因而导致您不能正常使用艺竹服务，艺竹不承担任何法律责任。</p>
					<p class="content">第九条 任何透过艺竹链接获得资讯及享用服务导致的法律争议和后果的，艺竹不承担任何法律责任。</p>
	                <strong>准则：</strong>
	                <p class="content">第十条 对免责声明的更新权及最终解释权均归艺竹所有。</p>
					<p class="content">如果您对本声明有任何疑问或建议，请与我们联系。</p>
	            </div>
	            <!--联系我们-->
	            <div class="hide detail_5" style="display:none">
	            	<p class="_title">联系我们</p>
	                <div class="close">关闭</div>
	                <p class="survey">欢迎你联系我们，给我们提供宝贵的意见，帮助我们更好地建设大家的网站。</p>
	                <p class="content"><strong>地址：</strong>XX&nbsp;省&nbsp;XX&nbsp;市&nbsp;XX&nbsp;区&nbsp;XX&nbsp;路&nbsp;XX&nbsp;号</p>
	                <p class="content"><strong>电话：</strong>1726808380</p>
	                <p class="content"><strong>邮箱：</strong>461249104@qq.com</p>
	            </div>
	            <!--友情链接-->
	            <div class="hide detail_6" style="display:none">
	            	<p class="_title">友情链接</p>
	                <div class="close">关闭</div>
	                <div class="link_area">
	                	<ul>
	                        <li>
	                            <a href="http://www.baidu.com" target="_blank"><img src="images/link/baidu.png" alt="" /></a><p><a href="http://www.baidu.com" target="_blank">百度</a></p>
	                        </li>
	                        <li>
	                            <a href="http://www.xxtef.com/" target="_blank"><img src="images/link/xxt.png" alt="" /></a><p><a href="http://www.xxtef.com/" target="_blank">线线通</a></p>
	                        </li>
	                        <li>
	                            <a href="http://art.cfw.cn/" target="_blank"><img src="images/link/fzsj.png" alt="" /></a><p><a href="http://art.cfw.cn/" target="_blank">设计网</a></p>
	                        </li>
	                        <li>
	                            <a href="http://style.sina.com.cn/cul" target="_blank"><img src="images/link/xinlang.png" alt="" /></a><p><a href="http://style.sina.com.cn/cul" target="_blank">新浪尚品</a></p>
	                        </li>
	                        <li>
	                            <a href="http://arts.cul.sohu.com" target="_blank"><img src="images/link/souhu.png" alt="" /></a><p><a href="http://arts.cul.sohu.com" target="_blank">搜狐艺术</a></p>
	                        </li>
	                        <li>
	                            <a href="http://tieba.baidu.com/f?kw=%E6%9C%8D%E8%A3%85%E8%AE%BE%E8%AE%A1&ie=utf-8&fr=wwwt" target="_blank"><img src="images/link/tieba.png" alt="" /></a><p><a href="http://tieba.baidu.com/f?kw=%E6%9C%8D%E8%A3%85%E8%AE%BE%E8%AE%A1&ie=utf-8&fr=wwwt" target="_blank">工业设计贴吧</a></p>
	                        </li>
	                        <li>
	                            <a href="http://www.sxxl.com/"><img src="images/link/dx.png" alt="" /></a><p><a href="http://www.sxxl.com/" target="_blank">蝶讯网</a></p>
	                        </li>
	                        <li>
	                            <a href="http://www.efzz.cn/" target="_blank"><img src="images/link/zfsj.png" alt="" /></a><p><a href="http://www.efzz.cn/" target="_blank">中国设计网</a></p>
	                        </li>
	                        <li>
	                            <a href="http://www.pop-fashion.com/" target="_blank"><img src="images/link/lxqx.png" alt="" /></a><p><a href="http://www.pop-fashion.com/" target="_blank">流行前线</a></p>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	            <!--网站地图-->
	            <div class="hide detail_7" style="display:none">
	            	<p class="_title">网站地图</p>
	                <div class="close">关闭</div>
	                <p class="survey">帮你快速到达目的地</p>
	                <p class="_goto"><a href="social.php">灯具</a></p>
	                <p class="_goto"><a href="daily.php">家具用品</a></p>
	                <p class="_goto"><a href="profession.php">装饰用品</a></p>
	                <p class="_goto"><a href="indoor.php">日常用品</a></p>
	                <p class="_goto"><a href="child.php">其他</a></p>
	                
	                <p class="_goto"><a href="top_social.php">查看排行</a></p>
	                <p class="_goto"><a href="index.php">首页</a></p>
	                <p class="_goto"><a href="register.php">注册</a></p>
	                <p class="_goto"><a href="home.php">个人中心</a></p>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>