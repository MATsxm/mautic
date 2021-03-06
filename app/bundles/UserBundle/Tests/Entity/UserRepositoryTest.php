<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\UserBundle\Tests\Entity;

use Mautic\CoreBundle\Helper\SearchStringHelper;
use Mautic\CoreBundle\Test\MauticWebTestCase;

/**
* Class UserRepositoryTest
 * @package Mautic\UserBundle\Tests\Entity
 */
class UserRepositoryTest extends MauticWebTestCase
{

    public function testAdvancedSearch()
    {
        $repo = $this->em->getRepository('MauticUserBundle:User');

        //set the translator
        $repo->setTranslator($this->container->get('translator'));

        //translator is off for tests so use the language string for commands
        $args     = array(
            "filter" =>
                "mautic.core.searchcommand.is:mautic.user.user.searchcommand.isadmin " .
                "mautic.core.searchcommand.is:!mautic.core.searchcommand.isinactive " .
                "mautic.user.user.searchcommand.email:+admin@yoursite.com " .
                "mautic.core.searchcommand.name:mautic.user.user.admin.name " .
                "mautic.user.user.searchcommand.role:mautic.user.role.admin.name " .
                "mautic.user.user.searchcommand.username:admin"
        );

        $filterHelper = new SearchStringHelper();
        $filter       = $filterHelper->parseSearchString($args["filter"]);

        $users = $repo->getEntities($args);
        $this->assertCount(1, $users, $users->getQuery()->getDql() . "\n\n" . print_r($users->getQuery()->getParameters(), true) . "\n\n".print_r($filter,true));

        //mix it up
        $args     = array(
            "filter" =>
                "mautic.core.searchcommand.is:mautic.core.searchcommand.isinactive " .
                " OR mautic.user.user.searchcommand.email:+admin@yoursite.com"
        );

        $filterHelper = new SearchStringHelper();
        $filter       = $filterHelper->parseSearchString($args["filter"]);

        $users = $repo->getEntities($args);
        $this->assertCount(1, $users, $users->getQuery()->getDql() . "\n\n" . print_r($users->getQuery()->getParameters(), true) . "\n\n".print_r($filter,true));

        $args     = array(
            "filter" =>
                "(mautic.core.searchcommand.is:mautic.core.searchcommand.isinactive OR " .
                "mautic.core.searchcommand.is:mautic.user.user.searchcommand.isadmin) " .
                " mautic.user.user.searchcommand.email:+admin@yoursite.com"
        );

        $filterHelper = new SearchStringHelper();
        $filter       = $filterHelper->parseSearchString($args["filter"]);

        $users = $repo->getEntities($args);
        $this->assertCount(1, $users, $users->getQuery()->getDql() . "\n\n" . print_r($users->getQuery()->getParameters(), true) . "\n\n".print_r($filter,true));
    }
}
