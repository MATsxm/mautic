<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
if ($tmpl == 'index')
    $view->extend('MauticLeadBundle:Lead:index.html.php');
?>

<?php if (count($items)): ?>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered" id="leadTable">
        <thead>
            <tr>
                <th class="col-lead-actions pl-20 visible-md visible-lg">
                    <div class="checkbox-inline custom-primary">
                        <label class="mb-0 pl-10">
                            <input type="checkbox" id="customcheckbox-one0" value="1" data-toggle="checkall" data-target="#leadTable">
                            <span></span>
                        </label>
                    </div>
                </th>
                <?php
                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'lead',
                    'orderBy'    => 'l.lastname, l.firstname, l.company, l.email',
                    'text'       => 'mautic.lead.lead.thead.name',
                    'class'      => 'col-lead-name',
                    'default'    => true
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'lead',
                    'orderBy'    => 'l.email',
                    'text'       => 'mautic.lead.lead.thead.email',
                    'class'      => 'col-lead-email visible-md visible-lg'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'lead',
                    'orderBy'    => 'l.city, l.state',
                    'text'       => 'mautic.lead.lead.thead.location',
                    'class'      => 'col-lead-location visible-md visible-lg'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'lead',
                    'orderBy'    => 'l.points',
                    'text'       => 'mautic.lead.lead.thead.points',
                    'class'      => 'col-lead-points'
                ));
                ?>

            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <?php /** @var \Mautic\LeadBundle\Entity\Lead $item */ ?>
            <?php $fields = $item->getFields(); ?>
            <tr>
                <td class="visible-md visible-lg">
                    <?php
                    $hasEditAccess = $security->hasEntityAccess(
                        $permissions['lead:leads:editown'],
                        $permissions['lead:leads:editother'],
                        $item->getOwner()
                    );

                    $custom = array();
                    if ($hasEditAccess && !empty($currentList)) {
                        //this lead was manually added to a list so give an option to remove them
                        $custom[] = array(
                            'attr' => array(
                                'href' => $view['router']->generate('mautic_leadlist_action', array(
                                    "objectAction" => "removelead",
                                    "objectId" => $currentList['id'],
                                    "leadId"   => $item->getId()
                                )),
                                'data-toggle' => "ajax",
                                'data-method' => 'POST'
                            ),
                            'label' => 'mautic.lead.lead.remove.fromlist',
                            'icon'  => 'fa-remove'
                        );
                    }

                    echo $view->render('MauticCoreBundle:Helper:list_actions.html.php', array(
                        'item'      => $item,
                        'templateButtons' => array(
                            'edit'      => $hasEditAccess,
                            'delete'    => $security->hasEntityAccess($permissions['lead:leads:deleteown'], $permissions['lead:leads:deleteother'], $item->getOwner()),
                        ),
                        'routeBase' => 'lead',
                        'langVar'   => 'lead.lead',
                        'custom'    => $custom
                    ));
                    ?>
                </td>
                <td>
                    <?php if (in_array($item->getId(), $noContactList)) : ?>
                    <div class="pull-right label label-danger"><i class="fa fa-ban"> </i></div>
                    <?php endif; ?>
                    <a href="<?php echo $view['router']->generate('mautic_lead_action',
                        array("objectAction" => "view", "objectId" => $item->getId())); ?>"
                       data-toggle="ajax">
                        <div><?php echo ($item->isAnonymous()) ? $view['translator']->trans($item->getPrimaryIdentifier()) : $item->getPrimaryIdentifier(); ?></div>
                        <div class="small"><?php echo $item->getSecondaryIdentifier(); ?></div>
                    </a>
                </td>
                <td class="visible-md visible-lg"><?php echo $fields['core']['email']['value']; ?></td>
                <td class="visible-md visible-lg">
                    <?php
                    $flag = (!empty($fields['core']['country'])) ? $view['assets']->getCountryFlag($fields['core']['country']['value']) : '';
                    if (!empty($flag)):
                    ?>
                    <img src="<?php echo $flag; ?>" style="max-height: 24px;" class="mr-sm" />
                    <?php
                    endif;
                    if (!empty($fields['core']['city']) && !empty($fields['core']['state']))
                        echo $fields['core']['city']['value'] . ', ' . $fields['core']['state']['value'];
                    elseif (!empty($fields['core']['city']))
                        echo $fields['core']['city']['value'];
                    elseif (!empty($fields['core']['state']))
                        echo $fields['core']['state']['value'];
                    ?>
                    <div class="clearfix"></div>
                </td>
                <td class="text-center">
                    <?php
                    $color = $item->getColor();
                    $style = !empty($color) ? ' style="background-color: ' . $color . ';"' : '';
                    ?>
                    <span class="label label-default"<?php echo $style; ?>><?php echo $item->getPoints(); ?></span>
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
        "menuLinkId"      => 'mautic_lead_index',
        "baseUrl"         => $view['router']->generate('mautic_lead_index'),
        "tmpl"            => $indexMode,
        'sessionVar'      => 'lead'
    )); ?>
</div>
<?php else: ?>
<?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php'); ?>
<?php endif; ?>
