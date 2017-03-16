<?php

if ( !defined ( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists ( 'reduxSocialProfilesDefaults' ) ) {

    class reduxSocialProfilesDefaults {

        public static function get_social_media_defaults () {
            $defaults = array(
                0 => array(
                    'id'    => 'adn',
                    'icon' => 'fa-adn',
                    'enabled' => false,
                    'name' => __ ( 'ADN', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 0,
                ),
                1 => array( 
                    'id'    => 'android',
                    'icon' => 'fa-android',
                    'enabled' => false,
                    'name' => __ ( 'Android', 'hatch' ),
                    'background' => '',
                    'color' => '#A4C639',
                    'url' => '',
                    'order' => 1,
                ),
                2 => array(
                    'id'    => 'apple',
                    'icon' => 'fa-apple',
                    'enabled' => false,
                    'name' => __ ( 'Apple', 'hatch' ),
                    'style' => '',
                    'background' => '',
                    'color' => '#e4e4e5',
                    'url' => '',
                    'order' => 2,
                ),
                3 => array( 
                    'id'    => 'behance',
                    'icon' => 'fa-behance',
                    'enabled' => false,
                    'name' => __ ( 'behance', 'hatch' ),
                    'background' => '',
                    'color' => '#1769ff',
                    'url' => '',
                    'order' => 3,
                ),
                4 => array( 
                    'id'    => 'behance-square',
                    'icon' => 'fa-behance-square',
                    'enabled' => false,
                    'name' => __ ( 'behance square', 'hatch' ),
                    'background' => '',
                    'color' => '#1769ff',
                    'url' => '',
                    'order' => 4,
                ),
                5 => array( 
                    'id'    => 'bitbucket',
                    'icon' => 'fa-bitbucket',
                    'enabled' => false,
                    'name' => __ ( 'Bitbucket', 'hatch' ),
                    'background' => '',
                    'color' => '#205081',
                    'url' => '',
                    'order' => 5,
                ),
                6 => array( 
                    'id'    => 'bitbucket-square',
                    'icon' => 'fa-bitbucket-square',
                    'enabled' => false,
                    'name' => __ ( 'Bitbucket square', 'hatch' ),
                    'background' => '',
                    'color' => '#205081',
                    'url' => '',
                    'order' => 6,
                ),
                7 => array( 
                    'id'    => 'bitcoin',
                    'icon' => 'fa-btc',
                    'enabled' => false,
                    'name' => __ ( 'Bitcoin', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 7,
                ),
                8 => array( 
                    'id'    => 'codepen',
                    'icon' => 'fa-codepen',
                    'enabled' => false,
                    'name' => __ ( 'CodePen', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 8,
                ),
                9 => array( 
                    'id'    => 'css3',
                    'icon' => 'fa-css3',
                    'enabled' => false,
                    'name' => __ ( 'CSS3', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 9,
                ),
                10 => array( 
                    'id'    => 'delicious',
                    'icon' => 'fa-delicious',
                    'enabled' => false,
                    'name' => __ ( 'Delicious', 'hatch' ),
                    'background' => '',
                    'color' => '#3399ff',
                    'url' => '',
                    'order' => 10,
                ),
                11 => array( 
                    'id'    => 'deviantart',
                    'icon' => 'fa-deviantart',
                    'enabled' => false,
                    'name' => __ ( 'Deviantart', 'hatch' ),
                    'background' => '',
                    'color' => '#4e6252',
                    'url' => '',
                    'order' => 11,
                ),
                12 => array( 
                    'id'    => 'digg',
                    'icon' => 'fa-digg',
                    'enabled' => false,
                    'name' => __ ( 'Digg', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 12,
                ),
                13 => array( 
                    'id'    => 'dribbble',
                    'icon' => 'fa-dribbble',
                    'enabled' => false,
                    'name' => __ ( 'Dribbble', 'hatch' ),
                    'background' => '',
                    'color' => '#444444',
                    'url' => '',
                    'order' => 13,
                ),
                14 => array( 
                    'id'    => 'dropbox',
                    'icon' => 'fa-dropbox',
                    'enabled' => false,
                    'name' => __ ( 'Dropbox', 'hatch' ),
                    'background' => '',
                    'color' => '#007ee5',
                    'url' => '',
                    'order' => 14,
                ),
                15 => array( 
                    'id'    => 'drupal',
                    'icon' => 'fa-drupal',
                    'enabled' => false,
                    'name' => __ ( 'Drupal', 'hatch' ),
                    'background' => '',
                    'color' => '#0077c0',
                    'url' => '',
                    'order' => 15,
                ),
                16 => array( 
                    'id'    => 'empire',
                    'icon' => 'fa-empire',
                    'enabled' => false,
                    'name' => __ ( 'Empire', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 16,
                ),
                17 => array( 
                    'id'    => 'facebook',
                    'icon' => 'fa-facebook',
                    'enabled' => false,
                    'name' => __ ( 'Facebook', 'hatch' ),
                    'background' => '',
                    'color' => '#3b5998',
                    'url' => '',
                    'order' => 17,
                ),
                18 => array( 
                    'id'    => 'facebook-square',
                    'icon' => 'fa-facebook-square',
                    'enabled' => false,
                    'name' => __ ( 'Facebook square', 'hatch' ),
                    'background' => '',
                    'color' => '#3b5998',
                    'url' => '',
                    'order' => 18,
                ),
                19 => array( 
                    'id'    => 'flickr',
                    'icon' => 'fa-flickr',
                    'enabled' => false,
                    'name' => __ ( 'Flickr', 'hatch' ),
                    'background' => '',
                    'color' => '#0063dc',
                    'url' => '',
                    'order' => 19,
                ),
                20 => array( 
                    'id'    => 'foursquare',
                    'icon' => 'fa-foursquare',
                    'enabled' => false,
                    'name' => __ ( 'FourSquare', 'hatch' ),
                    'background' => '',
                    'color' => '#0072b1',
                    'url' => '',
                    'order' => 20,
                ),
                21 => array( 
                    'id'    => 'git',
                    'icon' => 'fa-git',
                    'enabled' => false,
                    'name' => __ ( 'git', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 21,
                ),
                22 => array( 
                    'id'    => 'git-square',
                    'icon' => 'fa-git-square',
                    'enabled' => false,
                    'name' => __ ( 'git square', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 22,
                ),
                23 => array( 
                    'id'    => 'github',
                    'icon' => 'fa-github',
                    'enabled' => false,
                    'name' => __ ( 'github', 'hatch' ),
                    'background' => '',
                    'color' => '#4183c4',
                    'url' => '',
                    'order' => 23,
                ),
                24 => array( 
                    'id'    => 'github-alt',
                    'icon' => 'fa-github-alt',
                    'enabled' => false,
                    'name' => __ ( 'github alt', 'hatch' ),
                    'background' => '',
                    'color' => '#4183c4',
                    'url' => '',
                    'order' => 24,
                ),
                25 => array( 
                    'id'    => 'github-square',
                    'icon' => 'fa-github-square',
                    'enabled' => false,
                    'name' => __ ( 'github square', 'hatch' ),
                    'background' => '',
                    'color' => '#4183c4',
                    'url' => '',
                    'order' => 25,
                ),
                26 => array( 
                    'id'    => 'gittip',
                    'icon' => 'fa-gittip',
                    'enabled' => false,
                    'name' => __ ( 'git tip', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 26,
                ),
                27 => array( 
                    'id'    => 'google',
                    'icon' => 'fa-google',
                    'enabled' => false,
                    'name' => __ ( 'Google', 'hatch' ),
                    'background' => '',
                    'color' => '#dd4b39',
                    'url' => '',
                    'order' => 27,
                ),
                28 => array( 
                    'id'    => 'google-plus',
                    'icon' => 'fa-google-plus',
                    'enabled' => false,
                    'name' => __ ( 'Google Plus', 'hatch' ),
                    'background' => '',
                    'color' => '#dd4b39',
                    'url' => '',
                    'order' => 28,
                ),
                29 => array( 
                    'id'    => 'google-plus-square',
                    'icon' => 'fa-google-plus-square',
                    'enabled' => false,
                    'name' => __ ( 'Google Plus square', 'hatch' ),
                    'background' => '',
                    'color' => '#dd4b39',
                    'url' => '',
                    'order' => 29,
                ),
                30 => array( 
                    'id'    => 'hacker-news',
                    'icon' => 'fa-hacker-news',
                    'enabled' => false,
                    'name' => __ ( 'Hacker News', 'hatch' ),
                    'background' => '',
                    'color' => '#ff6600',
                    'url' => '',
                    'order' => 30,
                ),
                31 => array( 
                    'id'    => 'html5',
                    'icon' => 'fa-html5',
                    'enabled' => false,
                    'name' => __ ( 'HTML5', 'hatch' ),
                    'background' => '',
                    'color' => '#e34f26',
                    'url' => '',
                    'order' => 31,
                ),
                32 => array( 
                    'id'    => 'instagram',
                    'icon' => 'fa-instagram',
                    'enabled' => false,
                    'name' => __ ( 'Instagram', 'hatch' ),
                    'background' => '',
                    'color' => '#3f729b',
                    'url' => '',
                    'order' => 32,
                ),
                33 => array( 
                    'id'    => 'joomla',
                    'icon' => 'fa-joomla',
                    'enabled' => false,
                    'name' => __ ( 'Joomla', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 33,
                ),
                34 => array( 
                    'id'    => 'jsfiddle',
                    'icon' => 'fa-jsfiddle',
                    'enabled' => false,
                    'name' => __ ( 'JS Fiddle', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 34,
                ),
                35 => array( 
                    'id'    => 'linkedin',
                    'icon' => 'fa-linkedin',
                    'enabled' => false,
                    'name' => __ ( 'LinkedIn', 'hatch' ),
                    'background' => '',
                    'color' => '#0976b4',
                    'url' => '',
                    'order' => 35,
                ),
                36 => array( 
                    'id'    => 'linkedin-square',
                    'icon' => 'fa-linkedin-square',
                    'enabled' => false,
                    'name' => __ ( 'LinkedIn square', 'hatch' ),
                    'background' => '',
                    'color' => '#0976b4',
                    'url' => '',
                    'order' => 36,
                ),
                37 => array( 
                    'id'    => 'linux',
                    'icon' => 'fa-linux',
                    'enabled' => false,
                    'name' => __ ( 'Linux', 'hatch' ),
                    'background' => '',
                    'color' => '#333333',
                    'url' => '',
                    'order' => 37,
                ),
                38 => array( 
                    'id'    => 'maxcdn',
                    'icon' => 'fa-maxcdn',
                    'enabled' => false,
                    'name' => __ ( 'MaxCDN', 'hatch' ),
                    'background' => '',
                    'color' => '#f8711e',
                    'url' => '',
                    'order' => 38,
                ),
                39 => array( 
                    'id'    => 'pagelines',
                    'icon' => 'fa-pagelines',
                    'enabled' => false,
                    'name' => __ ( 'Page Lines', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 39,
                ),
                40 => array( 
                    'id'    => 'pied-piper',
                    'icon' => 'fa-pied-piper',
                    'enabled' => false,
                    'name' => __ ( 'Pied Piper', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 40,
                ),
                41 => array( 
                    'id'    => 'pied-piper-alt',
                    'icon' => 'fa-pied-piper-alt',
                    'enabled' => false,
                    'name' => __ ( 'Pied Piper alt', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 41,
                ),
                42 => array( 
                    'id'    => 'pinterest',
                    'icon' => 'fa-pinterest',
                    'enabled' => false,
                    'name' => __ ( 'Pinterest', 'hatch' ),
                    'background' => '',
                    'color' => '#1769ff',
                    'url' => '',
                    'order' => 42,
                ),
                43 => array( 
                    'id'    => 'pinterest-square',
                    'icon' => 'fa-pinterest-square',
                    'enabled' => false,
                    'name' => __ ( 'Pinterest square', 'hatch' ),
                    'background' => '',
                    'color' => '#1769ff',
                    'url' => '',
                    'order' => 43,
                ),
                44 => array( 
                    'id'    => 'qq',
                    'icon' => 'fa-qq',
                    'enabled' => false,
                    'name' => __ ( 'QQ', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 44,
                ),
                45 => array( 
                    'id'    => 'rebel',
                    'icon' => 'fa-rebel',
                    'enabled' => false,
                    'name' => __ ( 'Rebel', 'hatch' ),
                    'background' => '',
                    'color' => '#517fa4',
                    'url' => '',
                    'order' => 45,
                ),
                46 => array( 
                    'id'    => 'reddit',
                    'icon' => 'fa-reddit',
                    'enabled' => false,
                    'name' => __ ( 'Reddit', 'hatch' ),
                    'background' => '',
                    'color' => '#ff4500',
                    'url' => '',
                    'order' => 46,
                ),
                47 => array( 
                    'id'    => 'reddit-square',
                    'icon' => 'fa-reddit-square',
                    'enabled' => false,
                    'name' => __ ( 'Reddit square', 'hatch' ),
                    'background' => '',
                    'color' => '#ff4500',
                    'url' => '',
                    'order' => 47,
                ),
                48 => array( 
                    'id'    => 'renren',
                    'icon' => 'fa-renren',
                    'enabled' => false,
                    'name' => __ ( 'Ren Ren', 'hatch' ),
                    'background' => '',
                    'color' => '#007bb6',
                    'url' => '',
                    'order' => 48,
                ),
                49 => array( 
                    'id'    => 'share-alt',
                    'icon' => 'fa-share-alt',
                    'enabled' => false,
                    'name' => __ ( 'Share alt', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 49,
                ),
                50 => array( 
                    'id'    => 'share-alt-square',
                    'icon' => 'fa-share-alt-square',
                    'enabled' => false,
                    'name' => __ ( 'Share square', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 50,
                ),
                51 => array( 
                    'id'    => 'skype',
                    'icon' => 'fa-skype',
                    'enabled' => false,
                    'name' => __ ( 'Skype', 'hatch' ),
                    'background' => '',
                    'color' => '#00aff0',
                    'url' => '',
                    'order' => 51,
                ),
                52 => array( 
                    'id'    => 'soundcloud',
                    'icon' => 'fa-soundcloud',
                    'enabled' => false,
                    'name' => __ ( 'Sound Cloud', 'hatch' ),
                    'background' => '',
                    'color' => '#f80',
                    'url' => '',
                    'order' => 52,
                ),
                53 => array( 
                    'id'    => 'spotify',
                    'icon' => 'fa-spotify',
                    'enabled' => false,
                    'name' => __ ( 'Spotify', 'hatch' ),
                    'background' => '',
                    'color' => '#7ab800',
                    'url' => '',
                    'order' => 53,
                ),
                54 => array( 
                    'id'    => 'stack-exchange',
                    'icon' => 'fa-stack-exchange',
                    'enabled' => false,
                    'name' => __ ( 'Stack Exchange', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 54,
                ),
                55 => array( 
                    'id'    => 'stack-overflow',
                    'icon' => 'fa-stack-overflow',
                    'enabled' => false,
                    'name' => __ ( 'Stack Overflow', 'hatch' ),
                    'background' => '',
                    'color' => '#fe7a15',
                    'url' => '',
                    'order' => 55,
                ),
                56 => array( 
                    'id'    => 'steam',
                    'icon' => 'fa-steam',
                    'enabled' => false,
                    'name' => __ ( 'Steam', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 56,
                ),
                57 => array( 
                    'id'    => 'steam-square',
                    'icon' => 'fa-steam-square',
                    'enabled' => false,
                    'name' => __ ( 'Steam square', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 57,
                ),
                58 => array( 
                    'id'    => 'stumbleupon',
                    'icon' => 'fa-stumbleupon',
                    'enabled' => false,
                    'name' => __ ( 'Stumble Upon', 'hatch' ),
                    'background' => '',
                    'color' => '#eb4924',
                    'url' => '',
                    'order' => 58,
                ),
                59 => array( 
                    'id'    => 'stumbleupon-circle',
                    'icon' => 'fa-stumbleupon-circle',
                    'enabled' => false,
                    'name' => __ ( 'Stumble Upon circle', 'hatch' ),
                    'background' => '',
                    'color' => '#eb4924',
                    'url' => '',
                    'order' => 59,
                ),
                60 => array( 
                    'id'    => 'tencent-weibo',
                    'icon' => 'fa-tencent-weibo',
                    'enabled' => false,
                    'name' => __ ( 'Tencent Weibo', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 60,
                ),
                61 => array( 
                    'id'    => 'trello',
                    'icon' => 'fa-trello',
                    'enabled' => false,
                    'name' => __ ( 'Trello', 'hatch' ),
                    'background' => '',
                    'color' => '#256a92',
                    'url' => '',
                    'order' => 61,
                ),
                62 => array( 
                    'id'    => 'tumblr',
                    'icon' => 'fa-tumblr',
                    'enabled' => false,
                    'name' => __ ( 'Tumblr', 'hatch' ),
                    'background' => '',
                    'color' => '#35465c',
                    'url' => '',
                    'order' => 62,
                ),
                63 => array( 
                    'id'    => 'tumblr-square',
                    'icon' => 'fa-tumblr-square',
                    'enabled' => false,
                    'name' => __ ( 'Tumblr square', 'hatch' ),
                    'background' => '',
                    'color' => '#35465c',
                    'url' => '',
                    'order' => 63,
                ),
                64 => array( 
                    'id'    => 'twitter',
                    'icon' => 'fa-twitter',
                    'enabled' => false,
                    'name' => __ ( 'Twitter', 'hatch' ),
                    'background' => '',
                    'color' => '#55acee',
                    'url' => '',
                    'order' => 64,
                ),
                65 => array( 
                    'id'    => 'twitter-square',
                    'icon' => 'fa-twitter-square',
                    'enabled' => false,
                    'name' => __ ( 'Twitter square', 'hatch' ),
                    'background' => '',
                    'color' => '#55acee',
                    'url' => '',
                    'order' => 65,
                ),
                66 => array( 
                    'id'    => 'vimeo-square',
                    'icon' => 'fa-vimeo-square',
                    'enabled' => false,
                    'name' => __ ( 'Vimeo square', 'hatch' ),
                    'background' => '',
                    'color' => '#1ab7ea',
                    'url' => '',
                    'order' => 66,
                ),
                67 => array( 
                    'id'    => 'vine',
                    'icon' => 'fa-vine',
                    'enabled' => false,
                    'name' => __ ( 'Vine', 'hatch' ),
                    'background' => '',
                    'color' => '#00b488',
                    'url' => '',
                    'order' => 67,
                ),
                68 => array( 
                    'id'    => 'vk',
                    'icon' => 'fa-vk',
                    'enabled' => false,
                    'name' => __ ( 'VK', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 68,
                ),
                69 => array( 
                    'id'    => 'weibo',
                    'icon' => 'fa-weibo',
                    'enabled' => false,
                    'name' => __ ( 'Weibo', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 69,
                ),
                70 => array( 
                    'id'    => 'weixin',
                    'icon' => 'fa-weixin',
                    'enabled' => false,
                    'name' => __ ( 'Weixin', 'hatch' ),
                    'background' => '',
                    'color' => '#000000',
                    'url' => '',
                    'order' => 70,
                ),
                71 => array( 
                    'id'    => 'windows',
                    'icon' => 'fa-windows',
                    'enabled' => false,
                    'name' => __ ( 'Windows', 'hatch' ),
                    'background' => '',
                    'color' => '#00bcf2',
                    'url' => '',
                    'order' => 71,
                ),
                72 => array( 
                    'id'    => 'xing',
                    'icon' => 'fa-xing',
                    'enabled' => false,
                    'name' => __ ( 'Xing', 'hatch' ),
                    'background' => '',
                    'color' => '#026466',
                    'url' => '',
                    'order' => 72,
                ),
                73 => array( 
                    'id'    => 'xing-square',
                    'icon' => 'fa-xing-square',
                    'enabled' => false,
                    'name' => __ ( 'Xing square', 'hatch' ),
                    'background' => '',
                    'color' => '#026466',
                    'url' => '',
                    'order' => 73,
                ),
                74 => array( 
                    'id'    => 'yelp',
                    'icon' => 'fa-yelp',
                    'enabled' => false,
                    'name' => __ ( 'Yelp', 'hatch' ),
                    'background' => '',
                    'color' => '#C93C27',
                    'url' => '',
                    'order' => 74,
                ),
                75 => array( 
                    'id'    => 'youtube',
                    'icon' => 'fa-youtube',
                    'enabled' => false,
                    'name' => __ ( 'YouTube', 'hatch' ),
                    'background' => '',
                    'color' => '#e52d27',
                    'url' => '',
                    'order' => 75,
                )
            );

            return $defaults;
        }
    }
}