<?php
/**
 * @package        mod_qltextsforusers
 * @copyright    Copyright (C) 2024 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Ql\Module\Qltextsforusers\Site\Helper;

// no direct access
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\Registry\Registry;
use Joomla\Session\SessionInterface;
use stdClass;

defined('_JEXEC') or die;

class QltextsforusersHelper
{
    public Registry $params;
    public stdClass $module;
    public ?User $user;

    function __construct(stdClass $module, Registry $params, ?User $user)
    {
        $this->module = $module;
        $this->params = $params;
        $this->user = $user;
    }

    public function checkIfUserBelongsToUsergroup(?int $usergroup): bool
    {
        if (empty($usergroup)) {
            return false;
        }

        $userGroupsOfUser = $this->user->getAuthorisedGroups();
        if (empty($userGroupsOfUser)) {
            return false;
        }

        return in_array($usergroup, $userGroupsOfUser);
    }

    public static function getJoomlaUser(): User
    {
        $container = Factory::getContainer();
        $container->alias(SessionInterface::class, 'session.web.site');
        $app = $container->get(SiteApplication::class);
        return $app->getIdentity();
    }

    public function checkUserIsLoggedIn(): bool
    {
        return !empty($this->user->id);
    }
}
