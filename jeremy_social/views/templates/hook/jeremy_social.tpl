<div id="mymodule_block_left" class="block" style="background-color:white; border:1px solid lightgrey; box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2); padding:10px 20px;">
  <div class="block_content">
      <ul><b>Suivez nous sur : </b></ul>
      {if $lien_facebook !== ''}
          <ul><a href="{$lien_facebook}" title="lien_facebook" target="_blank">Facebook</a></ul>
      {/if}
      {if $lien_twitter !== ''}
          <ul><a href="{$lien_twitter}" title="lien_twitter" target="_blank">Twitter</a></ul>
      {/if}
      {if $lien_instagram !== ''}
          <ul><a href="{$lien_instagram}" title="lien_instagram" target="_blank">Instagram</a></ul>
      {/if} 
  </div>
</div>