<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 07.12.2018
 * Time: 15:54
 */
class Reminder
{

    public function __construct()
    {
        $this->pdo = \Connect::getInstance()->getConnection();
    }

    public function sendReminds()
    {
        $now = time();
        $time_to_send = $now + 3 * 3600;

        $comments = new Comment(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $comments->setTable() . " WHERE reminded !='1' AND remind_time>'$now'  ");
        $sql->execute();
        $units = $sql->fetchAll();

        var_dump($units);


        foreach ($units as $unit) {
            $comment = new Comment($unit['id']);
            //$author = new Member($this->getAuthor());
            $destination_user = new Member($unit['author_id']);

            $telegram = new Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');
            $message = "Напоминание: <b>" . $comment->description() . '</b>:';
            $telegram->send($message, $destination_user->getField('telegram_id'));

            $comment->updateField('reminded', '1');
        }
    }
}