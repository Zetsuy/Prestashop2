<?php

class BlogPost extends ObjectModel
{
    public $id;
    /** @var int  */
    public $id_blog_post;
    /** @var int  */
    public $id_blog_category;
    /** @var string  */
    public $title;
    /** @var string  */
    public $excerpt;
    /** @var string  */
    public $content;

    public static $definition = array(
        'table' => 'blog_post',
        'primary' => 'id_blog_post',
        'fields' => [
            'id_blog_category' => ['type'=>self::TYPE_INT,'requird'=>true],
            'title' => ['type'=>self::TYPE_STRING,'validate'=>'isString','size'=>255,'requird'=>true],
            'excerpt' => ['type'=>self::TYPE_STRING,'validate'=>'isString','size'=>255,'requird'=>true],
            'content' => ['type'=>self::TYPE_STRING,'validate'=>'isString','size'=>255,'requird'=>true]
        ]
        );
}