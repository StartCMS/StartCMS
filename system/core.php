<?php

/*
 * system kernel
 */

class Core
{

    public $request = NULL;
    public $default_controller = 'news';
    public $default_method = 'index';
    public $db = NULL;
    public $config = NULL;

    /*
     * The constructor for the class of heirs
     *
     * Overrides the class for their accessibility
     */

    function __construct()
    {
        global $core;
        if (is_subclass_of($this, 'core')) {
            foreach ($core as $key => $val) {
                if ((!is_string($core->$key) || !is_link($core->$key) ) && $this->$key != $core->$key && !is_object($this->$key)) {
                    $this->$key = &$core->$key;
                } else
                    $this->$key = $core->$key;
            }
        }
    }

    /*
     * Parses the query string parameters on
     */

    public function parseUrl($uri)
    {
        $this->request = parse_url($uri);
        $this->params = explode('/', $this->request['path']);
        $this->params = array_slice($this->params, 1);
        foreach ($this->params as $key => $param) {
            if ($param != '')
                $this->params[$key] = urldecode($param);
            else
                unset($this->params[$key]);
        }
    }

    /*
     * Connection database
     */

    function connect_db()
    {
        $this->db = new mysqli($this->config['db.host'], $this->config['db.user'], $this->config['db.pass'], $this->config['db.name'], $this->config['db.port']);
        if ($this->db->connect_error) {
            echo 'Failed to connect to database' . $this->db->connect_error;
            exit();
        }
    }

    /*
     * user Authentication
     */

    function user_access()
    {
        if (!empty($_GET['logout'])) {
            $_SESSION['admin'] = false;
            $this->redirect('/', 'Exit executed successfully', 'success');
        } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
            $error = false;
            if ($_POST['username'] != $this->config['user.login']) {
                $this->add_msg('Invalid username', 'danger');
                $error = true;
            }
            if ($_POST['password'] != $this->config['user.pass']) {
                $this->add_msg('Invalid password', 'danger');
                $error = true;
            }
            if (!$error) {
                $_SESSION['admin'] = true;
                $this->add_msg('Sign executed successfully', 'success');
            } else {
                $_SESSION['admin'] = false;
            }
        }
    }

    /*
     * Method platform initialization
     */

    public function start()
    {
        $this->parseUrl($_SERVER['REQUEST_URI']);

        $this->connect_db();

        $this->user_access();

        if (!empty($this->params[0]) && file_exists(CONTROLLERS_PATH . '/' . $this->params[0] . '.php')) {
            if ($this->params[0] == 'admin' && !$_SESSION['admin']) {
                $this->redirect('/', 'You do not have access to this section', 'danger');
            }
            include CONTROLLERS_PATH . '/' . $this->params[0] . '.php';
            $controller = new $this->params[0]();
            $this->params = array_slice($this->params, 1);
        } else {
            include CONTROLLERS_PATH . '/' . $this->default_controller . '.php';
            $controller = new $this->default_controller();
        }

        if (!empty($this->params[0]) && is_callable(array($controller, $this->params[0]))) {
            $method = $this->params[0];
            $this->params = array_slice($this->params, 1);
            call_user_func_array(array($controller, $method), $this->params);
        } else {
            call_user_func_array(array($controller, 'index'), $this->params);
        }
    }

    /*
     * Conclusion submission template and connection
     */

    public function render($template, $view, $data)
    {
        ob_start();
        extract($data);
        include VIEWS_PATH . '/' . $view . '.php';
        $content = ob_get_clean();
        include TEMPLATES_PATH . '/' . $template . '.php';
    }

    /*
     * Setting the system messages
     */

    function add_msg($text, $type)
    {
        $_SESSION['msgs'][] = compact('text', 'type');
    }

    /*
     * Creating a redirect to another page
     */

    public function redirect($href = '/', $text = false, $type = 'info')
    {
        if ($text !== false)
            $this->add_msg($text, $type);

        header("Location: {$href}");
        exit("Перенаправление на: <a href = '{$href}'>{$href}</a>");
    }

    /*
     * Loading of objects that are accessed
     */

    public function &__get($name)
    {
        global $core;
        if (isset($core->{$name}))
            return $core->{$name};
        elseif (file_exists(MODELS_PATH . '/' . $name . '.php')) {
            include_once MODELS_PATH . '/' . $name . '.php';
            $this->{$name} = new $name();
            return $this->{$name};
        } else
            return false;
    }

}
