<?php
$title = $cp->grid_gallery_title;
$description = $cp->grid_gallery_description;
$gallery = $cp->grid_gallery;

//Settings animation
$animationType = $cp->type_of_animation;
$activeAnimation = $cp->active_animation;
$classCss = $cp->class_css;
$idSection = $cp->id_section;
?>


<section
        class="grid-gallery animation--<?php echo esc_attr($animationType) ?> active--animation-<?php echo esc_attr($activeAnimation) ?> <?php echo esc_attr($classCss) ?>"
        id="<?php echo esc_attr($idSection) ?>">
    <div class="grid-gallery__wrapper">
        <?php if (!empty($title)): ?>
            <h2 class="title"><?php echo wp_kses_post($title) ?></h2>
        <?php endif ?>

        <?php if (!empty($description)): ?>
            <p class="description"><?php echo wp_kses_post($description) ?></p>
        <?php endif ?>

        <?php if (!empty($gallery)): ?>
            <div class="gallery">
                <?php foreach ($gallery as $image): ?>
                    <img src="<?php echo esc_url($image['gallery_picture']['url']) ?>"
                         alt="<?php echo esc_attr($image['gallery_picture']['name']) ?>">
                <?php endforeach ?>
            </div>
        <?php endif ?>

    </div>
</section>