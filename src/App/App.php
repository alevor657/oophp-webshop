<?php

namespace Alvo16\App;

/**
 * An App class to wrap the resources of the framework.
 */
class App
{
    public function redirect($url)
    {
        $this->response->redirect($this->url->create($url));
        exit;
    }

    public function render($page, $title = '', $data = null)
    {
        $this->view->add("take1/header", ["title" => "Webshop | $title"]);
        $this->view->add("navbar1/navbar");
        $this->view->add("take1/login_modal");
        $this->view->add($page, ["data" => $data]);
        $this->view->add("take1/footer");

        $this->response->setBody([$this->view, "render"])->send();
    }
}
