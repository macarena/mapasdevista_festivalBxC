        <div id="search" class="clearfix">
            <?php mapasdevista_image("icn-search.png", array("id" => "search-icon")); ?>
            <form id="searchform" method="GET">
                <?php $searchValue = isset($_GET['mapasdevista_search']) && $_GET['mapasdevista_search'] != '' ? $_GET['mapasdevista_search'] : __('Search...', 'mapasdevista'); ?>
                <input id="searchfield" name="mapasdevista_search" type="text" value="<?php echo $searchValue; ?>" title="<?php _e('Search...', 'mapasdevista'); ?>" />
                <input type="image" src="<?php echo mapasdevista_get_image("submit.png"); ?>"/>
            </form>
            
        </div>
