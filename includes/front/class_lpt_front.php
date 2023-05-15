<?php

defined('ABSPATH') ?: exit();

if (!class_exists('LPT_Front')) :

    class LPT_Front {

        /**
         * Constructor
         */
        public function __construct() {

            // filter/search replace content
            // add_filter('the_content', [$this, 'lpt_front_search_replace_content']);
            add_filter('wp_footer', [$this, 'lpt_front_search_replace_content']);

            // UNCOMMENT TO DEBUG
            // add_action('wp_footer', function () {

            //     $lp_user_data = get_transient($_COOKIE['lp_visitor_key']);

            //     echo base64_decode($lp_user_data);

            //     echo '<pre>';
            //     print_r(json_decode(base64_decode($lp_user_data), true));
            //     echo '</pre>';

            //     // foreach ($_COOKIE as $name => $value) :
            //     //     echo "$name: $value<br>";
            //     // endforeach;
            // });
        }

        /**
         * Search and replace content placeholders with actual rotating content, 
         * and replace button links with tracking link which has content ids appended
         */
        public function lpt_front_search_replace_content() {

            global $post;

            // check whether we're dealing with a landing page before doing anything else
            if ($post->post_type !== 'landing') :
                return;
            endif;

            // retrieve placeholder data
            $placeholder_data = get_field('placeholder_set', $post->ID);

            // bail early if placeholder data is empty
            if (empty($placeholder_data)) :
                return;
            endif;

            // loop to dynamically replace placeholder text on rotational basis

            /**
             * Check whether replacement content is set via cookie already
             * If true, use that content to display content on the page, 
             * else retrieve random content and set 24 hour cookie
             */
            // holds replacement content for first visit
            $replacement_content = [];

            // holds all placeholders
            $placeholders = [];

            // holds content tracking ids
            $tracking_ids = [];

            foreach ($placeholder_data as $data) :

                // retrieve content set
                $content_set = $data['content_set'];

                // randomly grab a content set key
                $random_key = array_rand($content_set);

                // retrieve replacement content based on $random key
                $replacement_content[] = $content_set[$random_key]['content'];

                // retrieve placeholders
                $placeholders[] = $data['placeholder'];

                // retrieve tracking id based on $random_key
                $tracking_ids[] = $content_set[$random_key]['tracking_id'];

            endforeach; ?>

            <input type="hidden" id="lpt_placeholders" value="<?php echo base64_encode(json_encode($placeholders)); ?>">

            <?php

            /*************************
             * Search and replace link 
             **************************/

            // implode tracking ids
            $tracking_ids = implode('+', $tracking_ids);

            // retrieve custom tracking link
            $tracking_link = get_field('tracking_landing_default_url', $post->ID);

            // create final tracking link, based on either the custom tracking link if provided, 
            // else the current page's permalink with tracking data appended as fallback, 
            // else if user cookie is set, retrieve tracking link from there
            if (isset($_COOKIE['lp_visitor_key'])) :

                // retrieve transient
                $lp_user_data        = get_transient($_COOKIE['lp_visitor_key']);

                // decode
                $content_all         = json_decode(base64_decode($lp_user_data), true);

                // retrieve tracking link 
                $final_tracking_link =  $content_all['tracking_link'];

                // final tracking link input for use with JS 
            ?>

                <input type="hidden" id="final_tracking_link" value="<?php echo $final_tracking_link; ?>">

            <?php else :

                $final_tracking_link =  !empty($tracking_link) ? $tracking_link[0]['value'] . '?ct_ids=' . $tracking_ids : get_permalink($post->ID) . '?ct_ids=' . $tracking_ids; ?>

                <input type="hidden" id="final_tracking_link" value="<?php echo $final_tracking_link; ?>">

            <?php endif;


            // search and replace links of tracking link present, else bail
            if (!empty($tracking_link)) : ?>

                <script id="lpt_search_replace_links">
                    $ = jQuery;

                    console.log($('#final_tracking_link').val());

                    $('.lp_discover_cta').each(function(index, element) {
                        $(element).attr('href', $('#final_tracking_link').val())
                    });
                </script>

            <?php else :
                return;
            endif;

            // set up data to store
            $data_to_store = [
                'content'       => $replacement_content,
                'tracking_link' => $final_tracking_link
            ];

            // set our 24 hour cookie so that the same content is displayed to the same visitor for 24 hours
            $expiry = time() + (24 * 60 * 60);

            // Generate a unique transient key for the current user
            $user_key = 'lp_visitor_' . md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

            // Check if the transient exists for the user
            if (false === get_transient($user_key)) :

                // If the transient doesn't exist, generate the text to display and store it in the transient for 24 hours
                $lp_user_data = base64_encode(json_encode($data_to_store));
                set_transient($user_key, $lp_user_data, 24 * 60 * 60);

            endif;

            // Set a cookie to store the user's key for future visits
            setcookie('lp_visitor_key', $user_key, $expiry, '/');

            // get stored replacement content if replacement content cookie is set
            if (isset($_COOKIE['lp_visitor_key'])) :

                // retrieve transient
                $lp_user_data        = get_transient($_COOKIE['lp_visitor_key']);

                // decode
                $content_all         = json_decode(base64_decode($lp_user_data), true);

                // retrieve replacement content
                $replacement_content = $content_all['content']; ?>

                <input type="hidden" id="lpt_replacement_content" value="<?php echo base64_encode(json_encode($replacement_content)); ?>">

            <?php else : ?>
                <input type="hidden" id="lpt_replacement_content" value="<?php echo base64_encode(json_encode($replacement_content)); ?>">
            <?php endif; ?>

            <script id="lpt_content_replacement">
                $ = jQuery;

                // retrieve replacement content
                var repl_cont = JSON.parse(atob($('#lpt_replacement_content').val()));

                // retrieve placeholders
                var placeholders = JSON.parse(atob($('#lpt_placeholders').val()));

                // retrieve #main container html
                var html = $('#main').html();

                // loop to replace placeholders via regex
                $.each(placeholders, function(index, placeholder) {
                    var content = repl_cont[index];
                    var regex = new RegExp(placeholder, 'g');
                    html = html.replace(regex, content);
                });

                // replace #main html
                $('#main').html(html);
            </script>

<?php }
    }

    new LPT_Front();

endif;
