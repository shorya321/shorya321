<?php
if (!defined('ABSPATH')) {
    exit; // Direct access not allowed.
}
if (!function_exists('coldest_elementor_products_carousel_template')) {

    function coldest_elementor_products_carousel_template($settings)
    {
        $paged                    = get_query_var('paged') ? get_query_var('paged') : 1;
        $query_args = [
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'paged'               => $paged,
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'posts_per_page'      => $settings['items_per_page'],
            'meta_query'          => WC()->query->get_meta_query(),
            'tax_query'           => WC()->query->get_tax_query(),
        ];


        if ($settings['taxonomies']) {


            $tfc_taxonomy = $settings['taxonomies'];

            // Category Id's get
            $results = array();
            if (is_array($tfc_taxonomy) && $tfc_taxonomy) {
                foreach ($tfc_taxonomy as $term) {
                    $category = get_term_by('slug', $term, 'product_cat');
                    if (is_object($category)) {
                        $results[] = $category->term_id;
                    }
                }
            }

            $taxonomy_names = get_object_taxonomies('product');
            $terms          = get_terms(
                $taxonomy_names,
                [
                    'orderby'    => 'name',
                    'include'    => $results,
                    'hide_empty' => false,
                ]
            );

            if (!is_wp_error($terms) && !empty($terms)) {
                if ('featured' === $settings['post_type']) {
                    $query_args['tax_query'] = ['relation' => 'AND'];
                }

                $relation = $settings['query_type'] ? $settings['query_type'] : 'OR';

                if (count($terms) > 1) {

                    $query_args['tax_query']['categories'] = ['relation' => $relation];
                }
                foreach ($terms as $term) {
                    $query_args['tax_query']['categories'][] = [
                        'taxonomy'         => $term->taxonomy,
                        'field'            => 'slug',
                        'terms'            => [$term->slug],
                        'include_children' => true,
                        'operator'         => 'IN',
                    ];
                }
            }
        }
        if ('featured' === $settings['post_type']) {
            $query_args['tax_query'][] = [
                'taxonomy'         => 'product_visibility',
                'field'            => 'name',
                'terms'            => 'featured',
                'operator'         => 'IN',
                'include_children' => false,
            ];
        }


        if ($settings['order']) {
            $query_args['order'] = $settings['order'];
        }
        if ('sale' === $settings['post_type']) {
            $query_args['post__in'] = array_merge([0], wc_get_product_ids_on_sale());
        }
        if ('bestselling' === $settings['post_type']) {
            $query_args['orderby']  = 'meta_value_num';
            $query_args['meta_key'] = 'total_sales';
            $query_args['order']    = 'DESC';
        }
        $tfcwrapper_id = '';
        $tfcwrapper_classes = '';
        if ('grid' === $settings['layout']) {
            $tfcwrapper_classes .= ' element-grid';
        } else {
            $tfcwrapper_id .= 'news-slider';
            $tfcwrapper_classes .= 'owl-carousel';
        }

        $products = new WP_Query($query_args);
        if (!$products->have_posts()) {
            return;
        } ?>
        <div style="text-align: <?php echo esc_attr($settings['text_align']); ?>">
            <?php if ($settings['title']) : ?>
                <div class="tfc-heading">
                    <h2> <?php echo ($settings['title']); ?></h2>
                </div>
            <?php endif; ?>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="<?php echo esc_attr($tfcwrapper_id); ?>" class="products <?php echo esc_attr($tfcwrapper_classes); ?>">
                        <?php
                        //  global $product;
                        while ($products->have_posts()) :
                            $products->the_post();
                            $id = get_the_ID();
                            $product = wc_get_product($id);
                            if ($product->product_type == "variable" && $product->is_in_stock()) {
                                $prduct_variation = $product->get_available_variations();
                                foreach ($prduct_variation as $data) {
                                    $variation = wc_get_product($data['variation_id']);
                                    if ($variation->is_in_stock()) {
                                        $tfc_pa_size_name = $data['attributes']['attribute_' . 'pa_size'];
                                        set_query_var('fc_prod_variation_id', $data);
                                        set_query_var('tfcpasizename', $tfc_pa_size_name);
                                        wc_get_template_part('content', 'carouselproduct');
                                    }
                                }
                            }

                        endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        ?>
        <!--start of container-->
        <div class="container">
        </div>
        <!--end of container-->
<?php
    }
}
?>