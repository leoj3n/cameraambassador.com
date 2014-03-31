<?php

$name = get_bloginfo('name');
$assets = get_template_directory_uri() . '/assets';
$rssurl = esc_url(get_feed_link());

ob_start(); language_attributes();
$langatts = ob_get_clean();

ob_start(); wp_title( '|', true, 'right' );
$title = ob_get_clean();

echo <<<HTML
<!DOCTYPE html>
<html class="no-js" {$langatts}>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$title}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon"
    href="{$assets}/img/favicons/favicon.ico">
  <link rel="apple-touch-icon" sizes="57x57"
    href="{$assets}/img/favicons/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="114x114"
    href="{$assets}/img/favicons/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="72x72"
    href="{$assets}/img/favicons/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="144x144"
    href="{$assets}/img/favicons/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="60x60"
    href="{$assets}/img/favicons/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="120x120"
    href="{$assets}/img/favicons/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="76x76"
    href="{$assets}/img/favicons/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="152x152"
    href="{$assets}/img/favicons/apple-touch-icon-152x152.png">
  <link rel="icon" type="image/png"
    href="{$assets}/img/favicons/favicon-196x196.png" sizes="196x196">
  <link rel="icon" type="image/png"
    href="{$assets}/img/favicons/favicon-160x160.png" sizes="160x160">
  <link rel="icon" type="image/png"
    href="{$assets}/img/favicons/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png"
    href="{$assets}/img/favicons/favicon-16x16.png" sizes="16x16">
  <link rel="icon" type="image/png"
    href="{$assets}/img/favicons/favicon-32x32.png" sizes="32x32">

  <meta name="msapplication-TileColor" content="#603cba">
  <meta name="msapplication-TileImage"
    content="{$assets}/img/favicons/mstile-144x144.png">
  <meta name="msapplication-square70x70logo"
    content="{$assets}/img/favicons/mstile-70x70.png">
  <meta name="msapplication-square144x144logo"
    content="{$assets}/img/favicons/mstile-144x144.png">
  <meta name="msapplication-square150x150logo"
    content="{$assets}/img/favicons/mstile-150x150.png">
  <meta name="msapplication-square310x310logo"
    content="{$assets}/img/favicons/mstile-310x310.png">
  <meta name="msapplication-wide310x150logo"
    content="{$assets}/img/favicons/mstile-310x150.png">
HTML;

wp_head();

echo <<<HTML
  <link
    rel="alternate"
    href="{$rssurl}"
    title="{$name} Feed"
    type="application/rss+xml">
  <link
    type='text/css'
    rel='stylesheet'
    href='https://fonts.googleapis.com/css?family=Aladin|Rancho'>
</head>
HTML;

/*
<link rel="import" href="<?php echo get_template_directory_uri(); ?>/elements/my-element.html">
 */

