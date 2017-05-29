<?php

namespace Alvo16\Navbar;

class Navbar implements \Anax\Common\AppInjectableInterface, \Anax\Common\ConfigureInterface
{
    use \Anax\Common\AppInjectableTrait;
    use \Anax\Common\ConfigureTrait;



    /**
     * Get HTML for the navbar.
     *
     * @return string as HTML with the navbar.
     */
    public function getHTML()
    {
        $items = $this->config['items'];
        $con = $this->config['config'];
        $navbarClass = $con['navbar-class'];

        $html = "<nav class='$navbarClass' role='navigation'>";
        $html .= "<ul>";

        https://cdn.pixabay.com/photo/2016/09/13/18/38/silverware-1667987_960_720.png
        $html .= "<a href='{$this->app->url->create('')}'>";
        $html .= "<img class='navbar_logo' src='{$this->app->url->asset('img/cup.png')}'>";
        $html .= "</a>";
        $html .= "<a href='{$this->app->url->create('')}' class='menu_items'><b>Crockery shop</b></a>";

        foreach ($items as $key => $value) {
            // Just to go around valudation problems
            $key = null;
            // That is why you validate -_-

            $url = $this->app->url->create($value['route']);
            $text = $value['text'];

            $html .= "<a href='$url' class='menu_items'>$text</a>";
        }

        if ($this->app->session->has('user')) {
            $name = $this->app->session->get('user');
            $html .= "<a href='{$this->app->url->create('profile')}' class='menu_items login_items user_name'>Member id: $name</a>";
            $html .= "<a href='{$this->app->url->create('logout')}' class='menu_items login_items logout_button'>Logout</a>";

            if ($this->app->users->isAdmin()) {
                $html .= "<a href='{$this->app->url->create('dashboard')}' class='menu_items login_items dashboard_button'>Dashboard</a>";
                $html .= "<a href='{$this->app->url->create('webshop')}' class='menu_items login_items dashboard_button'>Edit stock</a>";
                $html .= "<a href='{$this->app->url->create('content')}' class='menu_items login_items dashboard_button'>Edit content</a>";
            }
        } else {
            $html .= "<a href='#' class='menu_items login_items' id='modal_activator'>Login/register</a>";
        }

        $html .= "</ul>";
        $html .= "</nav>";

        return $html;
    }
}
