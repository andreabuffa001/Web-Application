<?php
include_once("include/config.php");
include_once("include/license.lib.php");
include_once("include/utils.lib.php");

if(isset($_POST['action'])){
	switch($_POST['action']){
		case 'modifica':
			unset($_POST['action']);
			foreach($_POST as $ukey => $permlist){
				if($ukey{0} == "u"){
					$perm = 0;
					foreach($permlist as $p) $perm |= intval($p);
					license_change(substr($ukey,1), $perm);
				}
			}
		break;
		case 'aggiungi':
			license_add($_POST['pname'], $_POST['pdesc']);
		break;
	}
}

$perms = license_get_list();
$count = 0;

$table = '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
<table width="100%" class="style3">
<tr bgcolor="#99CCCC">
	<td width="150"><b>Utente</b></td>';
foreach($perms as $perm){
	$table .= '<td><a title="'.$perm['descrizione'].'"><b>'.$perm['nome'].'</b></a></td>';
	unset($perm['nome']);
}
$table .= '</tr>';
foreach(get_users_list() as $user){
	$table .= '<tr bgcolor="'.(($count %2 == 0) ? '#CCFFCC' : '#FFFFFF').'">';
	$table .= '<td>'.$user['name'].' '.$user['surname'].'</td>';
	foreach($perms as $perm){
		$name = 'u'.$user['id'].'[]';
		$checked = ((intval($user['permessi']) & intval($perm['id'])) ? 'checked': '');
		$table .= '<td><input type="checkbox" name="'.$name.'" value="'.$perm['id'].'" '.$checked.'></td>';
	}
	$table .= '</tr>';
	$count++;
}

$table .= '<tr><td colspan="'.(count($perms)+1).'"><input type="submit" name="action" value="modifica" class="style3"></td></tr></table></form>';
?>
<html>
<head>
<title>Amministrazione Permessi</title>
<style type="text/css"> .style3 { font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif; }</style>
</head>

<body>
<b>Gestione permessi utenti:</b><br>
<span class="style3">[muovere il mouse sopra il nome di un permesso per visualizzarne la descrizione]</span><br>
<?=$table;?>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<b>Creazione nuovo permesso:</b><br>
<span class="style3">[le modifiche qui effettuate vanno finalizzate manualmente sugli script]</span><br>
<table border="0" cellpadding="10">
	<tr>
		<td class="style3">Nome del permesso</td>
	  <td><input name="pname" type="text" size="30" class="style3"></td>
		<td class="style3">Descrizione</td>
	  <td><input name="pdesc" type="text" size="30" class="style3"></td>
	  <td><input type="submit" name="action" value="aggiungi" class="style3"></td>
	</tr>
	<tr>
		<td><a href="archive.php">Ritorna all'archivio</a></td>
	</tr>
</table>
</form>
</body>
</html>
