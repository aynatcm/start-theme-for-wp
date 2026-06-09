<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * NewStart_Theme
 */
$footerLogo = get_field('footer_logo', 'option');
$socialLinks = get_field('social_links', 'option');
$quickLinksWidgetOne = get_field('quick_links_widget_one', 'option');
$quickLinksWidgetTwo = get_field('quick_links_widget_two', 'option');
$titleNewsletter = get_field('title_newsletter', 'option');
$ctaNewsletter = get_field('cta_newsletter', 'option');
$shortcodeNewsletter = get_field('shortcode_form', 'option');

?>

<footer class="container--footer-website">
    <div class="container--wrapper">
        <div class="site--logo site-footer">
            <?php if(!empty($footerLogo)):?>
                <a href="<?php echo esc_url(home_url()) ?>">
                    <img src="<?php echo esc_url($footerLogo) ?>" alt="Logo footer">
                </a>
            <?php endif?>

            <?php if(!empty($socialLinks)):?>
                <div class="container--social-links">
                    <ul>
                        <?php foreach ($socialLinks as $links): ?>
                            <li>
                                <a href="<?php echo esc_url($links['link_social_media']) ?>" target="_blank">
                                    <img src="<?php echo esc_url($links['icon_image']) ?>" alt="icon image">
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif?>
        </div>

        <?php if(!empty($quickLinksWidgetOne) || !empty($quickLinksWidgetTwo)):?>
            <div class="site--navigation site-footer">
                <?php if(!empty($quickLinksWidgetOne)):?>
                    <ul class="container--quicklinks-one">
                        <?php foreach ($quickLinksWidgetOne as $linkOne): ?>
                            <li>
                                <a href="<?php echo esc_url($linkOne['cta_widget_one']['url']) ?>"><?php echo wp_kses_post($linkOne['cta_widget_one']['title']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif?>

                <?php if(!empty($quickLinksWidgetTwo)):?>
                    <ul class="container--quicklinks-two">
                        <?php foreach ($quickLinksWidgetTwo as $linkTwo): ?>
                            <li>
                                <a href="<?php echo esc_url($linkTwo['cta_widget_two']['url']) ?>"><?php echo wp_kses_post($linkTwo['cta_widget_two']['title']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif?>
            </div>
        <?php endif?>

        <?php if(!empty($titleNewsletter) || !empty($ctaNewsletter) || !empty($shortcodeNewsletter)):?>
            <div class="container--newsletter-footer">
                <?php if(!empty($titleNewsletter)):?>
                    <span class="title--newsletter"><?php echo wp_kses_post($titleNewsletter) ?></span>
                <?php endif?>

                <?php if(!empty($ctaNewsletter)):?>
                    <span class="cta--newsletter"><?php echo wp_kses_post($ctaNewsletter) ?></span>
                <?php endif?>

                <?php if(!empty($shortcodeNewsletter)):?>
                    <div class="container--form-newsletter">
                        <?php echo wp_kses_post(do_shortcode($shortcodeNewsletter)) ?>
                    </div>
                <?php endif?>
            </div>
        <?php endif?>

    </div>
</footer>

<?php wp_footer(); ?>
<script>window.$zoho = window.$zoho || {};
    $zoho.salesiq = $zoho.salesiq || {
        ready: function () {
        }
    }</script>
<script id="zsiqscript"
        src="https://salesiq.zohopublic.com/widget?wc=siq2c1962ea1d95f48849963eb952423ec2464ad96060ef10d5d49bf7a4c8c6275c9e6eaa91d3481dd80257c20e940b4321"
        defer></script>

</body>
</html>
