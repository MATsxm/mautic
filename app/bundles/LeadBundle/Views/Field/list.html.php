<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
if ($tmpl == 'index')
    $view->extend('MauticLeadBundle:Field:index.html.php');
?>
<?php if (count($items)): ?>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered leadfield-list" id="leadFieldTable">
        <thead>
            <tr>
                <th class="col-leadfield-orderhandle"></th>
                <th class="col-leadfield-actions pl-20">
                    <div class="checkbox-inline custom-primary">
                        <label class="mb-0 pl-10">
                            <input type="checkbox" id="customcheckbox-one0" value="1" data-toggle="checkall" data-target="#leadFieldTable">
                            <span></span>
                        </label>
                    </div>
                </th>
                <th class="col-leadfield-label"><?php echo $view['translator']->trans('mautic.lead.field.thead.label'); ?></th>
                <th class="visible-md visible-lg col-leadfield-alias"><?php echo $view['translator']->trans('mautic.lead.field.thead.alias'); ?></th>
                <th class="visible-md visible-lg col-leadfield-group"><?php echo $view['translator']->trans('mautic.lead.field.thead.group'); ?></th>
                <th class="col-leadfield-type"><?php echo $view['translator']->trans('mautic.lead.field.thead.type'); ?></th>
                <th class="visible-md visible-lg col-leadfield-id"><?php echo $view['translator']->trans('mautic.lead.field.thead.id'); ?></th>
                <th class="visible-md visible-lg col-leadfield-statusicons"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr id="field_<?php echo $item->getId(); ?>">
                <td><i class="fa fa-fw fa-ellipsis-v"></i></td>
                <td>
                    <?php
                    echo $view->render('MauticCoreBundle:Helper:list_actions.html.php', array(
                        'item'      => $item,
                        'templateButtons' => array(
                            'edit'      => true,
                            'clone'     => true,
                            'delete'    => $item->isFixed() ? false : true,
                        ),
                        'routeBase' => 'leadfield',
                        'langVar'   => 'lead.field',
                        'pull'      => 'left'
                    ));
                    ?>
                </td>
                <td>
                    <?php echo $view->render('MauticCoreBundle:Helper:publishstatus_icon.html.php',array(
                        'item'       => $item,
                        'model'      => 'lead.field'
                    )); ?>
                    <?php echo $item->getLabel(); ?>
                </td>
                <td class="visible-md visible-lg"><?php echo $item->getAlias(); ?></td>
                <td class="visible-md visible-lg"><?php echo $view['translator']->trans('mautic.lead.field.group.'.$item->getGroup()); ?></td>
                <td><?php echo $view['translator']->trans('mautic.lead.field.type.'.$item->getType()); ?></td>
                <td class="visible-md visible-lg"><?php echo $item->getId(); ?></td>
                <td>
                    <?php if ($item->isRequired()): ?>
                        <i class="fa fa-asterisk" data-toggle="tooltip" data-placement="left"
                           title="<?php echo $view['translator']->trans('mautic.lead.field.tooltip.required'); ?>"></i>
                    <?php endif; ?>
                    <?php if (!$item->isVisible()): ?>
                        <i class="fa fa-eye-slash" data-toggle="tooltip" data-placement="left"
                           title="<?php echo $view['translator']->trans('mautic.lead.field.tooltip.invisible'); ?>"></i>
                    <?php endif; ?>
                    <?php if ($item->isFixed()): ?>
                        <i class="fa fa-lock" data-toggle="tooltip" data-placement="left"
                           title="<?php echo $view['translator']->trans('mautic.lead.field.tooltip.fixed'); ?>"></i>
                    <?php endif; ?>
                    <?php if ($item->isListable()): ?>
                        <i class="fa fa-list "data-toggle="tooltip" data-placement="left"
                           title="<?php echo $view['translator']->trans('mautic.lead.field.tooltip.listable'); ?>"></i>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="panel-footer">
    <?php echo $view->render('MauticCoreBundle:Helper:pagination.html.php', array(
        "totalItems"      => $totalItems,
        "page"            => $page,
        "limit"           => $limit,
        "menuLinkId"      => 'mautic_leadfield_index',
        "baseUrl"         => $view['router']->generate('mautic_leadfield_index'),
        'sessionVar'      => 'leadfield'
    )); ?>
</div>
<?php else: ?>
<?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php'); ?>
<?php endif; ?>
