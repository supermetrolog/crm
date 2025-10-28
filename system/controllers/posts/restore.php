<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');

$availableTableIds = [33];

$user = new Member($_COOKIE['member_id']);

$table_id = (int)$_POST['table_id'];

if ($user->is_valid()) {
	$id      = (int)$_POST['id'];

	if (!in_array($table_id, $availableTableIds)) {
		echo "You can't restore this post";
		exit();
	}

	$table = (new Table($table_id))->tableName();
	$post  = new Post($id);

	$post->getTable($table);

	$post_id = $post->postRestore();

	include_once (PROJECT_ROOT . '/table/feed_create.php');

	header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
	echo "F*ck you, hacker=)";
}
