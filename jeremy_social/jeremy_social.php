<?php if (!defined('_PS_VERSION_')) {
    exit;
}

class Jeremy_Social extends Module
{
    public function __construct()
    {
        $this->name = 'jeremy_social';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jeremy Garcia';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Jeremy Reseaux Sociaux');
        $this->description = $this->l('Affichage des reseaux sociaux');

        $this->confirmUninstall = $this->l('Voulez vous desinstaller le module?');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('Pas de nom donné');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install() ||
            !$this->registerHook('leftColumn') ||
            !$this->registerHook('header') ||
            !Configuration::updateValue('MYMODULE_NAME', 'jeremy_social')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('MYMODULE_NAME')
        ) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit'.$this->name)) {
            
            $myModuleName = strval(Configuration::get('MYMODULE_NAME'));
            $lientwitter = strval(Tools::getValue('LIEN_TWITTER'));
            $lienfb = strval(Tools::getValue('LIEN_FACEBOOK'));
            $lieninsta = strval(Tools::getValue('LIEN_INSTAGRAM'));
            if (
                !$myModuleName ||
                empty($myModuleName) ||
                !Validate::isGenericName($myModuleName)
                
            ) {
                $output .= $this->displayError($this->l('Mauvaise valeur'));
            } else {
                Configuration::updateValue('MYMODULE_NAME', $myModuleName);
                Configuration::updateValue('LIEN_FACEBOOK', $lienfb);
                Configuration::updateValue('LIEN_TWITTER', $lientwitter);
                Configuration::updateValue('LIEN_INSTAGRAM', $lieninsta);
                $output .= $this->displayConfirmation($this->l('Mise à jour faite'));
            }
        }

        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        // Get default language
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fieldsForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Liens'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Facebook'),
                    'name' => 'LIEN_FACEBOOK',
                    'size' => 20,
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Twitter'),
                    'name' => 'LIEN_TWITTER',
                    'size' => 20,
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Instagram'),
                    'name' => 'LIEN_INSTAGRAM',
                    'size' => 20,
                    'required' => true
                ]
            ],
            
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ]
        ];

        

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        // Language
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        // Load current value
        //$helper->fields_value['MYMODULE_NAME'] = Configuration::get('MYMODULE_NAME');
        $helper->fields_value['LIEN_FACEBOOK'] = Configuration::get('LIEN_FACEBOOK');
        $helper->fields_value['LIEN_TWITTER'] = Configuration::get('LIEN_TWITTER');
        $helper->fields_value['LIEN_INSTAGRAM'] = Configuration::get('LIEN_INSTAGRAM');

        return $helper->generateForm($fieldsForm);
    }

    public function hookDisplayLeftColumn($params)
    {
    $this->context->smarty->assign([
        'my_module_name' => Configuration::get('MYMODULE_NAME'),
        'lien_twitter' => Configuration::get('LIEN_TWITTER'),
        'lien_facebook' => Configuration::get('LIEN_FACEBOOK'),
        'lien_instagram' => Configuration::get('LIEN_INSTAGRAM')
    ]);

    return $this->display(__FILE__, 'jeremy_social.tpl');
    }

}