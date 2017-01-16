<?php 
/*
Template Name: Content Page
*/
get_header(); ?>

<div class="container">
    <div class="twelve columns">
        <h1 class="title"><?php the_title(); ?></h1>
<?php
global $wp_query;
$args = array(
    'page'      => '',
    'map'       => 'cambodia',
    'post_type' => 'map',
    'name'      => 'cambodia'
);
$wq_query = new WP_Query($args);
?>

        <?php get_template_part('stage', 'map'); ?>
    </div>
</div>

<section id="content">
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $query = array(
        'paged' => $paged,
        's' => isset($_GET['s']) ? $_GET['s'] : null
    );
    $query = query_posts($query);
    if(have_posts()) : ?>

        <section id="last-stories" class="loop-section">
            <div class="section-title">
                <div class="container">
                    <div class="twelve columns">
                        <h3><?php _e('Stories on', 'ekuatorial'); ?> &ldquo;<?php the_title(); ?>&ldquo;</h3>
                        <div class="query-actions">
                            <?php
                            global $wp_query;
                            $args = $wp_query->query;
                            $args = array_merge($args, $_GET);
                            $geojson = jeo_get_api_url($args);
                            $download = jeo_get_api_download_url($args);
                            $rss = add_query_arg(array('feed' => 'rss'));
                            ?>
                            <a class="rss" href="<?php echo $rss; ?>"><?php _e('RSS Feed', 'ekuatorial'); ?></a>
                            <a class="geojson" href="<?php echo $geojson; ?>"><?php _e('Get GeoJSON', 'ekuatorial'); ?></a>
                            <a class="download" href="<?php echo $download; ?>"><?php _e('Download', 'ekuatorial'); ?></a>
                        </div>
                        <div id="stage">
                            <ul class="share">
                                <li class="facebook">
                                    <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana" data-action="recommend"></div>
                                </li>
                                <li class="twitter">
                                    <a href="https://twitter.com/share" class="twitter-share-button" data-via="ekuatorial" data-lang="<?php if(function_exists('qtranxf_getLanguage')) echo qtranxf_getLanguage(); ?>">Tweet</a>
                                </li>
                                <li class="share">
                                    <a class="button share-button" href="<?php echo jeo_get_share_url(array('map_id' => $post->ID)); ?>"><?php _e('Embed this map', 'ekuatorial'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <?php get_template_part('loop'); ?>
            </div>
        </section>
    <?php
    endif;
        echo paginate_links( array(
            'base' => '%_%',
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $query->max_num_pages
    ) );
    wp_reset_query(); ?>

    <?php get_template_part('section', 'submit-call'); ?>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>
