<?php
$socialLinks = get_field('social_links', 'option');
?>
<div id="page" class="site">
    <header class="contentHeader">

        <div class="container--top-bar">
            <div class="container--wrapper">
                <div class="container--socials-info">
                    <div class="item-info">
                        <a href="mailto:info@realiancerealtynic.com">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.2083 3.54166H4.79163C3.41091 3.54166 2.29163 4.66094 2.29163 6.04166V13.9583C2.29163 15.339 3.41091 16.4583 4.79163 16.4583H15.2083C16.589 16.4583 17.7083 15.339 17.7083 13.9583V6.04166C17.7083 4.66094 16.589 3.54166 15.2083 3.54166Z"
                                      stroke="white" stroke-width="1.25" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                <path d="M2.29163 6.66666L9.30413 9.88832C9.52239 9.98861 9.75976 10.0405 9.99996 10.0405C10.2402 10.0405 10.4775 9.98861 10.6958 9.88832L17.7083 6.66666"
                                      stroke="white" stroke-width="1.25" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </svg>
                            info@realiancerealtynic.com
                        </a>
                    </div>
                    <div class="item-info">
                        <a href="tel:8429-6462">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="inherit"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6666 2.26666C11.0557 1.65118 10.3285 1.1633 9.52739 0.831391C8.72624 0.499487 7.86709 0.330183 6.99992 0.333325C5.84063 0.334457 4.70198 0.640155 3.69801 1.21981C2.69404 1.79946 1.85998 2.63271 1.27937 3.63613C0.698755 4.63954 0.391964 5.7779 0.389721 6.93718C0.387477 8.09647 0.68986 9.236 1.26659 10.2417L0.333252 13.6667L3.83325 12.75C4.79931 13.2887 5.88552 13.5753 6.99158 13.5833C8.74963 13.5834 10.4365 12.889 11.6851 11.6514C12.9337 10.4137 13.6429 8.73297 13.6583 6.97499C13.6524 6.09775 13.4734 5.23028 13.1317 4.42233C12.7899 3.61438 12.292 2.88182 11.6666 2.26666ZM6.99992 12.4417C6.01477 12.4415 5.04775 12.1767 4.19992 11.675L3.99992 11.55L1.92492 12.1L2.47492 10.075L2.34159 9.86666C1.63263 8.72221 1.36804 7.35749 1.59794 6.03102C1.82784 4.70455 2.53626 3.50846 3.589 2.66935C4.64175 1.83023 5.96569 1.40637 7.31003 1.47806C8.65436 1.54975 9.92572 2.11201 10.8833 3.05833C11.9299 4.08182 12.5291 5.47789 12.5499 6.94166C12.5367 8.40493 11.9462 9.80378 10.9068 10.8338C9.86739 11.8639 8.46325 12.4417 6.99992 12.4417ZM10.0083 8.32499C9.84159 8.24166 9.03325 7.84166 8.88325 7.79166C8.73325 7.74166 8.61659 7.70833 8.50825 7.87499C8.34522 8.0984 8.16995 8.31261 7.98325 8.51666C7.89159 8.63332 7.79158 8.64166 7.62492 8.51666C6.6747 8.14114 5.88299 7.4495 5.38325 6.55833C5.20825 6.26666 5.54992 6.28333 5.86659 5.65833C5.88996 5.61327 5.90216 5.56325 5.90216 5.51249C5.90216 5.46173 5.88996 5.41172 5.86659 5.36666C5.86659 5.28333 5.49158 4.46666 5.35825 4.14166C5.22492 3.81666 5.09159 3.86666 4.98325 3.85833H4.65825C4.57395 3.85907 4.49082 3.87809 4.41457 3.91405C4.33832 3.95002 4.27078 4.00208 4.21659 4.06666C4.03004 4.2488 3.88449 4.46863 3.78965 4.71149C3.6948 4.95434 3.65285 5.21464 3.66659 5.47499C3.71786 6.09862 3.95274 6.69308 4.34159 7.18333C5.05204 8.24621 6.02519 9.1074 7.16658 9.68333C7.76531 10.0329 8.46115 10.179 9.14992 10.1C9.37927 10.0545 9.59648 9.96121 9.78743 9.82625C9.97838 9.69129 10.1388 9.51767 10.2583 9.31666C10.3699 9.07164 10.4048 8.79854 10.3583 8.53333C10.2833 8.44999 10.1749 8.40833 10.0083 8.32499Z"
                                      fill="currentColor"/>
                            </svg>
                            +505 8429-6462
                        </a>
                    </div>

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
                </div>
            </div>
        </div>

        <hr class="divider">

        <div class="contentHeader__wrapper">
            <div class="contentLogo">
                <?php
                $site_name = get_bloginfo('name');
                $site_logo = get_theme_mod('custom_logo'); // Obtain the current theme logo
                if ($site_logo && is_front_page()) { ?>
                    <a href="<?php echo home_url() ?>">
                        <img src="<?php echo esc_url(wp_get_attachment_image_src($site_logo, 'full')[0]); ?>"
                             alt="<?php echo esc_attr($site_name); ?>" class="logo__img">
                    </a>

                <?php } elseif (!is_front_page() && $site_logo) { ?>
                    <a href="<?php echo esc_url(home_url()) ?>">
                        <img src="<?php echo esc_url(wp_get_attachment_image_src($site_logo, 'full')[0]); ?>"
                             alt="<?php echo esc_attr($site_name); ?>" class="logo__img">
                    </a>
                <?php } else { ?>
                    <span><?php echo esc_html($site_name); ?></span>
                <?php } ?>

            </div>

            <nav class="navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        // 'menu_id' => 'primary-menu',
                    )
                );
                ?>
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
            </nav>

            <span class="btn-open btn">
                <?php if (is_front_page()): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="25px" width="25px"><path
                                d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"
                                fill="#fff"/>
                    </svg>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="25px" width="25px"><path
                                d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"
                                fill="#000"/>
                    </svg>
                <?php endif ?>
            </span>
            <span class="btn-close btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="25px" width="25px">
                    <path
                            d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"
                            fill="#000"/></svg>
            </span>
        </div>
    </header>

