<?php // No direct access.
defined('_JEXEC') or die;
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <style type="text/css" media="all">
      @import "<?php echo $this->baseurl ?>/templates/template_name/css/reset.css";
      @import "<?php echo $this->baseurl ?>/templates/template_name/css/main.css";
    </style>
    <link rel="stylesheet" media="print" href="<?php echo $this->baseurl ?>/templates/template_name/css/print.css" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/template_name/javascript/main.js"></script>
    <jdoc:include type="head" />
    <?php for($ie = 7; $ie <= 10; ++$ie):
    if (file_exists(dirname(__FILE__)."/css/ie{$ie}only.css")): ?>
    <!--[if IE 7]>
        <link href="<?php echo $this->baseurl ?>/templates/sikariporras/css/ie<?php echo $ie; ?>only.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <?php endif; endfor; ?>
</head>
<body class="yksinkertaistettu component-<?php echo htmlspecialchars(JRequest::getString("option"))?> view-<?php echo htmlspecialchars(JRequest::getString("view")); ?>">
<div class="header">
  <jdoc:include type="modules" name="mainmenu" />
</div>
<?php if ($this->getBuffer('message')) : ?>
<div class="errors">
  <h2>
     Huomio 
  </h2>
  <jdoc:include type="message" />
</div>
<?php endif; ?>
<div class="contents">
  <jdoc:include type="component" />
</div>
</body>
</html>
