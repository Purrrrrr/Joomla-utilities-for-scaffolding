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
    <!--[if lte IE 6]>
        <link href="<?php echo $this->baseurl ?>/templates/template_name/css/ieonly.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 7]>
        <link href="<?php echo $this->baseurl ?>/templates/template_name/css/ie7only.css" rel="stylesheet" type="text/css" />
    <![endif]-->
</head>
<body class="yksinkertaistettu component-<?php echo htmlspecialchars(JRequest::getString("option"))?> view-<?php echo htmlspecialchars(JRequest::getString("view")); ?>">
<?php if ($this->getBuffer('message')) : ?>
<div class="errors">
  <h2>
     Huomio 
  </h2>
  <jdoc:include type="message" />
</div>
<?php endif; ?>

<jdoc:include type="component" />

</body>
</html>
