<?php
function license_get_list(){
	$result = pg_query('
	SELECT *
	FROM permessi
	');
	$data = array();
	while($tmp = pg_fetch_assoc($result)){
		array_push($data, $tmp);
	};
	
	return $data;
}

function license_change($userid, $perms){
	pg_query('
	UPDATE utenti
	SET permessi=\''.$perms.'\' WHERE id=\''.$userid.'\'
	');
}

function license_new_id(){
	$result = pg_query('
	SELECT (id*2) as next_id
	FROM permessi
	ORDER BY id DESC
	LIMIT 1 OFFSET 0
	');
	if(pg_num_rows($result) != 0){
		return pg_result($result, 0, "next_id");
	}else{
		return 1;
	}
}

function license_add($name, $desc){
	pg_query('
	INSERT INTO permessi 
	VALUES ('.license_new_id().',\''.$name.'\',\''.$desc.'\')
	');
}

function license_user_get_perms($id){
	return intval(pg_result(pg_query('
	SELECT permessi
	FROM utenti
	WHERE id = \''.$id.'\'
	'), 0 ,'permessi'));
}

function license_has($user, $perm){
	$permessi = license_user_get_perms(user_get_id($user));
	$perm = pg_result(pg_query('
	SELECT id
	FROM permessi
	WHERE nome = \''.$perm.'\'
	'), 0 ,'id');
	return intval($permessi) & intval($perm);
}

function license_get($user){
	$permessi = license_user_get_perms(user_get_id($user));
	$perm_list = array();
	foreach(license_get_list() as $perm){
		if($permessi & intval($perm['id'])){
			$perm_list[] = $perm;
		}
	}	
	return $perm_list;
}
?>