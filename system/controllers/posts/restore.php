<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');

$availableTableIds = [33];

$user = new Member($_COOKIE['member_id']);

if ($user->is_valid()) {
	$id      = (int)$_POST['id'];
	$tableId = (int)$_POST['table_id'];

	if (!in_array($tableId, $availableTableIds)) {
		echo "You can't restore this post";
		exit();
	}

	$table = (new Table($tableId))->tableName();
	$post  = new Post($id);

	$post->getTable($table);

	$post->postRestore();

	include_once (PROJECT_ROOT . '/table/feed_create.php');

	header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
	echo "F*ck you, hacker=)";
}
