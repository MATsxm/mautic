<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

$view->extend('MauticCoreBundle:Default:slim.html.php');
$view['slots']->set('mauticContent', 'social');
?>

<?php if (!empty($message)): ?>
<div class="alert alert-<?php echo $alert; ?>">
    <?php echo $message; ?>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-12 text-center">
        <a class="btn btn-lg btn-primary" href="javascript:void(0);" onclick="Mautic.refreshIntegrationForm();">
            <?php echo $view['translator']->trans('mautic.integration.closewindow'); ?>
        </a>
    </div>
</div>
