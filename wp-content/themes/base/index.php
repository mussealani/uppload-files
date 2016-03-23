<!DOCTYPE html>
<html>
<head>
  <!-- base href must correspond to the base path of your wordpress site -->
  <base href="<?php echo(trailingslashit(site_url())); ?>">
  <title><?php echo(get_bloginfo()); ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <?php wp_footer(); ?>
</body>
</html>

