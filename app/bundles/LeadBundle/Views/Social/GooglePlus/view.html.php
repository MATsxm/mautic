<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

?>

<div class="panel-toolbar-wrapper">
    <div class="panel-toolbar">
        <ul class="nav nav-tabs nav-justified">
            <li class="active">
                <a href="#GoogleProfile" role="tab" data-toggle="tab">
                    <?php echo $view['translator']->trans('mautic.lead.lead.social.google.profile'); ?>
                </a>
            </li>
            <li>
                <a href="#GooglePosts" role="tab" data-toggle="tab">
                    <?php echo $view['translator']->trans('mautic.lead.lead.social.google.posts'); ?>
                </a>
            </li>
            <li>
                <a href="#GooglePhotos" role="tab" data-toggle="tab">
                    <?php echo $view['translator']->trans('mautic.lead.lead.social.google.photos'); ?>
                </a>
            </li>
            <li>
                <a href="#GoogleTags" role="tab" data-toggle="tab">
                    <?php echo $view['translator']->trans('mautic.lead.lead.social.google.tags'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="panel-body tab-content">
    <div class="tab-pane active" id="GoogleProfile">
        <?php echo $view->render('MauticLeadBundle:Social/GooglePlus:profile.html.php', array(
            'lead'      => $lead,
            'profile'   => $details['profile']
        )); ?>
    </div>
    <div class="tab-pane" id="GooglePosts">
        <?php echo $view->render('MauticLeadBundle:Social/GooglePlus:posts.html.php', array(
            'lead'      => $lead,
            'activity'  => (!empty($details['activity']['posts'])) ? $details['activity']['posts'] : array()
        )); ?>
    </div>
    <div class="tab-pane" id="GooglePhotos">
        <?php echo $view->render('MauticLeadBundle:Social/GooglePlus:photos.html.php', array(
            'lead'      => $lead,
            'activity'  => (!empty($details['activity']['photos'])) ? $details['activity']['photos'] : array()
        )); ?>
    </div>
    <div class="tab-pane" id="GoogleTags">
        <?php echo $view->render('MauticLeadBundle:Social/GooglePlus:tags.html.php', array(
            'lead'     => $lead,
            'activity' => (!empty($details['activity']['tags'])) ? $details['activity']['tags'] : array()
        )); ?>
    </div>
</div>