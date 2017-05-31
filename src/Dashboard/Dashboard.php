<?php

namespace Alvo16\Dashboard;

class Dashboard implements \Anax\Common\AppInjectableInterface
{
    use \Anax\Common\AppInjectableTrait;

    public function getHTML()
    {
        $this->app->db->connect();
        $data = $this->app->users->getAllUsersData();

        $html = "<table class='dashboard_table'>";
        $html .= "<tr>";

        $html .= "<th>ID</th>";
        $html .= "<th>Username</th>";
        $html .= "<th>Password</th>";
        $html .= "<th>Is admin?</th>";
        $html .= "<th>actions</th>";

        $html .= "</tr>";

        // var_dump($data);

        foreach (array_values($data) as $value) {
            $html .= "<tr>";
            $html .= "<form method='POST' action='{$this->app->url->create('updateProfileDashboard')}'>";
            $html .= "<td>$value->id</td>";
            $html .= "<td>
                    <input type='text' name='id' value='$value->id' hidden>
                    <input type='text' name='uname' value='$value->username'>
            </td>";

            $html .= "<td>
                    <input type='text' name='psw' placeholder='new password'>
            </td>";

            $html .= "<td>
                    <input type='checkbox' name='admin' ".($this->app->users->isAdmin($value->username)?"checked":"").">
            </td>";

            $html .= "<td>
                    <input type='submit' value='Update profile'>
                    <a href='{$this->app->url->create('removeUser')}?delete=$value->id'>delete</a>
            </td>";

            $html .= "</form>";
            $html .= "</tr>";
        }

        $html .= "<tr>";
        $html .= "<td>";
        $html .= "</td>";

        $html .= "<form method='POST' action='{$this->app->url->create('register')}'>";

        $html .= "<td>";
        $html .= "<input type='text' name='uname' placeholder='New username'>";
        $html .= "</td>";

        $html .= "<td>";
        $html .= "<input type='password' name='psw' placeholder='New password'>";
        $html .= "</td>";

        $html .= "<td>";
        $html .= "<input type='checkbox' name='admin'>";
        $html .= "</td>";

        $html .= "<td>";
        $html .= "<input type='submit' value='Add user'>";
        $html .= "</td>";

        $html .= "</form>";

        $html .= "</tr>";

        $html .= "</table>";

        return $html;
    }
}
