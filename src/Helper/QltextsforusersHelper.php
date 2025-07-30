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
use Joomla\CMS\Event\Content\ContentPrepareEvent;
use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\Event\Dispatcher;
use Joomla\Registry\Registry;
use Joomla\Session\SessionInterface;
use stdClass;

defined('_JEXEC') or die;

class QltextsforusersHelper
{
    const DISPATCHER_EVENT = 'mod_qltextsforusers.text';

    const PARAMS_ALL_USERS_TEXT = 'all_users_text';
    const PARAMS_UNLOGGED_USERS_TEXT = 'unlogged_users_text';
    const PARAMS_USERGROUP_II_TEXT = 'usergroup_%s_text';
    const PARAMS_USERGROUP_II_SELECT = 'usergroup_%s_select';

    public Registry $params;
    public stdClass $module;
    public ?User $user;
    public ?Dispatcher $dispatcher = null;

    function __construct(stdClass $module, Registry $params, ?User $user)
    {
        $this->module = $module;
        $this->params = $params;
        $this->user = $user;
    }

    public function getUsergroupSelectFromParam(int $select): int
    {
        $keyUsergroup = sprintf(static::PARAMS_USERGROUP_II_SELECT, str_pad($select, 2, '0', STR_PAD_LEFT));
        return $this->params->get($keyUsergroup, 0);
    }

    public function getUsergroupTextFromParam(int $select, bool $prepareContent = true): ?string
    {
        $keyText = sprintf(static::PARAMS_USERGROUP_II_TEXT, str_pad($select, 2, '0', STR_PAD_LEFT));
        return $this->getTextFromParam($keyText, $prepareContent);
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

    public function getTextFromParam(string $param, bool $prepareContent = true): ?string
    {
        $text = $this->params->get($param);
        $text = is_null($text) || empty(strip_tags($text)) ? null : $text;
        if (is_string($text) && $prepareContent) {
            $text = $this->prepareContent($text);
        }
        return $text;
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

    public function checkIfUserIsLoggingInRightNow(): bool
    {
        // todo: use joomla input
        return 'user.login' === ($_POST['task'] ?? '') && !empty($_POST['username'] ?? '') && !empty($_POST['password'] ?? '');
    }

    public function prepareContent(?string $text): string
    {
        if (empty($text)) {
            return $text;
        }
        $item = new stdClass();
        $item->text = $text;
        $item->fulltext = $text;
        $item->introtext = $text;
        $params = new Registry($item);
        $paramsEventDispatcher = [static::DISPATCHER_EVENT, &$item, &$params, 0];
        $event = new ContentPrepareEvent('onContentPrepare', $paramsEventDispatcher);
        $res = $this->getDispatcher()->dispatch('onCheckAnswer', $event);
        return $res->getItem() ? $res->getItem()->text : $text;
    }

    private function getDispatcher(): ?Dispatcher
    {
        if (!is_null($this->dispatcher)) {
            return $this->dispatcher;
        }
        return Factory::getApplication()->getDispatcher();
    }
}
