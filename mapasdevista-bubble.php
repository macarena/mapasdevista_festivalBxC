<section id="entry-default" class="clearfix">

    <?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>" id="balloon-post-link-<?php the_ID(); ?>" title="<?php the_title(); ?>" onClick="mapasdevista.linkToPost(this); return false;">Leia mais...</a>
    
</section>
