{extends file=$layout}

{block name='content'}
<section id="main">
    {foreach $categories as $category}
        <div class="row">
            <a href="{$base_url}module/jeremy_blog/category?id_blog_category={$category.id_blog_category}">{$category.title}</a>
        </div>
    {/foreach}
</section>
{/block}