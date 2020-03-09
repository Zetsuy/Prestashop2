<?php 

require _PS_MODULE_DIR_.'jeremy_blog/classes/BlogCategory.php';
require _PS_MODULE_DIR_.'jeremy_blog/classes/BlogPost.php';

if (!defined('_PS_VERSION_')) {
    exit;
}

class Jeremy_Blog extends Module
{
    public function __construct()
    {
        $this->name = 'jeremy_blog';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jeremy Garcia';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        $this->need_instance = true;

        parent::__construct();

        $this->displayName = $this->l('Jeremy Blog');
        $this->description = $this->l('Gestion d\'un blog');

        $this->confirmUninstall = $this->l('Voulez vous desinstaller le module?');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('Pas de nom donné');
        }
    }

    public function install()
    {
        $bdd = false;
        Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blog_category (
                 id_blog_category INT(11) NOT NULL AUTO_INCREMENT,
                 title VARCHAR(255) NOT NULL,
                 description TEXT,
                 PRIMARY KEY (id_blog_category)               
                )'
            
        );
        Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'blog_post (
                id_blog_post INT(11) NOT NULL AUTO_INCREMENT,
                id_blog_category INT(11) NOT NULL,
                title VARCHAR(255) NOT NULL,
                excerpt VARCHAR(255) NOT NULL,
                content TEXT,
                PRIMARY KEY (id_blog_post)              
                )'
        );

        $this->addTab('AdminBlogCategory', 'Blog category');
        $this->addTab('AdminBlogPost', 'Blog post');
        return parent::install() && $bdd;
    }

    public function uninstall()
    {
        $tabCategory = Tab::getInstanceFromClassName('AdminBlogCategory');
        $tabCategory->delete();
        $tabPost = Tab::getInstanceFromClassName('AdminBlogPost');
        $tabPost->delete();
        return parent::uninstall();
    }

    public function getContent(){
        return '<a href="'.Context::getContext()->link->getAdminLink('AdminBlogCategory').'">Admin Blog Category</a><br>'.'<a href="'.Context::getContext()->link->getAdminLink('AdminBlogPost').'">Admin Blog Post</a>';
    }
    public function addTab ($controller, $tabName){
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $controller;
        $tab->name = array();

        foreach(Language::getLanguages(true) as $lang){
            $tab->name[$lang['id_lang']] = $tabName;
        }

        $tab->id_parent = -1;
        $tab->module = $this->name;
        $tab->add();
    }

    public function displayForm()
    {
        
    }

}