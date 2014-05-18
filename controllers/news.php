<?php

/*
 * O controller on the main news
 */

class news extends Core {
    /*
     * Page with a list of news
     */

    function index() {
        $news = $this->newsUI->get_news();
        $this->render('main', 'news/list', compact('news'));
    }

}
