<?php
/**
 * @package		mod_qltextsforusers
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Ql\Module\Qltextsforusers\Site;

// no direct access
use Joomla\CMS\Helper\ModuleHelper;
use Ql\Module\Qltextsforusers\Site\QltextsforusersHelper;

defined('_JEXEC') or die;
require_once __DIR__ . '/QltextsforusersHelper.php';

/** @var $module  */
/** @var $params  */
$qltextsforusersHelper = new QltextsforusersHelper($module, $params);

require ModuleHelper::getLayoutPath('mod_qltextsforusers', $params->get('layout', 'default'));
