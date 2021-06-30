<?php

function rosters_single($member_id=9928){
    global $smcFunc;
	$request = $smcFunc['db_query']('', '
		SELECT id_member, last_login, avatar, usertitle, real_name, facebook, twitter, youtube, twitch, steam
		FROM {db_prefix}members
		WHERE id_member = {int:id}
		LIMIT 1',
		array(
			'id' => $member_id,
		)
	);
	$member = $smcFunc['db_fetch_assoc']($request);
	$smcFunc['db_free_result']($request);

	$request = $smcFunc['db_query']('', '
		SELECT log_time,action,extra
		FROM {db_prefix}log_actions
		WHERE id_member = {int:id}
		ORDER BY `log_time` ASC',
		array(
			'id' => $member_id,
		)
	);
	$actions = array();
	$name_changes = array();
	$mos_changes = array();

	while ($action = $smcFunc['db_fetch_assoc']($request)){
		switch($action['action']){
			case 'real_name':
			//TODO: Rank change or name change?
			$name_changes[] = $action;
			break;
			case 'usertitle':
				$mos_changes[] = $action;
			default:
				$actions[] = $action;
			break;
	}
	$smcFunc['db_free_result']($request);



}