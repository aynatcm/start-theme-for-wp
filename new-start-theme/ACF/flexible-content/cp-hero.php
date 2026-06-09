<?php
$infoSliders = $cp->info_slider;
$first = true;
//Settings animation
$animationType = $cp->type_of_animation;
$activeAnimation = $cp->active_animation;
$classCss = $cp->class_css;
$idSection = $cp->id_section;
?>

<?php if (!empty($infoSliders)): ?>
    <?php
    // Preload de la primera imagen (opcional, mejora LCP si se desea)
    $first_img = $infoSliders[0]['image_slider']['ID'] ?? null;
    if ($first_img) {
        echo '<link rel="preload" as="image" href="' . esc_url(wp_get_attachment_url($first_img)) . '" />';
    }
    ?>
<?php endif; ?>

<section
        class="container--hero-banner animation--<?php echo esc_attr($animationType) ?> active--animation-<?php echo esc_attr($activeAnimation) ?> <?php echo esc_attr($classCss) ?>"
        id="<?php echo esc_attr($idSection) ?>">

    <?php if (!empty($infoSliders)): ?>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($infoSliders as $image): ?>
                    <div class="swiper-slide">
                        <?php if (!empty($image['image_slider'])): ?>
                            <?php
                            $img = $image['image_slider'];
                            $img_args = [
                                'class' => 'slider-image',
                                'alt' => esc_attr($img['alt']),
                                'sizes' => '(max-width: 768px) 100vw, 1920px',
                            ];

                            // Solo la primera imagen sin lazy
                            if ($first) {
                                $img_args['loading'] = 'eager';
                                $first = false;
                            }

                            echo wp_get_attachment_image($img['ID'], 'full', false, $img_args);
                            ?>
                        <?php endif; ?>

                        <div class="container--info-sliders">
                            <div class="container--info">
                                <div class="container--text-cta">
                                    <?php if (!empty($image['hero_title'])): ?>
                                        <h1 class="title--hero">
                                            <?php echo wp_kses_post($image['hero_title']); ?>
                                            <span class="second--title-hero"><?php echo wp_kses_post($image['hero_second_title']); ?></span>
                                        </h1>
                                    <?php endif; ?>

                                    <?php if (!empty($image['hero_subtitle'])): ?>
                                        <h2 class="subtitle-hero"><?php echo wp_kses_post($image['hero_subtitle']); ?></h2>
                                    <?php endif; ?>

                                    <?php if (!empty($image['call_to_action']) || !empty($image['second_cta'])): ?>
                                        <div class="container--cta-hero">
                                            <?php if ($image['call_to_action']): ?>
                                                <a href="<?php echo esc_url($image['call_to_action']['url']); ?>"><?php echo wp_kses_post($image['call_to_action']['title']); ?></a>
                                            <?php endif; ?>
                                            <?php if ($image['second_cta']): ?>
                                                <a href="<?php echo esc_url($image['second_cta']['url']); ?>"
                                                   aria-label="<?php echo esc_attr($image['second_cta']['title']) ?>-link"><?php echo wp_kses_post($image['second_cta']['title']); ?></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="container--arrow-navigation">
                <div class="container--arrows">
                    <div class="swiper-button-next">
                        <svg width="12" height="55" viewBox="0 0 12 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.53033 0.46967C6.23744 0.176777 5.76256 0.176777 5.46967 0.46967L0.696699 5.24264C0.403806 5.53553 0.403806 6.01041 0.696699 6.3033C0.989592 6.59619 1.46447 6.59619 1.75736 6.3033L6 2.06066L10.2426 6.3033C10.5355 6.59619 11.0104 6.59619 11.3033 6.3033C11.5962 6.01041 11.5962 5.53553 11.3033 5.24264L6.53033 0.46967ZM5.25 41C5.25 41.4142 5.58578 41.75 6 41.75C6.41421 41.75 6.75 41.4142 6.75 41L5.25 41ZM5.25 1L5.25 41L6.75 41L6.75 1L5.25 1Z"
                                  fill="white"/>
                        </svg>
                    </div>
                    <div class="swiper-button-prev">
                        <svg width="12" height="55" viewBox="0 0 12 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.75 1C6.75 0.585786 6.41421 0.25 6 0.25C5.58579 0.25 5.25 0.585786 5.25 1L6.75 1ZM5.46967 41.5303C5.76256 41.8232 6.23744 41.8232 6.53033 41.5303L11.3033 36.7574C11.5962 36.4645 11.5962 35.9896 11.3033 35.6967C11.0104 35.4038 10.5355 35.4038 10.2426 35.6967L6 39.9393L1.75736 35.6967C1.46446 35.4038 0.989591 35.4038 0.696698 35.6967C0.403804 35.9896 0.403804 36.4645 0.696698 36.7574L5.46967 41.5303ZM5.25 1L5.25 41L6.75 41L6.75 1L5.25 1Z"
                                  fill="white"/>
                        </svg>
                    </div>
                </div>

                <span class="text--scroll">Scroll</span>
            </div>

            <div class="swiper-pagination"></div>
        </div>
    <?php endif ?>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            effect: "fade",
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                type: "progressbar",
            },
        });
    })
</script>
