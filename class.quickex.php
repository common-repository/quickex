<?php

require_once(plugin_dir_path(__FILE__) . 'class.quickex.api.php');

class Quickex
{
    const VERSION = '0.9.1.6';

    /**
     * @var QuickexApi
     */
    public $api;

    public $apiKey           = '';
    public $mainUrl          = '/';
    public $howItWorksUrl    = '/';
    public $termsOfUseUrl    = '/';
    public $privacyPolicyUrl = '/';
    public $themeColor       = 'F0B90B';
    public $themeTextColor   = '212833';
    public $theme            = 'light';
    public $showHeader       = 1;
    public $showFooter       = 1;

    public $showRefundAddress = 1;

    public  $shortCode = 'quickex';
    private $pluginDir = null;

    public $themeList = [
        'light',
        'dark',
        'green',
        'red',
    ];

    private static $self = null;

    public static function init()
    {
        if (self::$self === null) {
            self::$self = new self();
        }

        return self::$self;
    }

    private function __construct()
    {
        $this->pluginDir = plugin_dir_url(__FILE__);
        $this->initHooks();
    }

    public function addMenuPages()
    {
        add_menu_page(
            'Quickex', // Название страниц (Title)
            'Quickex', // Текст ссылки в меню
            'manage_options', // Требование к возможности видеть ссылку
            'quickex/views/settings.php' // 'slug' - файл отобразится по нажатию на ссылку
        );

        wp_enqueue_script('qinit', $this->pluginDir . 'js/qinit.js', ['jquery'], self::VERSION, true);
        wp_enqueue_script('jscolor', $this->pluginDir . 'js/jscolor.js', ['jquery'], self::VERSION, true);

    }

    /**
     * Initializes WordPress hooks
     */
    private function initHooks()
    {
        add_action('admin_menu', [$this, 'addMenuPages']);
        $this->setupWpFilters();
        $this->initParams();
        $this->initUrls();
    }

    private function prepareData($data)
    {
        foreach ($data as $n => $d) {
            $data[$n] = sanitize_text_field($d);
        }

        return $data;
    }

    private function initUrls()
    {
        $result = null;

        $url = explode('?', $_SERVER['REQUEST_URI']);

        if (in_array(
            $url[0],
            [
                '/api/rate',
                '/api/rate-interval',
                '/api/validate-address',
                '/exchange/step-2',
                '/exchange/step-2/',
                '/exchange/step-3',
                '/exchange/step-3/',
                '/exchange/step-4',
                '/exchange/step-4/',
                '/exchange/status',
                '/exchange/status/',
                '/exchange/create',
                '/exchange/create/',
            ]
        )) {
            $get  = $this->prepareData($_GET);
            $post = $this->prepareData($_POST);
        }
        switch ($url[0]) {
            case '/css/qstyle-init':
            case '/css/qstyle-init/':
                header("Content-type: text/css", true);
                $result = $this->view('qstyle_init', ['quickex' => $this]);
                break;
            case '/api/rate':
                $result = $this->api->getRate($get);
                break;
            case '/api/files/rates':
                header("Content-Type: text/xml");
                $rates  = $this->api->getRates();
                $result = $this->view('rates_xml', ['rates' => $rates]);
                break;
            case '/api/rate-interval':
                $result = $this->api->getRateInterval($get);
                break;
            case '/api/pairs':
                $result = $this->api->getPairs();
                break;
            case '/api/validate-address':
                $result = $this->api->validateAddress($get);
                break;
            case '/exchange/step-2':
            case '/exchange/step-2/':
                $this->loadResources(2);
                $params = $get;
                if (empty($params['from']) || empty($params['to']) || empty($params['amount'])) {
                    wp_redirect('/');
                    exit;
                }
                $params['step']             = 2;
                $params['info']             = [
                    $params['from'] => $this->api->getСurrencyInfo($params['from']),
                    $params['to']   => $this->api->getСurrencyInfo($params['to']),
                ];
                $params['privacyPolicyUrl'] = $this->privacyPolicyUrl;
                $params['howItWorksUrl']    = $this->howItWorksUrl;
                $params['termsOfUseUrl']    = $this->termsOfUseUrl;

                $result = $this->getView('step2', $params);
                break;
            case '/exchange/step-3':
            case '/exchange/step-3/':
                $this->loadResources(3);
                $params = $this->api->exchangeStatus($get);
                if ($params['result'] === false) {
                    wp_redirect('/');
                    exit;
                }
                $params['id']   = $get['id'];
                $params['step'] = 3;
                $params['info'] = [
                    $params['from'] => $this->api->getСurrencyInfo($params['from']),
                    $params['to']   => $this->api->getСurrencyInfo($params['to']),
                ];

                $result = $this->getView('step3', $params);
                break;
            case '/exchange/step-4':
            case '/exchange/step-4/':
                $this->loadResources(4);
                $params = $this->api->exchangeStatus($get);
                $id = sanitize_text_field($get['id']);
                if ($params['status'] !== 'success' || $params['result'] === false) {
                    wp_redirect('/exchange/step-3?id=' . $id);
                    exit;
                }
                $params['id']   = $id;
                $params['step'] = 4;
                $params['info'] = [
                    $params['from'] => $this->api->getСurrencyInfo($params['from']),
                    $params['to']   => $this->api->getСurrencyInfo($params['to']),
                ];

                $result = $this->getView('step4', $params);
                break;
            case '/exchange/status':
            case '/exchange/status/':
                $data   = $this->api->exchangeStatus($get);
                $result = json_encode($data);
                break;
            case '/exchange/create':
            case '/exchange/create/':
                $data = $this->api->exchangeCreate($post);

                if ($data['result'] === true) {
                    wp_redirect('/exchange/step-3?id=' . $data['id']);
                } else {
                    wp_redirect($_SERVER['HTTP_REFERER'] . '&error=' . $data['error']);
                }
                exit;

                break;
        }

        if ($result !== null) {
            echo $result;
            exit;
        }
    }


