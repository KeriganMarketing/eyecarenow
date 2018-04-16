<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package EyeCareNow
 */

$newsenabled    = get_field('show_news_feed');
$newscat        = get_field('news_category');
$sidebarbuttons = get_field('sidebar_buttons');
$slider         = get_field('header_slideshow');
$header_photo   = get_field('header_photo');

get_header(); ?>
<div id="primary" class="support-area">
    <div id="mid">
        <div class="container">
            <?php if ($slider) { ?>
                <div id="featured-image" class="support">
                    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/inc/flexslider/flexslidermin.css" type="text/css">
                    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
                    <script src="<?php echo get_template_directory_uri() ?>/inc/flexslider/jquery.flexslider-min.js"></script>
                    <div class="flexslider">
                        <ul class="slides">
                            <?php
                            $p = 1;
                            foreach ($slider[0] as $ph) {
                                echo '<li>';
                                echo '<img src="' . $ph['imageURL'] . '" alt="' . $ph['alttext'] . '" />';
                                echo '</li>';
                                $p++;
                            }
                            ?>
                        </ul>
                    </div>

                    <script type="text/javascript" charset="utf-8">
                        $(window).load(function () {
                            $('.flexslider').flexslider({
                                controlNav: true,                //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                                directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
                                prevText: "<",           		 //String: Set the text for the "previous" directionNav item
                                nextText: ">"               	 //String: Set the text for the "next" directionNav item
                            });
                        });
                    </script>

                </div>
            <?php }
            if ($header_photo) { ?>
                <div id="featured-image" class="support">
                    <img src="<?php echo $header_photo['url']; ?>" alt="<?php echo $header_photo['alt']; ?>"/>
                </div>
            <?php } ?>

            <div id="content-left" class="col res-34 tab-23 wide-1 ph-1">

                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                        <?php if (have_posts()) : ?>

                            <?php while (have_posts()) : the_post(); ?>

                                <?php get_template_part('content', get_post_format()); ?>

                            <?php endwhile; ?>

                            <?php the_posts_navigation(); ?>

                        <?php else : ?>

                            <?php get_template_part('content', 'none'); ?>

                        <?php endif; ?>

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
