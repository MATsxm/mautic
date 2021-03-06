<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

$item = $event['extra']['stats'];

?>

<li class="wrapper email-read">
	<div class="figure"><span class="fa <?php echo isset($icons['email']) ? $icons['email'] : '' ?>"></span></div>
	<div class="panel">
	    <div class="panel-body">
	    	<h3>
	    		<a href="<?php echo $view['router']->generate('mautic_email_action',
				    array("objectAction" => "view", "objectId" => $item['email_id'])); ?>"
				   data-toggle="ajax">
				    <?php echo $item['subject']; ?>
				</a>
			</h3>
            <p class="mb-0"><?php echo $view['translator']->trans('mautic.core.timeline.event.time', array('%date%' => $view['date']->toFullConcat($event['timestamp']), '%event%' => $event['eventLabel'])); ?></p>
	    </div>
	    <?php if (isset($event['extra'])) : ?>
	        <div class="panel-footer">
	            <p><?php echo $view['translator']->trans('mautic.email.timeline.event.body', array('%body%' => $item['plainText'])); ?></p>
	        </div>
	    <?php endif; ?>
	</div>
</li>
