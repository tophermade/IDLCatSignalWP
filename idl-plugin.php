<?php
/*
Plugin Name: Internet Defense League Alert Plugin
Version: 1.0
Description: Quickly add the Internet Defense League "Cat Signal" to your WordPress site. All league campaigns. See http://internetdefenseleague.org/
Author: Topher Wilson, based on Ozh's great settings API base example
Author URI: 
Plugin URI: http://sprresponsive.com/idl/
License: Fuck all, use it!

*/

add_action('admin_init', 'idlCatSignalOptions' );
add_action('admin_menu', 'idlCatSignalPage');
add_action('wp_footer', 'idlShowCatSignal');

// Init plugin options to white list our options
function idlCatSignalOptions(){
    register_setting( 'idlCatSignalFields', 'the_idlCatSignalFields', 'idlSiftCatBox' );
}

// Add menu page
function idlCatSignalPage() {
    add_options_page('Internet Defense League Cat Signal', 'IDL Signal Options', 'manage_options', 'idlcatsignal', 'idlCatBox');
}

// Draw the menu page itself
function idlCatBox() {
    ?>
    <div class="wrap">
        <h2>IDL Signal Options</h2>

        <form method="post" action="options.php">

            <?php settings_fields('idlCatSignalFields'); ?>
            <?php $options = get_option('the_idlCatSignalFields'); ?>

            <table class="form-table">

                <tr valign="top">
                    <th scope="row"><label>Enable the Cat Signal?</label></th>
                    <td>
                        <input name="the_idlCatSignalFields[status]" type="checkbox" value="1" <?php checked('1', $options['status']); ?> />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label>Signal Type?</label></th>
                    <td>
                        <select name="the_idlCatSignalFields[signaltype]">
                            <?php $which = $options['signaltype']; 
                            if($which == "bar"){ ?>
                            <option value="bar">Display Bar</option>
                            <option value="modal">Modal Window</option>
                            <?php } else { ?>
                            <option value="modal">Modal Window</option>
                            <option value="bar">Display Bar</option>
                            <?php }; ?>
                        </select>
                    </td>
                </tr>

            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>

    </div>
    <?php   
}

function idlSiftCatBox($input) {   
    $input['status'] = ( $input['status'] == 1 ? 1 : 0 );    
    $input['signaltype'] =  wp_filter_nohtml_kses($input['signaltype']);    
    return $input;
}

function idlShowCatSignal(){
    $options = get_option('the_idlCatSignalFields');
    $enabled = $options['status'];
    $which = $options['signaltype'];
    if($which == "bar" || $status == "1"){ ?>

        <script type="text/javascript">
            window._idl = {};
            _idl.variant = "banner";
            (function() {
                var idl = document.createElement("script");
                idl.type = "text/javascript";
                idl.async = true;
                idl.src = ("https:" == document.location.protocol ? "https://" : "http://") + "members.internetdefenseleague.org/include/?url=" + (_idl.url || "") + "&campaign=" + (_idl.campaign || "") + "&variant=" + (_idl.variant || "banner");
                document.getElementsByTagName("body")[0].appendChild(idl);
            })();
        </script>

    <?php };
    if($which == "modal" || $status == "1"){ ?>

        <script type="text/javascript">
            window._idl = {};
            _idl.variant = "modal";
            (function() {
                var idl = document.createElement("script");
                idl.type = "text/javascript";
                idl.async = true;
                idl.src = ("https:" == document.location.protocol ? "https://" : "http://") + "members.internetdefenseleague.org/include/?url=" + (_idl.url || "") + "&campaign=" + (_idl.campaign || "") + "&variant=" + (_idl.variant || "banner");
                document.getElementsByTagName("body")[0].appendChild(idl);
            })();
        </script>

    <?php };
}

?>