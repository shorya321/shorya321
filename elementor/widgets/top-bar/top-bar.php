<?php

if (!function_exists('coldest_dynamic_ticker_elementor_products_tabs_template')) {

    function coldest_dynamic_ticker_elementor_products_tabs_template($settings)
    {

?>
        <!--start of container-->
        <div class="slideshow-container">
            <div class="dynamic-ticker-menu">
                    <?php foreach ($settings['tabs_items'] as $key => $item) : ?>
                                <div class="tfc-topbar-Slides" id="tfc-slide-item">
                                <a href="" class="tfc-topbar-content"> <?php echo esc_html($item['title']); ?>
                            <?php
                            if (!empty($item['website_link']['url'])) :
                                $link =  $item['website_link']['url'];
                                echo '<a href="' . $link . '">' . $item['button_title'] . '</a>';
                            endif;
                            ?> 
                            </a>
                                </div>
                    <?php endforeach; ?>
            </div>
        </div>
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
        <!--end of container-->
        <?php
    }
}
?>


 