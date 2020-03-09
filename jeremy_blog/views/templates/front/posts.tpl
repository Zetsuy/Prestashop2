{extends file=$layout}

{block name='content'}
    <section id="main" class="card card-block">
        <h1>{$category[0].title}</h1>
        {foreach $posts as $post}
            <div class="row">
                <a href="{$base_url}module/jeremy_blog/post?id_blog_post={$post.id_blog_post}">{$post.title}</a>
            </div>
        {/foreach}
    </section>
{/block}