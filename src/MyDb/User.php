<?php

namespace MyDb;

use Exception;
use \PDO;

class User
{
    public int $id;
    public string $username;
    public string $type;

    function __construct(int $id)
    {
        global $dbh;
        $sth = $dbh->prepare('SELECT * FROM `s_user` WHERE `id` = ?');
        $sth->execute([$id]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if (!$result) throw new Exception(sprintf('No such user %d', $id));
        $this->id = $result['id'];
        $this->username = $result['username'];
        $this->type = $result['type'];
    }

    static function login(string $username, string $password): bool
    {
        global $dbh;
        $sth = $dbh->prepare(
            'SELECT `id`, `password` FROM `s_user` WHERE `username` = ?'
        );
        $sth->execute([$username]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 1) {
            $row = $result[0];
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                return true;
            }
        }
        return false;
    }

    static function count(): int
    {
        global $dbh;
        return count($dbh->query('SELECT `id` FROM `s_user`')->fetchAll(PDO::FETCH_ASSOC));
    }

    static function isLoggedIn(): User|bool
    {
        if (isset($_SESSION['id'])) return new User($_SESSION['id']);
        else return false;
    }

    static function checkLogin($type = null)
    {
        if (!$user = User::isLoggedIn()) redirect('/?page=login');
        if (isset($type) && $type != $user->type) redirect('/?page=login');
    }

    static function create(string $username, string $password, string $type): User
    {
        global $dbh;
        $sql = 'INSERT INTO `s_user` (`username`, `password`, `type`) VALUES (?, ?, ?)';
        $sth = $dbh->prepare($sql);
        $sth->execute([
            $username,
            password_hash($password, PASSWORD_DEFAULT),
            $type,
        ]);
        return new User($dbh->lastInsertId());
    }

    static function logout()
    {
        session_destroy();
    }
}
