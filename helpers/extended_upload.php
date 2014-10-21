<?php require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-media-list-table.php' );

class Extended_Media_List_Table extends WP_Media_List_Table
{

    /**
     * Add the export bulk action
     * @return array
     */
    public function get_bulk_actions() {

        // get the original bulk actions    
        $actions = parent::get_bulk_actions();

        // add our own action(s)
        $actions['export'] = __( 'Export' );

        // return the actions    
        return $actions;
    }

    /**
     * Returns the current action
     * @return string
     */
    public function current_action() {

        // check if our action(s) are set and handle them
        if ( isset( $_REQUEST['action'] ) && 'export' === $_REQUEST['action'] ) {
            return 'export_media';
        }

        // let the parent class handle all other actions
        parent::current_action();

    }

}?>