    private function initParams()
    {
        /* Объявляем параметры настроек */
        add_option('quickex_api_key', $this->apiKey);
        add_option('quickex_theme', $this->theme);
        add_option('quickex_main_url', $this->mainUrl);
        add_option('quickex_how_it_works_url', $this->howItWorksUrl);
        add_option('quickex_terms_of_use_url', $this->termsOfUseUrl);
        add_option('quickex_privacy_policy_url', $this->privacyPolicyUrl);
        add_option('quickex_theme_color', $this->themeColor);
        add_option('quickex_theme_text_color', $this->themeTextColor);
        add_option('quickex_show_header', $this->showHeader);
        add_option('quickex_show_footer', $this->showFooter);
        add_option('quickex_show_refund_address', $this->showRefundAddress);
        $this->themeColor        = get_option('quickex_theme_color');
        $this->themeTextColor    = get_option('quickex_theme_text_color');
        $this->showHeader        = get_option('quickex_show_header');
        $this->showFooter        = get_option('quickex_show_footer');
        $this->showRefundAddress = get_option('quickex_show_refund_address');
        $this->apiKey            = get_option('quickex_api_key');
        $this->theme             = get_option('quickex_theme');
        $this->mainUrl           = get_option('quickex_main_url');
        $this->privacyPolicyUrl  = get_option('quickex_privacy_policy_url');
        $this->termsOfUseUrl     = get_option('quickex_terms_of_use_url');
        $this->howItWorksUrl     = get_option('quickex_how_it_works_url');
        $this->api               = new QuickexApi($this->apiKey);
    }

