<?php
//引入公共文件
require 'includes/common.inc.php';

$_starid = $_POST['starid'];
$_articleid = $_POST['articleid'];

$_state = _query("DELETE FROM score WHERE id='{$_starid}'");
if($_state){
	$rs_score = _query("SELECT * FROM score WHERE bambooid='{$_articleid}'");
	$sum_score_model = 0;
	$sum_score_color = 0;
	$sum_score_material = 0;
	$sum_score_fashion = 0;
	$i_score = _num_rows($rs_score);	//总评分人数
	while($rows_score = _fetch_array_list($rs_score)){
		$html_score = array();
		$html_score['score_model'] = $rows_score['score_model'];
		$html_score['score_color'] = $rows_score['score_color'];
		$html_score['score_material'] = $rows_score['score_material'];
		$html_score['score_fashion'] = $rows_score['score_fashion'];
		$sum_score_model += $html_score['score_model'];
		$sum_score_color += $html_score['score_color'];
		$sum_score_material += $html_score['score_material'];
		$sum_score_fashion += $html_score['score_fashion'];
	}
	$ave_score_model = number_format($sum_score_model/$i_score,2);
	$ave_score_color = number_format($sum_score_color/$i_score,2);
	$ave_score_material = number_format($sum_score_material/$i_score,2);
	$ave_score_fashion = number_format($sum_score_fashion/$i_score,2);
	$sum_score = $ave_score_model*0.3+$ave_score_color*0.2+$ave_score_material*0.3+$ave_score_fashion*0.2;
	$_update_score = _query("UPDATE bamboo SET score_model='{$ave_score_model}',score_color='{$ave_score_color}',score_material='{$ave_score_material}',score_fashion='{$ave_score_fashion}',score='{$sum_score}' WHERE id='{$_articleid}'");
	echo 1;
} else {
	echo 0;
}

?>