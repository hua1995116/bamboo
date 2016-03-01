<?php
//引入公共文件
require 'includes/common.inc.php';

$_score_model = $_POST['score_model'];
$_score_color = $_POST['score_color'];
$_score_material = $_POST['score_material'];
$_score_fashion = $_POST['score_fashion'];
$_bambooid = $_POST['bambooid'];
$_userid = $_POST['userid'];

if($_score_model && $_score_color && $_score_material && $_score_fashion && $_bambooid && $_userid){
	$check_score = _query("SELECT * FROM score WHERE userid='{$_userid}' && bambooid='{$_bambooid}'");
	if(_affected_rows($check_score) == 0){
		$_insert_star = _query("INSERT INTO score (score_model,score_color,score_material,score_fashion,userid,bambooid) VALUES ($_score_model,$_score_color,$_score_material,$_score_fashion,$_userid,$_bambooid)");
		if($_insert_star){
			$rs_score = _query("SELECT * FROM score WHERE bambooid='{$_bambooid}'");
			$sum_score_model = 0;
			$sum_score_color = 0;
			$sum_score_material = 0;
			$sum_score_fashion = 0;
			$i_score = _num_rows($rs_score);	//总评分人数
			while($rows_score = _fetch_array_list($rs_score)){
				$html_score = array();
				$html_score['score_model'] = $rows_score['score_model'];	//款式分
				$html_score['score_color'] = $rows_score['score_color'];	//色彩分
				$html_score['score_material'] = $rows_score['score_material'];	//面料分
				$html_score['score_fashion'] = $rows_score['score_fashion'];	//时尚分
				$sum_score_model += $html_score['score_model'];	//款式总分
				$sum_score_color += $html_score['score_color'];	//色彩总分
				$sum_score_material += $html_score['score_material'];	//面料总分
				$sum_score_fashion += $html_score['score_fashion'];	//时尚总分
			}
			$ave_score_model = number_format($sum_score_model/$i_score,2);
			$ave_score_color = number_format($sum_score_color/$i_score,2);
			$ave_score_material = number_format($sum_score_material/$i_score,2);
			$ave_score_fashion = number_format($sum_score_fashion/$i_score,2);
			$sum_score = $ave_score_model*0.3+$ave_score_color*0.2+$ave_score_material*0.3+$ave_score_fashion*0.2;
			$_update_score = _query("UPDATE bamboo SET score_model='{$ave_score_model}',score_color='{$ave_score_color}',score_material='{$ave_score_material}',score_fashion='{$ave_score_fashion}',score='{$sum_score}' WHERE id='{$_bambooid}'");
			echo '
				<div class="score">
					<div class="score_show">
						<div class="score_show_ico"></div>
						<div class="score_show_model">
							<strong>'.trans_level($ave_score_model).'</strong>
						</div>
						<div class="score_show_color">
							<strong>'.trans_level($ave_score_color).'</strong>
						</div>
						<div class="clear"></div>
						<div class="score_show_material">
							<strong>'.trans_level($ave_score_material).'</strong>
						</div>
						<div class="score_show_fashion">
							<strong>'.trans_level($ave_score_fashion).'</strong>
						</div>
					</div>
					<div class="all_score"><p>等级：</p>'.trans_rank($sum_score).'</div>
				</div>
			';
		}
	} else {
		echo "
			<script>
			$(function(){
				art.dialog({
				lock: true,
				background: '#000', 
				opacity: 0.87,
				content: '你已经评过分了！',
				icon: 'warning',
				ok: function () {
					location.reload();
					},
				close:function(){
					location.reload();
					}
				})
			})
			</script>";
	}
}
?>