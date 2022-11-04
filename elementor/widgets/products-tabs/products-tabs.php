<?php

if (!function_exists('coldest_elementor_products_tabs_template')) {

    function coldest_elementor_products_tabs_template($settings)
    {
        $default_settings = [
            // General.
            'title'                    => '',
            'image'                    => '',
            'image_custom_dimension'   => '',
            'design'                   => 'default',
            'alignment'                => 'center',
            'tabs_items'               => [],

            // Layout.
            'layout'                   => 'grid',
            'pagination'               => '',
            'items_per_page'           => 12,
            'columns'                  => ['size' => 4],

            // Extra.
            'elementor'                => true,
        ];
        $settings = wp_parse_args($settings, $default_settings);
        // Tabs settings.
        // $first_tab_title = '';

        // if (isset($settings['tabs_items'][0]['title'])) {
        //     $first_tab_title = $settings['tabs_items'][0]['title'];
        // }
?>
        <!--start of container-->
        <div class="tab-container tfc-tab-wrap" style="text-align: <?php echo esc_attr($settings['text_align']); ?>">
            <?php if ($settings['title']) : ?>
                <div class="tabs-name title">
                    <h2 class="best-seller tfc-seller-heading"> <?php echo ($settings['title']); ?></h2>
                </div>
            <?php endif; ?>
            <div class="tab-menu">
                <ul class="products-tabs-title">
                    <?php foreach ($settings['tabs_items'] as $key => $item) : ?>
                        <?php
                        $li_classes        = '';
                        $icon_output       = '';
                        $item['elementor'] = true;
                        if (0 === $key) {
                            $li_classes .= ' active-a';
                        }
                        ?>
                        <li>
                            <a href="#" class="tab-a <?php echo esc_attr($li_classes); ?> <?php echo $item['tfc_category_name']; ?>" data-id="tab<?php echo $key; ?>">
                                <?php echo esc_html($item['title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php

            $tabs_cat_content = $settings['tabs_items'];
            foreach ($tabs_cat_content as $key => $data) {
               
                $tab_classes        = '';
                if (0 === $key) {
                    $tab_classes .= ' tab-active';
                }
                if (!empty($data['tfc_category_name'])) {
            ?>
                    <div class="tab <?php echo $tab_classes; ?> <?php echo $data['tfc_category_name']; ?>" data-id="tab<?php echo $key; ?>">
                        <?php
                        coldest_woocommerce_subcats_from_parentcat_by_Slug($data['tfc_category_name']);
                        ?>
                    </div>

            <?php
                }
            }
            if (!empty($settings['website_link']['url'])) :
                $coldest_tab_url =  $settings['website_link']['url'];
                echo '<button class="tfc_button"><a href="' . $coldest_tab_url . '">' . $settings['button_title'] . '</a></button>
        </div>';
            endif;
            ?>

            <!--end of container-->

    <?php
    }

    function coldest_woocommerce_subcats_from_parentcat_by_Slug($parent_cat_NAME)
    {
        $coldest_cat_slugin = get_term_by('slug', $parent_cat_NAME, 'product_cat');
        $product_cat_ID = $coldest_cat_slugin->term_id;
        $args = array(
            'hierarchical' => 1,
            'show_option_none' => '',
            'hide_empty' => 0,
            'parent' => $product_cat_ID,
            'taxonomy' => 'product_cat'
        );
        $coldest_subcats = get_categories($args);
        if (!empty($coldest_subcats)) :
            $img_path = get_stylesheet_directory_uri() . '/elementor/products-tabs/assets/images/best-sellers-banner-backtap_1_410x_crop_center@2x.progressive.jpg';
            $output = '';
            foreach ($coldest_subcats as $data) {
                $output .= '<div class="sub_cat-box">';
                $link = get_term_link($data->slug, $data->taxonomy);
                $output .= '<div class="sub_cat-box-img">';
                $output .=   '<a href="' . $link . '"><img src="' . $img_path . '"></a>';
                $output .= '</div>';
                $output .= '<h2>' . $data->name . '</h2>';
                $output .= '<p>Content of tab one</p>';
                $output .= '<p>Content of tab one</p>';
                // $output .='<li><a href="' . $link . '">' . $data->name . '</a></li>';
                $output .= '</div>';
            }
            echo $output;
        endif;
    }
}



    ?>