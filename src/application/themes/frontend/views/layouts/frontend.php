<!DOCTYPE html>
<html data-wf-page="<?php  print($template['h_page']); ?>" data-wf-site="<?php print $template['h_site']; ?>" >
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print $template['title']; ?> | <?php print Settings_model::$db_config['site_title']; ?></title>
  <link href="<?php print MASTER_URL; ?>assets-front/css/normalize.css" rel="stylesheet" type="text/css">
  <link href="<?php print MASTER_URL; ?>assets-front/css/webflow.css" rel="stylesheet" type="text/css">
  <link href="<?php print MASTER_URL; ?>assets-front/css/wong-fong-academy.webflow.css" rel="stylesheet" type="text/css">
  <script src="<?php print MASTER_URL; ?>assets-front/js/webfont.js" type="text/javascript"></script>
  <script src="<?php print MASTER_URL; ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="<?php print MASTER_URL; ?>assets/bower_components/select2/dist/css/select2.min.css">
  <script type="text/javascript">WebFont.load({  google: {    families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic"]  }});</script>
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link rel="Shortcut Icon" href="<?php print MASTER_URL; ?>images/favicon.ico" type="image/x-icon" />
  <link rel="Bookmark" href="<?php print MASTER_URL; ?>images/favicon.ico" type="image/x-icon" />
  <link rel="icon" href="<?php print MASTER_URL; ?>images/favicon.ico" type="image/x-icon" />
</head>
<script >var base_url = '<?php echo MASTER_URL ?>';</script>
<body >
<?php 
print (!empty($template['partials']['header']))?$template['partials']['header']:'';
print (!empty($template['partials']['sidebar']))?$template['partials']['sidebar']:'';
print $template['body'];
print (!empty($template['partials']['footer']))?$template['partials']['footer']:'';
?>
<script src="<?php print MASTER_URL; ?>assets/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php print MASTER_URL; ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php print MASTER_URL; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php print MASTER_URL; ?>/js/additional-methods.js" type="text/javascript"></script>
<script src="<?php print MASTER_URL; ?>/assets-front/js/webflow.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo autoVersioning('js/frontend.js'); ?>"></script>
</body>
</html>
