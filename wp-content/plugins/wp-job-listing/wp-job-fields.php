<?php

function mr_add_custom_meta_box() {
add_meta_box(
  'mr_meta',
  __('Job Listing'),
  'mr_meta_callback',
  'job',
  'normal',
  'core'
  );
}

add_action('add_meta_boxes', 'mr_add_custom_meta_box');

function mr_meta_callback($post) {
  //global $post;
  wp_nonce_field(basename(__FILE__), 'mr_jobs_nonce');
  $mr_stored_meta = get_post_meta($post->ID); ?>


<pre>
  <?php //print_r($mr_stored_meta) ?>
</pre>


    <div>
      <div class="meta-row">
        <div class="meta-th">
          <label for="job-id" class="mr-row-title">Job ID</label>
        </div><!-- end meta-th -->
        <div class="meta-td">
          <input type="text" name="job_id" id="job-id" value="<?php if(!empty($mr_stored_meta['job_id']))
          echo esc_attr($mr_stored_meta['job_id'][0]); ?>" />
        </div><!-- end meta-td -->
      </div><!-- end meta-row -->

      <div class="meta-row">
        <div class="meta-th">
          <label for="date-listed" class="mr-row-title">Date Listed</label>
        </div><!-- end meta-th -->
        <div class="meta-td">
          <input type="text" name="date_listed" id="date-listed" value="<?php if(!empty($mr_stored_meta['date_listed']))
          echo esc_attr($mr_stored_meta['date_listed'][1]); ?>" />
        </div><!-- end meta-td -->
      </div><!-- end meta-row -->

      <div class="meta-row">
        <div class="meta-th">
          <label for="application-deadline" class="mr-row-title">Application Deadline</label>
        </div><!-- end meta-th -->
        <div class="meta-td">
          <input type="text" name="application_deadline" id="application-deadline" value="<?php if(!empty($mr_stored_meta['application_deadline']))
          echo esc_attr($mr_stored_meta['application_deadline'][2]); ?>" />
        </div><!-- end meta-td -->
      </div><!-- end meta-row -->

    </div>
<div class="meta">
  <div class="meta-th">
    <span>Principle Duties</span>
  </div>
</div>
<div class="meta-editor">
  <?php

      $content = get_post_meta( $post->ID, 'principle_duties', true );
      $editor = 'principle_duties';
      $settings = [
        'textarea_row' => 5,
        'media_buttons' => true,
      ];

      wp_editor( $content, $editor, $settings );
  ?>
    </div><!-- end meta-editor -->
  <?php
}


function mr_meta_save($post_id) {
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = (isset($_POST['mr_jobs_nonce']) && wp_verify_nonce($_POST['mr_jobs_nonce'], basename(__FILE__) )) ? 'true' : 'false';

  if ($is_autosave || $is_revision || $is_valid_nonce) {
    return;
  }

  if (isset($_POST['job_id'])) {

    update_post_meta( $post_id, 'job_id', sanitize_text_field($_POST['job_id'] ));
  }

  if (isset($_POST['application_deadline'])) {
    update_post_meta( $post_id, 'application_deadline', sanitize_text_field($_POST['application_deadline'] ));
  }

  if (isset($_POST['date_listed'])) {
    update_post_meta( $post_id, 'date_listed', sanitize_text_field($_POST['date_listed'] ));
  }

   if (isset($_POST['principle_duties'])) {
    update_post_meta( $post_id, 'principle_duties', sanitize_text_field($_POST['principle_duties'] ));
  }
}

add_action('save_post', 'mr_meta_save');
