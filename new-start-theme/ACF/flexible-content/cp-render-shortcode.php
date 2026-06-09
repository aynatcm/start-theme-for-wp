<?php
$renderShortcode = $cp->render_shortcode;
?>

<?php if(!empty($renderShortcode)):?>
    <div>
        <?php echo wp_kses_post(do_shortcode($renderShortcode)) ?>
    </div>
<?php endif?>
