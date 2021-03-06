<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package EyeCareNow
 */
$newsenabled    = get_field('show_news_feed');
$newscat        = get_field('news_category');
$sidebarbuttons = get_field('sidebar_buttons');
$header_photo   = get_field('header_photo');

get_header(); ?>
<div id="primary" class="support-area">
    <div id="mid">
        <div class="container">

            <?php if ($header_photo) { ?>
                <div id="featured-image" class="support">
                    <img src="<?php echo $header_photo['url']; ?>" alt="<?php echo $header_photo['alt']; ?>"/>
                </div>
            <?php } ?>

            <div id="content-left" class="col res-34 tab-23 wide-1 ph-1">

                <div class="content-area">
                    <main id="main" class="site-main" role="main">

                        <?php if (function_exists('yoast_breadcrumb')) {
                            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                        } ?>

                        <?php while (have_posts()) : the_post(); ?>

                            <?php get_template_part('content', 'page'); ?>

                            <?php
                            // If comments are open or we have at least one comment, load up the comment template
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                            ?>

                            <div id="services">
                                <?php

                                $sargs = [
                                    'sort_order'   => 'ASC',
                                    'sort_column'  => 'menu_order',
                                    'hierarchical' => 0,
                                    'parent'       => $post->ID,
                                    'offset'       => 0,
                                    'post_type'    => 'page',
                                    'post_status'  => 'publish',
                                ];

                                $mypages = get_pages($sargs);

                                foreach ($mypages as $page) {
                                    $content = $page->post_content;
                                    if ( ! $content) // Check for empty page
                                    {
                                        continue;
                                    }

                                    $content = apply_filters('the_content', $content);

                                    echo '<h2>' . $page->post_title . '</h2>
					<div class="entry"><p>' . substr(strip_tags($content), 0,
                                            200) . '...</p><p class="more"><a href="' . get_page_link($page->ID) . '" class="more">MORE</a></p>';

                                    $sargs2 = [
                                        'sort_order'   => 'ASC',
                                        'sort_column'  => 'menu_order',
                                        'hierarchical' => 0,
                                        'parent'       => $page->ID,
                                        'offset'       => 0,
                                        'post_type'    => 'page',
                                        'post_status'  => 'publish',
                                    ];

                                    $mypages2 = get_pages($sargs2);

                                    foreach ($mypages2 as $page) {
                                        $content = $page->post_content;
                                        if ( ! $content) // Check for empty page
                                        {
                                            continue;
                                        }

                                        $content = apply_filters('the_content', $content);

                                        echo '<h3>' . $page->post_title . '</h2>' .
                                             '<p>' . substr(strip_tags($content), 0,
                                                200) . '...</p><p class="more"><a href="' . get_page_link($page->ID) . '" class="more">MORE</a></p>';

                                    };

                                    echo '</div>';

                                };
                                ?>
                            </div>

                        <?php endwhile; // end of the loop. ?>

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
            <div id="content-right" class="col res-14 tab-13 wide-1 ph-1">
                <?php include('sidebar.php'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
