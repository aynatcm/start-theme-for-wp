<?php
$flexibleContentPath = get_template_directory() . '/ACF/flexible-content/';

if (have_rows('page_builder')) :
    while (have_rows('page_builder')) :
        the_row();
        $layoutPage = get_row_layout();

        $cp = (object)get_row(true);
        
        $file = ($flexibleContentPath . str_replace('_', '-', $layoutPage)  . '.php');
        
        if (file_exists($file)) {
            include($file);
        }
    endwhile;
endif;
