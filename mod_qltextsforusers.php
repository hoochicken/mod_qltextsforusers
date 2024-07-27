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
$textForUsergroups = [];

$user = QltextsforusersHelper::getJoomlaUser();
$qltextsforusersHelper = new QltextsforusersHelper($module, $params, $user);

// for all users
$textForAllUsersRaw = $params->get('all_users_text');
$textForAllUsersRaw = is_null($textForAllUsersRaw) || empty(strip_tags($textForAllUsersRaw)) ? null : $textForAllUsersRaw;
$textForAllUsers = new Text($textForAllUsersRaw);

$textForUnloggedUser = new Text('');
if (!$qltextsforusersHelper->checkUserIsLoggedIn()) {

    // for logged-in users
    $textForUnloggedUserRaw = $params->get('unlogged_user_text');
    $textForUnloggedUserRaw = is_null($textForUnloggedUserRaw) || empty(strip_tags($textForUnloggedUserRaw)) ? null : $textForUnloggedUserRaw;
    $textForUnloggedUser = new Text($textForUnloggedUserRaw);
} else {

    // for defined user groups, when logged in and usergroup in known
    for ($i = 1; $i <= $fieldCount; $i++) {
        $keyUsergroup = sprintf('usergroup_%s_select', str_pad($i, 2, '0', STR_PAD_LEFT));
        $usergroup = $params->get($keyUsergroup);
        if (empty($usergroup) || !$qltextsforusersHelper->checkIfUserBelongsToUsergroup($usergroup)) {
            continue;
        }
        $keyText = sprintf('usergroup_%s_text', str_pad($i, 2, '0', STR_PAD_LEFT));
        $textValue = $params->get($keyText);
        $text = (new Text($textValue))->setUserGroupId($usergroup)->setUserGroupSelect($i);
        $textForUsergroups[] = $text;
    }
}

if (!$textForAllUsers->issetText() && !$textForUnloggedUser->issetText() && 0 === count($textForUsergroups)) {
    return;
}

require ModuleHelper::getLayoutPath('mod_qltextsforusers', $params->get('layout', 'default'));
