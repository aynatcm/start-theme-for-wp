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
        class="grid-gallery animation--<?php echo $animationType ?> active--animation-<?php echo $activeAnimation ?> <?php echo $classCss ?>"
        id="<?php echo $idSection ?>">
    <div class="grid-gallery__wrapper">
        <?php if (!empty($title)): ?>
            <h2 class="title"><?php echo $title ?></h2>
        <?php endif ?>

        <?php if (!empty($description)): ?>
            <p class="description"><?php echo $description ?></p>
        <?php endif ?>

        <?php if (!empty($gallery)): ?>
            <div class="gallery">
                <?php foreach ($gallery as $image): ?>
                    <img src="<?php echo $image['gallery_picture']['url'] ?>"
                         alt="<?php echo $image['gallery_picture']['name'] ?>">
                <?php endforeach ?>
            </div>
        <?php endif ?>

    </div>
</section>