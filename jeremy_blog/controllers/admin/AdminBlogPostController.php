<?php

class AdminBlogPostController extends ModuleAdminController
{
    public $name = 'BlogPost';
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'blog_post';
        $this->className = 'BlogPost';

        parent::__construct();

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->fields_list = [
            'id_blog_post' => [
                'title' => $this->trans('ID', [], 'Admin.Global')
            ],
            'id_blog_category' => [
                'title' => $this->trans('ID_Category', [], 'Admin.Global')
            ],
            'title' => [
                'title' => $this->trans('Titre', [], 'Admin.Global')
            ],
            'excerpt' => [
                'title' => $this->trans('Excerpt', [], 'Admin.Global')
            ],
            'content' => [
                'title' => $this->trans('Content', [], 'Admin.Global')
            ]
        ];
    }

    public function renderForm()
    {
        $this->fields_form = [
            'input' => [
                [
                    'type' => 'text',
                    'label' => 'Titre',
                    'name' => 'title',
                    'required' => true
                ],
                [
                    'type' => 'select',
                    'label' => 'Catégorie',
                    'name' => 'id_blog_category',
                    'options' => [
                        'query' =>
                            Db::getInstance()->executeS('SELECT id_blog_category, title FROM '._DB_PREFIX_. 'blog_category')
                        ,
                        'id' => 'id_blog_category',
                        'name' => 'title'
                    ],
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => 'Excerpt',
                    'name' => 'excerpt',
                    'required' => true
                ],
                [
                    'type' => 'textarea',
                    'label' => 'Content',
                    'id' => 'post_content',
                    'name' => 'content',
                    'required' => true,
                    'autoload_rte' => true
                ]
                ],
                'submit' => [
                    'title' => $this->trans('save',[],'Admin.Actions')
                ]
        ];
        return parent::renderForm();
    }
}
