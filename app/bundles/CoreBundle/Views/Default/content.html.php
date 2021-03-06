<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!$app->getRequest()->isXmlHttpRequest() && $view['slots']->get('contentOnly', false) === false):
    //load base template
    $view->extend('MauticCoreBundle:Default:base.html.php');
endif;
?>

<div class="content-body">
    <?php echo $view->render('MauticCoreBundle:Default:pageheader.html.php'); ?>
	<?php $view['slots']->output('_content'); ?>
</div>

<?php $view['slots']->output('modal'); ?>
