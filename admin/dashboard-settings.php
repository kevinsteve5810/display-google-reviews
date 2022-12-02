<?php
function dgr_admin_menu_links() {
    add_menu_page( 'Display Google Reviews Settings', 'Display Google Reviews Settings', 'manage_options', 'display-google-reviews', 'dgr_build_admin_page', 'dashicons-admin-home', 3 );
}

add_action( 'admin_menu', 'dgr_admin_menu_links', 10 );

function dgr_build_admin_page() {
    $tab = (filter_has_var(INPUT_GET, 'tab')) ? filter_input(INPUT_GET, 'tab') : 'dashboard';

    $section = 'admin.php?page=display-google-reviews&amp;tab=';
	?>
    <div class="wrap">
        <h1>Display Google Reviews Dashboard</h1>

        <h2 class="nav-tab-wrapper">
            <a href="<?php echo $section; ?>dashboard" class="nav-tab <?php echo $tab === 'dashboard' ? 'nav-tab-active' : ''; ?>">Dashboard</a>
            <a href="<?php echo $section; ?>settings" class="nav-tab <?php echo $tab === 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
        </h2>

        <?php if ($tab === 'dashboard') { ?>
            <h3>Hello World!</h3>
        <?php } elseif ($tab === 'settings') { ?>
            <?php
            if (isset($_POST['save_send'])) {
                update_option( 'dgr_place_id', sanitize_text_field( $_POST['dgr_place_id'] ) );
		update_option( 'dgr_key', sanitize_text_field( $_POST['dgr_key'] ) );
		update_option( 'dgr_cols', sanitize_text_field( $_POST['dgr_cols'] ) );

                echo '<div class="updated notice is-dismissible"><p>Changes saved successfully!</p></div>';
            }
            ?>

            <h2>Display Google Reviews Settings</h2>
            <p>Enter your Place ID and Key below.</p>

            <form method="post">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="dgr_place_id">Place ID</label></th>
                            <td>
                                <p>
                                    <input type="text" id="dgr_place_id" name="dgr_place_id" class="regular-text" value="<?php echo (get_option( 'dgr_place_id') != '') ? get_option( 'dgr_place_id') : '' ?>">
                                    <br><small>Enter Place ID</small>
                                </p>
                            </td>
                        </tr>
			<tr>
                            <th scope="row"><label for="dgr_key">Key</label></th>
                            <td>
                                <p>
                                    <input type="text" id="dgr_key" name="dgr_key" class="regular-text" value="<?php echo (get_option( 'dgr_key') != '') ? get_option( 'dgr_key') : '' ?>">
                                    <br><small>Enter Key</small>
                                </p>
                            </td>
                        </tr>
			<tr>
                            <th scope="row"><label for="dgr_key">Number of Columns</label></th>
                            <td>
                                <p>
                                    <input type="number" id="dgr_cols" name="dgr_cols" min="1" max="4" class="regular-text" value="<?php echo (get_option( 'dgr_cols') != '') ? get_option( 'dgr_cols') : '' ?>">
                                    <br><small>Enter number of columns</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td><input type="submit" name="save_send" class="button button-primary" value="Send"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        <?php } ?>
    </div>
	<?php
}
