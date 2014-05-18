<?php

/*
 * Controller admin panel
 */

class admin extends core {
    /*
     * Home admin panel
     */

    function index() {
        $news = $this->newsUI->get_news();
        $this->render('main', 'admin/list', compact('news'));
    }

    /*
     * Adding news
     */

    function add() {
        if (!empty($_POST['name']) && !empty($_POST['text'])) {
            $this->newsUI->add_news($_POST['name'], $_POST['text']);
            $this->redirect('/admin', 'The news has been successfully added', 'success');
        }
        $this->render('main', 'admin/add', array());
    }

    /*
     * news editing
     */

    function edit($id) {
        if (!empty($_POST['name']) && !empty($_POST['text'])) {
            $this->newsUI->edit_news($id, $_POST['name'], $_POST['text']);
            $this->redirect('/admin', 'The news has been successfully changed', 'success');
        }
        $new = $this->newsUI->get($id);
        $this->render('main', 'admin/edit', compact('new'));
    }

    /*
     * Deleting news
     */

    function del($id) {
        $new = $this->newsUI->delete_news($id);
        $this->redirect('/admin', 'News successfully removed', 'success');
    }

}
