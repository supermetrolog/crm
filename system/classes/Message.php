<?

class Message extends Unit
{


    public function setTable()
    {
        return 'core_messages';
    }

    public function messageId()
    {
        return $this->showField('id');
    }

    public function getAuthor()
    {
        $member = new Member($_COOKIE['member_id']);
        return $member->member_id();
    }

    public function title()
    {
        return $this->showField('title');
    }

    public function text()
    {
        return $this->showField('description');
    }

    public function getMemberDialogs()
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE (destination_id=:a OR author_id=:b)  AND activity='1' ORDER BY publ_time DESC ");
        $sql->bindParam(':a', $this->getAuthor());
        $sql->bindParam(':b', $this->getAuthor());
        $sql->execute();
        $units = $sql->fetchAll();
        $authors_arr = array();
        $messages_arr = array();
        foreach ($units as $message) {
            if ($message['author_id'] == $this->getAuthor()) {
                if (!in_array($message['destination_id'], $authors_arr)) {
                    $authors_arr[] = $message['destination_id'];
                    $messages_arr[] = $message['id'];
                }
            } else {
                if (!in_array($message['author_id'], $authors_arr)) {
                    $authors_arr[] = $message['author_id'];
                    $messages_arr[] = $message['id'];
                }
            }
        }

        $msg_line = implode(',', $messages_arr);

        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE id IN($msg_line) ORDER BY publ_time DESC ");
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function getChatMessages(int $member_id, int $room_id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE activity='1' AND ((destination_id=:a AND author_id=:b) OR (destination_id=:c AND author_id=:d)) ");
        $sql->bindParam(':a', $this->getAuthor());
        $sql->bindParam(':b', $room_id);
        $sql->bindParam(':c', $room_id);
        $sql->bindParam(':d', $this->getAuthor());
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }


    public function getNewChatMessage(int $member_id, int $room_id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE (destination_id=:a AND author_id=:b) OR (destination_id=:c AND author_id=:d) AND activity='1' AND is_read='0' ORDER BY publ_time DESC LIMIT 1");
        $sql->bindParam(':a', $this->getAuthor());
        $sql->bindParam(':b', $room_id);
        $sql->bindParam(':c', $room_id);
        $sql->bindParam(':d', $this->getAuthor());
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function markChatAsRead(int $room_id)
    {
        $sql = $this->pdo->prepare("UPDATE " . $this->setTable() . " SET is_read='1' WHERE destination_id=:to_id AND author_id=:from_id AND is_read='0'");
        $sql->bindParam(':to_id', $this->getAuthor());
        $sql->bindParam(':from_id', $room_id);
        $sql->execute();
    }

    public function isRead()
    {
        if ($this->showField('is_read')) {
            return true;
        } else {
            return false;
        }
    }

    public function isUnread()
    {
        if ($this->showField('was_read') == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function create($description, int $destination_id)
    {
        $publ_time = time();
        $line1 = 'destination_id, author_id, description, publ_time';
        $line2 = $destination_id . ',' . $this->getAuthor() . ",'$description',$publ_time";
        $sql = $this->pdo->prepare("INSERT INTO " . $this->setTable() . "(" . $line1 . ")" . "VALUES(" . $line2 . ")");
        try {
            $sql->execute();
            //сюда вставить код для отправки сообщений  втелегрма юзеру
            $author = new Member($this->getAuthor());
            $destination_user = new Member($destination_id);
            $telegram = new Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');
            $message = 'Новое сообщение от ' . $author->getField('title') . ':';
            $telegram->send($message, $destination_user->getField('telegram_id'));

            $message = trim($description);
            $telegram->send($message, $destination_user->getField('telegram_id'));

        } catch (Exception $e) {
            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
        }
    }

    public function delete()
    {
        $member = new Member($this->getAuthor());
        if ($member->member_id() == $this->author() || $member->isAdmin()) {
            $sql = $this->pdo->prepare("DELETE FROM " . $this->setTable() . " WHERE id=:id");
            $sql->bindParam(':id', $this->messageId());
            $sql->execute();
        }
    }

    public function deleteDialog(int $room_id)
    {
        $sql = $this->pdo->prepare("UPDATE " . $this->setTable() . " SET activity='0' WHERE (to_id=:a AND from_id=:b) OR (to_id=:c AND from_id=:d) ");
        $sql->bindParam(':a', $this->getAuthor());
        $sql->bindParam(':b', $room_id);
        $sql->bindParam(':c', $room_id);
        $sql->bindParam(':d', $this->getAuthor());
        $sql->execute();
    }

    public function author()
    {
        return $this->showField('author_id');
    }

    public function destination()
    {
        return $this->showField('to_id');
    }


    public function publ_time()
    {
        return date_format_rus($this->showField('publ_time'));
    }


}