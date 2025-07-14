<?php
$renderShortcode = $cp->render_shortcode;
?>

<?php if(!empty($renderShortcode)):?>
    <div>
        <?php echo do_shortcode($renderShortcode) ?>
    </div>
<?php endif?>
