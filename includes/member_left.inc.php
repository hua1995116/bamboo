<div class="member_left">
	<?
		if (isset($_SESSION['username'])){
			echo '<input type="hidden" class="check_cookie" value="1" />';
		} else {
			echo '<input type="hidden" class="check_cookie" value="0" />';
		}
	?>
    <div class="left_title"><? echo $html_user['username']; ?>的信息</div>
    <div class="user_info">
        <img src="<? echo $html_user['face']; ?>" alt="face" />
        <?
			$check_friend = _query("SELECT * FROM friend WHERE userid='{$html_visit['id']}' && beuserid='{$_GET['id']}' LIMIT 1");
			if(_affected_rows($check_friend) == 0){
				echo '<div class="add_friend">+加为好友</div>';
			} else {
				echo '<div class="has_friend">已为好友</div>';
			}
		?>
        <div class="has_friend" style="display:none">已为好友</div>
        <input type="hidden" class="userid" value="<? echo $html_visit['id']; ?>" />
        <input type="hidden" class="beuserid" value="<? echo $_GET['id']; ?>" />
        <ul>
            <li>
                <p>昵称：</p><div class="user_name"><? echo $html_user['username']; ?></div>
            </li>
            <li>
                <p>生日：</p><div class="user_birthday"><? if($html_user['birthday'] == '0000-00-00'){echo '未填写';} else { echo $html_user['birthday']; } ?></div>
            </li>
            <li>
                <p>邮箱：</p><div class="user_email"><? if($html_user['email'] == ''){echo '未填写';} else { echo $html_user['email']; } ?></div>
            </li>
            <li>
                <p>q&nbsp;&nbsp;q&nbsp;：</p><div class="user_qq"><? if($html_user['qq'] == ''){echo '未填写';} else { echo $html_user['qq']; } ?></div>
            </li>
            <li>
                <h3>个人简介：</h3><div class="user_content"><? if($html_user['content'] == ''){echo '未填写';} else { echo $html_user['content']; } ?></div>
            </li>
        </ul>
    </div>
</div>