<?php
/**
 * @package		mod_qltextsforusers
 * @copyright	Copyright (C) 2024 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry;
use Ql\Module\Qltextsforusers\Site\Helper\QltextsforusersHelper;
use Ql\Module\Qltextsforusers\Site\Text;

defined('_JEXEC') or die;

/** @var Registry $params */
/** @var \stdClass $module  */
$fieldCount = 5;
$prepareContent = (bool)$params->get('content_prepare', true);
$textForUsergroups = [];

$user = QltextsforusersHelper::getJoomlaUser();
$qltextsforusersHelper = new QltextsforusersHelper($module, $params, $user);

// for all users
$textForAllUsers = new Text($qltextsforusersHelper->getTextFromParam(QltextsforusersHelper::PARAMS_ALL_USERS_TEXT));

$textForUnloggedUser = !$qltextsforusersHelper->checkUserIsLoggedIn()
    ? new Text($qltextsforusersHelper->getTextFromParam(QltextsforusersHelper::PARAMS_UNLOGGED_USERS_TEXT))
    : new Text('');

if ($qltextsforusersHelper->checkUserIsLoggedIn()) {
    // for defined user groups, when logged in and usergroup in known
    for ($select = 1; $select <= $fieldCount; $select++) {
        $usergroup = $qltextsforusersHelper->getUsergroupFromParams($select);
        if (empty($usergroup) || !$qltextsforusersHelper->checkIfUserBelongsToUsergroup($usergroup)) {
            continue;
        }
        $textValue = $qltextsforusersHelper->getTextFromParams($select);
        if (empty($textValue) || empty(strip_tags(trim($textValue)))) {
            continue;
        }
        $textForUsergroups[] = (new Text($textValue))->setUserGroupId($usergroup)->setUserGroupSelect($select);
    }
}

if (!$textForAllUsers->issetText() && !$textForUnloggedUser->issetText() && 0 === count($textForUsergroups)) {
    return;
}

require ModuleHelper::getLayoutPath('mod_qltextsforusers', $params->get('layout', 'default'));
