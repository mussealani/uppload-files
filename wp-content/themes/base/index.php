<!DOCTYPE html>
<html>
<head>
  <!-- base href must correspond to the base path of your wordpress site -->
  <base class="baseUrl" href="<?php echo(trailingslashit(site_url())); ?>">
  <base class="themeUrl" href="<?php echo(get_template_directory_uri()); ?>">
  <title><?php echo(get_bloginfo()); ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

</head>
<body <?php body_class(); ?>>


<?php

  $main_path = wp_upload_dir();
    $container = $main_path['basedir'] . '/upload_dir';

  // Create upload_dir folder to hold the documents that will be uploaded
  if (!file_exists($container)) {

      mkdir($container, 0755, true);
  }

  // Define current url
  $current_url = $main_path['baseurl'] . '/upload_dir/';

  // Scan current directory
  $current_dir = scandir($main_path['basedir'] . '/upload_dir/');



    function directoryToArray($directory, $recursive = true, $listDirs = false, $listFiles = true, $exclude = '') {
        $arrayItems = array();
        $skipByExclude = false;
        $handle = opendir($directory);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
            preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip);
            if($exclude){
                preg_match($exclude, $file, $skipByExclude);
            }
            if (!$skip && !$skipByExclude) {
                if (is_dir($directory. DIRECTORY_SEPARATOR . $file)) {
                    if($recursive) {
                        $arrayItems = array_merge($arrayItems, directoryToArray($directory. DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude));
                    }
                    if($listDirs){
                        $file = $directory . DIRECTORY_SEPARATOR . $file;
                        $arrayItems[] = $file;
                    }
                } else {
                    if($listFiles){
                        $file = $directory . DIRECTORY_SEPARATOR . $file;
                        $arrayItems[] = $file;
                    }
                }
            }
        }
        closedir($handle);
        }
        return $arrayItems;
    }

$arr =  directoryToArray($container);



  $json_file_dir =  get_template_directory() . '/json/static-pages.json';
  if (!file_exists($json_file_dir)) {
    $fp = fopen($json_file_dir, 'w+');
    fclose($fp);
  };


     $json = ['static_urls' => $arr];
      $urls  = $json;
    $toJson =  json_encode($urls, JSON_PRETTY_PRINT);
    file_put_contents($json_file_dir,$toJson);


wp_head() ?>


  <?php wp_footer(); ?>
</body>
</html>

