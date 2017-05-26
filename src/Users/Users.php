<?php

namespace Alvo16\Users;

class Users implements \Anax\Common\AppInjectableInterface
{
    use \Anax\Common\AppInjectableTrait;

    public function getUserData($id)
    {
        $this->app->db->connect();
        $data = $this->app->db->executeFetchAll("SELECT * FROM users WHERE id = '$id'");

        return $data[0];
    }

    public function register($data)
    {
        $this->app->db->connect();

        $isDataValid = self::checkRegisterData($data);

        $username = $data['uname'];
        $psw = $data['psw'];
        $admin = isset($data['admin']) ? 1 : 0;

        if ($isDataValid) {
            // Encrypt password
            $psw = self::encryptPassword($psw);

            // Push user to the database
            self::addUser($username, $psw, $admin);

            // Redirect to the profile page
            if (strpos($_SERVER["HTTP_REFERER"], 'dashboard') !== false) {
                header("Location: " . $this->app->url->create('dashboard'));
            } else {
                self::login($data);
            }
        } else {
            // Redirect to error message
            header("Location: " . $this->app->url->create('wrongFormData'));
        }
    }

    public function login($data)
    {
        $isValid = self::checkLoginData($data);
        $username = $data['uname'];
        $id = self::getUserId($username);

        if ($isValid) {
            $this->app->session->set("user", $id);
            $this->app->cookie->set($username, "testCookie!");
            header("Location: " . $this->app->url->create('profile'));
        } else {
            header("Location: " . $this->app->url->create('wrongFormData'));
        }
    }

    public function logout()
    {
        $this->app->session->destroy();
        header("Location: " . $this->app->url->create(''));
    }

    public function updateProfile($data)
    {
        // var_dump($data);
        // exit;
        $username = $data['uname'];
        $password = empty($data['psw']) ? null : $data['psw'];
        $id = $data['id'];
        $admin = isset($data['admin']) ? 1 : 0;

        $pswHash = self::encryptPassword($password);

        $this->app->db->connect();

        $prevUsername = $this->app->db->executeFetchAll(
            "SELECT username FROM users WHERE id = '$id'"
        )[0]->username;

        if (empty($password)) {
            $sql = "UPDATE users
            SET
                username = '$username',
                admin = '$admin'
            WHERE username = '$prevUsername'";
        } else {
            $sql = "UPDATE users
            SET
                username = '$username',
                password = '$pswHash',
                admin = '$admin'
            WHERE username = '$prevUsername'";
        }

        $this->app->db->execute($sql);

        // self::login($data);
    }

    private function checkRegisterData($data)
    {
        $this->app->db->connect();
        // var_dump($data);
        // exit;

        $username = $data['uname'];
        $psw = $data['psw'];
        $pswRepeat = isset($data['pswrepeat']) ? $data['pswrepeat'] : null;
        // $admin = isset($data['admin']) ? $data['admin'] : false;

        if (!empty($pswRepeat)) {
            if ($psw !== $pswRepeat) {
                return false;
            }
        }

        $temp = $this->app->db->executeFetchAll("SELECT * FROM users WHERE username='$username'");

        if ($temp) {
            return false;
        }

        return true;
    }

    private function checkLoginData($data)
    {
        $username = $data['uname'];
        $psw = $data['psw'];

        $this->app->db->connect();
        // var_dump($this->app->db->executeFetchAll(
        //     "SELECT password FROM users WHERE username = '$username'"
        // ));
        // exit;

        $hash = $this->app->db->executeFetchAll(
            "SELECT password FROM users WHERE username = '$username'"
        );

        if (!empty($hash)) {
            return self::verifyPassword($psw, $hash[0]->password);
        } else {
            header("Location: " . $this->app->url->create('wrongFormData'));
        }
    }

    private function encryptPassword($psw)
    {
        return password_hash($psw, PASSWORD_DEFAULT);
    }

    private function verifyPassword($psw, $hash)
    {
        return password_verify($psw, $hash);
    }

    private function addUser($username, $psw, $admin)
    {
        $this->app->db->execute(
            "INSERT INTO users
            (
                username,
                password,
                admin
            )
            VALUES
            (
                '$username',
                '$psw',
                $admin
            )"
        );
    }

    public function removeUser($id)
    {
        $this->app->db->execute("DELETE FROM users WHERE id = '$id' LIMIT 1");
    }

    public function isAdmin($user = null)
    {
        $this->app->db->connect();
        $currentUser = isset($user) ? $user : self::getUsername($this->app->session->get('user'));

        if (isset($currentUser)) {
            $this->app->db->connect();
            $res = $this->app->db->executeFetchAll("SELECT admin FROM users WHERE username = '$currentUser'")[0]->admin;

            return $res == 1 ? true : false;
        } else {
            return false;
        }
    }

    public function getAllUsersData()
    {
        $this->app->db->connect();
        $sortSuffix = self::getSortingSuffix();
        $searchSuffix = self::getSearchSuffix();
        $res = $this->app->db->executeFetchAll("SELECT * FROM users" . ' ' . $searchSuffix . ' ' . $sortSuffix);

        return $res;
    }

    private function getSortingSuffix()
    {
        // $suffix = isset($_GET['sort']) ? $_GET['sort'] : ;
        if (isset($_GET['sort'])) {
            return $suffix = "ORDER BY {$_GET['sort']} ASC";
        } else {
            return $suffix = "ORDER BY id ASC";
        }
    }

    private function getSearchSuffix()
    {
        if (isset($_GET['search'])) {
            return "WHERE username LIKE '%{$_GET['search']}%'";
        } else {
            return '';
        }
    }

    private function getUserId($name)
    {
        $sql = "SELECT id FROM users WHERE username = '$name'";
        return $this->app->db->executeFetchAll($sql)[0]->id;
    }

    public function getUsername($id)
    {
        if (empty($id)) {
            return null;
        }
        $sql = "SELECT username FROM users WHERE id = '$id'";
        return $this->app->db->executeFetchAll($sql)[0]->username;
    }
}
