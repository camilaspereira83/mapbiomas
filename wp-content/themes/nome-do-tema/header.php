<?php
/**
 * Header template
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Theme
 */

$path = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" href="<?php echo $path; ?>/assets/img/favicons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $path; ?>/assets/img/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $path; ?>/assets/img/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $path; ?>/assets/img/favicons/favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $path; ?>/assets/img/favicons/favicon-192x192.png" />
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo $path; ?>/assets/img/favicons/favicon-512x512.png" />
    <link rel="stylesheet" href="<?php echo $path; ?>/style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>" type="text/css" />
    <?php wp_head(); ?>
  </head>

  <body>
    <!-- HEADER -->
    <?php include 'components/header.php'; ?>

    <div id="content">
