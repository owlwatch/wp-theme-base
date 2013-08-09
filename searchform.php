<?php
$action = home_url('/');
$_search_index = (int) @$GLOBALS['_searchform_index'];
$id = 's'.($_search_index++);
$GLOBALS['_searchform_index'] = $_search_index;
?>
<form class="search-form form-horizontal" role="search" method="get" action="<?php echo $action; ?>">
    <div class="search-input"><label class="screen-reader-text" for="<?= $id ?>">Search for:</label>
        <input class="text-input" type="text" value="<?= esc_attr( @$_REQUEST['s'] ) ?>" name="s" id="<?= $id ?>" />
        <input class="search-icon btn btn-primary" type="submit" id="searchsubmit" value="Search" />
    </div>
</form>