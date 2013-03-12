<?php 

$posts = mapasdevista_get_posts(get_the_ID(), $mapinfo); 
function mapasdevista_taxonomy_checklist_images($taxonomy, $parent = 0) {
    global $posts, $wpdb;
    
    /*
    $cur_page = get_queried_object();
    $terms = array();
    $terms_ids = array();

    $page_id = $cur_page->ID;
    $posts_ids = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key ='_mpv_inmap' AND meta_value = '$page_id'");

    foreach($posts_ids as $post_id){
        $_terms = get_the_terms($post_id, $taxonomy);
        if(is_array($_terms))
            foreach($_terms as $_t){
                if(!in_array($_t->term_id,$terms_ids) && $_t->parent == $parent){
                    $terms_ids[] = $_t->term_id;
                    $terms[] = $_t;
                }
            }
    }

    if (!is_array($terms) || ( is_array($terms) && sizeof($terms) < 1 ) )
        return;
	*/
	$terms = mycategoryorder_catQuery(0);
    ?>


    <?php foreach ($terms as $term): $image_url = get_category_image_url($term->term_id); if (!$image_url) continue; ?>
        <li>
            <input type="checkbox" class="taxonomy-filter-checkbox" value="<?php echo $term->slug; ?>" name="filter_by_<?php echo $taxonomy; ?>[]" id="filter_by_<?php echo $taxonomy; ?>_<?php echo $term->slug; ?>" style="display:none" />
            <label for="filter_by_<?php echo $taxonomy; ?>_<?php echo $term->slug; ?>" onclick="if(jQuery(this).hasClass('selected')) jQuery(this).removeClass('selected'); else jQuery(this).addClass('selected');">
                <?php echo $image_url ? "<img src=\"$image_url\" class=\"category-image\" alt=\"$term->name\" title=\"$term->name\"/>" : $term->name; ?>
            </label>
        </li>

        

    <?php endforeach; ?>


<?php
}
?>
<div id="results" class="clearfix">
        
    <?php if (is_array($mapinfo['taxonomies'])): ?>
        <?php if(!isset($mapinfo['logical_operator']) || !trim($mapinfo['logical_operator'])):?>
            <div id='logical_oparator'>
                <label><input name="logical_oparator" type='radio' value="AND" checked="checked" ><?php _e('Displays posts that match all the filters', 'mapasdevista'); ?></label><br/>
                <label><input name="logical_oparator" type='radio' value="OR" ><?php _e('Displays posts that match at least one of the filters', 'mapasdevista'); ?></label>
            </div>
        <?php elseif($mapinfo['logical_operator'] == "AND"): ?>
            <div id='logical_oparator'>
                <input name="logical_oparator" type='hidden' value="AND" />
            </div>
        <?php elseif($mapinfo['logical_operator'] == "OR"): ?>
            <div id='logical_oparator'>
                <input name="logical_oparator" type='hidden' value="OR" />
            </div>
        <?php endif; ?>

            <ul class="filter-group filter-taxonomy" id="filter_taxonomy_category">
                <?php mapasdevista_taxonomy_checklist_images('category'); ?>
            </ul>


    <?php endif; ?>
</div>
