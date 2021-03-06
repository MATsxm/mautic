<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

$leadField = (isset($form['featureSettings']) && isset($form['featureSettings']['leadFields'])) ? $view['form']->row($form['featureSettings']['leadFields']) : '';
$hasFeatures = (isset($form['supportedFeatures']));
?>

<ul class="nav nav-tabs pr-md pl-md">
    <li class="active"><a href="#details-container" role="tab" data-toggle="tab"><?php echo $view['translator']->trans('mautic.addon.integration.tab.details'); ?></a></li>
    <?php if ($hasFeatures): ?>
    <li class=""><a href="#features-container" role="tab" data-toggle="tab"><?php echo $view['translator']->trans('mautic.addon.integration.tab.features'); ?></a></li>
    <?php endif; ?>
    <?php if ($leadField): ?>
    <li class=""><a href="#fields-container" role="tab" data-toggle="tab"><?php echo $view['translator']->trans('mautic.addon.integration.tab.fieldmapping'); ?></a></li>
    <?php endif; ?>
</ul>

<?php echo $view['form']->start($form); ?>
<!--/ tabs controls -->
<div class="tab-content pa-md bg-white">
    <div class="tab-pane fade in active bdr-w-0" id="details-container">
        <?php echo $view['form']->row($form['isPublished']); ?>
        <?php echo $view['form']->row($form['apiKeys']); ?>
        <?php if (isset($form['authButton'])): ?>
        <div class="well well-sm">
            <?php echo $view['translator']->trans('mautic.integration.callbackuri', array('%url%' => $callbackUri)); ?><br />
            <input type="text" readonly value="<?php echo $callbackUri; ?>" class="form-control" />
        </div>
        <?php echo $view['form']->row($form['authButton']); ?>
        <?php endif; ?>
    </div>

    <?php if ($hasFeatures): ?>
    <div class="tab-pane fade bdr-w-0" id="features-container">
        <?php echo $view['form']->row($form['supportedFeatures']); ?>
        <?php echo $view['form']->row($form['featureSettings']); ?>
        <?php endif; ?>
    </div>

    <?php if ($leadField): ?>
    <div class="tab-pane fade bdr-w-0" id="fields-container">
        <?php echo $leadField; ?>
    </div>
    <?php endif; ?>
</div>


<?php echo $view['form']->end($form); ?>
