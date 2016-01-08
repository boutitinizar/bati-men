<?php


// Add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'Mnb_bannieres_publicitaires' );

// Register widget.
function Mnb_bannieres_publicitaires() {
    register_widget( 'Mnb_bannieres_publicitaires' );
}

// Widget class.
class Mnb_bannieres_publicitaires extends WP_Widget {

    /*-----------------------------------------------------------------------------------*/
    /*	Widget Setup
    /*-----------------------------------------------------------------------------------*/

    function __construct() {


        /* Widget settings. */
        //$widget_ops = array( 'classname' => 'Mnb_bannieres_publicitaires_widget', 'description' => __('Mnb:  bannières publicitaires', 'socialchef') );

        /* Widget control settings. */
       // $control_ops = array( 'width' => 260, 'height' => 400, 'id_base' => 'Mnb_bannieres_publicitaires_widget' );

        /* Create the widget. */
        parent::__construct( 'Mnb_bannieres_publicitaires_widget', 'Mnb:  bannières publicitaires ');
    }


    /*-----------------------------------------------------------------------------------*/
    /*	Display Widget
    /*-----------------------------------------------------------------------------------*/

    function widget( $args, $instance ) {

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : __(' ', 'bookyourtravel') );



        extract( $args );

        echo $before_widget;

            $url = get_post_meta( $title,'_location',true );



        $img = get_the_post_thumbnail_url($title, 'large' );
        echo "<a target='_blank' href='".$url."'><img  src='".$img."'></a>";



        /* After widget (defined by themes). */
        echo $after_widget;
    }


    /*-----------------------------------------------------------------------------------*/
    /*	Update Widget
    /*-----------------------------------------------------------------------------------*/

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        /* Strip tags to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }


    /*-----------------------------------------------------------------------------------*/
    /*	Widget Settings
    /*-----------------------------------------------------------------------------------*/

    function form( $instance ) {

        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr ( $this->get_field_id( 'title' ) ); ?>"><?php _e('Id post banniere:', 'socialchef') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr ( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr ( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr ($instance['title']); ?>" />
        </p>




    <?php
    }

}