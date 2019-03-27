<div id="nav-below" class="navigation floatbox clearfix">
  <?php 
    $prevpost = get_adjacent_post(false, '', true);
    $nextpost = get_adjacent_post(false, '', false);

    echo '<div class="leftside"><h3>[PREVIOUS]</h3>';

    if ( $prevpost ) {

      echo '<a href="' . get_permalink($prevpost->ID) . '">';

      if ( has_post_thumbnail($prevpost->ID) ) {
        echo '<span class="imgbox"><img src="'. get_template_directory_uri() . '/scripts/timthumb.php?src=/' . my_get_attachment_url_for_timsrc(get_post_thumbnail_id($prevpost->ID)) . '&amp;w=80&amp;h=80&amp;zc=1&amp;q=100" alt="' . esc_attr($prevpost->post_title) . '" /></span>';
      } else {
        echo '<span class="imgbox"><img src="'. get_template_directory_uri() . '/scripts/timthumb.php?src='. my_get_attachment_url_for_timsrc(get_stylesheet_directory_uri() . '/images/c_entry_dummy_square.png') . '&amp;w=80&amp;h=80&amp;zc=1&amp;q=100" alt="' . esc_attr($prevpost->post_title) . '" /></span>';
      }

      echo '<h4>'. esc_attr($prevpost->post_title) .'</h4>';
      echo '</a>';

    } else {

      echo '<p class="first">前の記事はありません</p>';

    }

    echo '</div>';
    echo '<div class="rightside"><h3>[次の記事]</h3>';

    if ( $nextpost ) {
      echo '<a href="' . get_permalink($nextpost->ID) . '">';
      echo '<h4>'. esc_attr($nextpost->post_title) .'</h4>';

      if( has_post_thumbnail($nextpost->ID) ) {
        echo '<span class="imgbox"><img src="'. get_template_directory_uri() . '/scripts/timthumb.php?src=/' . my_get_attachment_url_for_timsrc(get_post_thumbnail_id($nextpost->ID)) . '&amp;w=80&amp;h=80&amp;zc=1&amp;q=100" alt="' . esc_attr($nextpost->post_title) . '" /></span>';
      } else {
        echo '<span class="imgbox"><img src="'. get_template_directory_uri() . '/scripts/timthumb.php?src='. my_get_attachment_url_for_timsrc(get_stylesheet_directory_uri() . '/images/c_entry_dummy_square.png') . '&amp;w=80&amp;h=80&amp;zc=1&amp;q=100" alt="' . esc_attr($prevpost->post_title) . '" /></span>';
      }

      echo '</a>';

    } else {

      echo '<p class="last">次の記事はありません</p>';

    }

    echo '</div>';
   ?>
</div><!-- #nav-below -->