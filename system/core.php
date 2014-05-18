<?php

/*
 * system kernel
 */

class Core
{

    public $request = null;
    public $default_controller = 'news';
    public $default_method = 'index';
    /**
     * @var \PDO
     */
    public $db = null;
    public $config = null;
    private $params = array();

    /*
     * The constructor for the class of heirs
     *
     * Overrides the class for their accessibility
     */

    /**
     * @TODO remove core from every class
     * @see http://ru.wikipedia.org/wiki/%D0%92%D0%BD%D0%B5%D0%B4%D1%80%D0%B5%D0%BD%D0%B8%D0%B5_%D0%B7%D0%B0%D0%B2%D0%B8%D1%81%D0%B8%D0%BC%D0%BE%D1%81%D1%82%D0%B8
     */
    function __construct()
    {
        // @TODO remove core from every class.
        global $core; // that's awfull
        if (!is_subclass_of($this, 'core')) {
            return;
        }
        foreach ($core as $key => $val) {
            if ((!is_string($core->$key) || !is_link($core->$key)) && $this->$key != $core->$key && !is_object(
                    $this->$key
                )
            ) {
                $this->$key = & $core->$key;
            } else {
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
        $this->params  = explode('/', $this->request['path']);
        $this->params  = array_slice($this->params, 1);
        foreach ($this->params as $key => $param) {
            if ($param != '') {
                $this->params[$key] = urldecode($param);
            } else {
                unset($this->params[$key]);
            }
        }
    }

    /*
     * Connection database
     */

    protected function connectDb()
    {
        $connect_str = 'mysql:host=' . $this->config['db.host'] . ';dbname=' . $this->config['db.name'];
        $this->db    = new PDO($connect_str, $this->config['db.user'], $this->config['db.pass']);
        $error_array = $this->db->errorInfo();

        if ($this->db->errorCode() != 0) {
            echo "Failed to connect to database: " . $error_array[2] . '<br />';
            exit();
        }
    }

    /*
     * user Authentication
     */

    protected function userAccess()
    {
        if (!empty($_GET['logout'])) {
            $_SESSION['admin'] = false;
            $this->redirect('/', 'Exit executed successfully', 'success');
        } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
            $error = false;
            if ($_POST['username'] != $this->config['user.login']) {
                $this->addMsg('Invalid username', 'danger');
                $error = true;
            }
            if ($_POST['password'] != $this->config['user.pass']) {
                $this->addMsg('Invalid password', 'danger');
                $error = true;
            }
            if (!$error) {
                $_SESSION['admin'] = true;
                $this->addMsg('Sign executed successfully', 'success');
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

        $this->connectDb();

        $this->userAccess();

        if (!empty($this->params[0]) && file_exists(CONTROLLERS_PATH . '/' . $this->params[0] . '.php')) {
            if ($this->params[0] == 'admin' && !$_SESSION['admin']) {
                $this->redirect('/', 'You do not have access to this section', 'danger');
            }
            include CONTROLLERS_PATH . '/' . $this->params[0] . '.php';
            $controller   = new $this->params[0]();
            $this->params = array_slice($this->params, 1);
        } else {
            include CONTROLLERS_PATH . '/' . $this->default_controller . '.php';
            $controller = new $this->default_controller();
        }

        if (!empty($this->params[0]) && is_callable(array($controller, $this->params[0]))) {
            $method       = $this->params[0];
            $this->params = array_slice($this->params, 1);
        } else {
            $method = 'index';
        }
        call_user_func_array(array($controller, $method), $this->params);
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

    function addMsg($text, $type)
    {
        $_SESSION['msgs'][] = compact('text', 'type');
    }

    /*
     * Creating a redirect to another page
     */

    public function redirect($href = '/', $text = false, $type = 'info')
    {
        if ($text !== false) {
            $this->addMsg($text, $type);
        }

        header("Location: {$href}");
        exit("Redirect to: <a href = '{$href}'>{$href}</a>");
    }

    /*
     * Loading of objects that are accessed
     */

    public function &__get($name)
    {
        global $core;
        if (isset($core->{$name})) {
            return $core->{$name};
        } elseif (file_exists(MODELS_PATH . '/' . $name . '.php')) {
            include_once MODELS_PATH . '/' . $name . '.php';
            $this->{$name} = new $name();
            return $this->{$name};
        } else {
            return false;
        }
    }

}