    public function saveParams()
    {
        if (!empty($_POST)) {
            $this->apiKey            = $this->post('quickex_api_key', '');
            $this->theme             = $this->post('quickex_theme', '');
            $this->themeColor        = $this->post('quickex_theme_color', $this->themeColor);
            $this->themeTextColor    = $this->post('quickex_theme_text_color', $this->themeTextColor);
            $this->showHeader        = (int) $this->post('quickex_show_header', 0);
            $this->showFooter        = (int) $this->post('quickex_show_footer', 0);
            $this->showRefundAddress = (int) $this->post('quickex_show_refund_address', 0);
            $this->mainUrl           = $this->post('quickex_main_url', '/');
            $this->privacyPolicyUrl  = $this->post('quickex_privacy_policy_url', '/');
            $this->termsOfUseUrl     = $this->post('quickex_terms_of_use_url', '/');
            $this->howItWorksUrl     = $this->post('quickex_how_it_works_url', '/');
            update_option('quickex_api_key', $this->apiKey);
            update_option('quickex_theme', $this->theme);
            update_option('quickex_main_url', $this->mainUrl);
            update_option('quickex_privacy_policy_url', $this->privacyPolicyUrl);
            update_option('quickex_terms_of_use_url', $this->termsOfUseUrl);
            update_option('quickex_how_it_works_url', $this->howItWorksUrl);
            update_option('quickex_theme_color', $this->themeColor);
            update_option('quickex_theme_text_color', $this->themeTextColor);
            update_option('quickex_show_header', $this->showHeader);
            update_option('quickex_show_refund_address', $this->showFooter);
            update_option('quickex_show_footer', $this->showRefundAddress);
            $this->setAlert('Сохранено!', 'Настройки успешно сохранены');
        }
    }

    private function post($name, $default = null)
    {
        return isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : $default;
    }

    public function loadResources($step = 1)
    {
        wp_enqueue_style('qstyle-init', '/css/qstyle-init', [], self::VERSION);
        wp_enqueue_style('qstyle', $this->pluginDir . 'css/qstyle.css', [], self::VERSION);
        wp_enqueue_style('select2', $this->pluginDir . 'css/select2.min.css', [], self::VERSION);
        wp_enqueue_script('qinit', $this->pluginDir . 'js/qinit.js', ['jquery'], self::VERSION, true);

        if ($step === 1) {
            wp_enqueue_script('select2', $this->pluginDir . 'js/select2.js', ['jquery'], self::VERSION, true);
            wp_enqueue_script('qwidget', $this->pluginDir . 'js/qwidget.js', ['jquery'], self::VERSION, true);
        }
        if ($step === 2) {
            wp_enqueue_style('qsteps', $this->pluginDir . 'css/qsteps.css', [], self::VERSION);
            wp_enqueue_script('qstep2', $this->pluginDir . 'js/qstep2.js', ['jquery'], self::VERSION, true);
        }
        if ($step === 3) {
            wp_enqueue_style('qsteps', $this->pluginDir . 'css/qsteps.css', [], self::VERSION);
            wp_enqueue_script('qstep3', $this->pluginDir . 'js/qstep3.js', ['jquery'], self::VERSION, true);
        }
        if ($step === 4) {
            wp_enqueue_style('qsteps', $this->pluginDir . 'css/qsteps.css', [], self::VERSION);
        }

    }

    public function addWidget($content)
    {
        if (false === strpos($content, '[' . $this->shortCode)) {
            return $content;
        }
        $this->loadResources();
        preg_match_all("|\[{$this->shortCode} (.*)\]|U", $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $row) {
                $_row     = str_replace(['&#171;', '&#187;', '&#8243;'], '"', $row);
                $settings = json_decode(trim($_row), true);
                $html     = $this->view('widget', $settings);
                $content  = str_replace("[{$this->shortCode} {$row}]", $html, $content);
            }
        }

        return $content;
    }

    private function getView($name, $params = [])
    {
        $content = $this->view($name, $params);
        $content = $this->view('main', ['content' => $content, 'quickex' => $this]);

        return $content;
    }

    private function view($name, $params = [])
    {
        if ($params) {
            extract($params);
        }
        ob_start();
        include(__DIR__ . '/views/' . $name . '.php');
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    private function setupWpFilters()
    {
        add_filter('the_content', [$this, 'addWidget']);
        add_filter('widget_text', [$this, 'addWidget']);
        add_filter('widget_title', [$this, 'addWidget']);
    }

    private $alertKey = 'q-alert';

    public function setAlert($title, $text = '')
    {
        if (!session_id()) {
            session_start();
        }
        $_SESSION[$this->alertKey] = json_encode(['title' => $title, 'text' => $text]);
    }

    public function getAlert()
    {
        if (!session_id()) {
            session_start();
        }
        $alert = !empty($_SESSION[$this->alertKey]) ? json_decode($_SESSION[$this->alertKey], true) : null;
        unset($_SESSION[$this->alertKey]);

        return $alert;
    }

}