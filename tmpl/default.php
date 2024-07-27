<?php
/**
 * @package        mod_qltextsforusers
 * @copyright    Copyright (C) 2022 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;

// no direct access
defined('_JEXEC') or die;

/** @var stdClass $module */
/** @var \Joomla\Registry\Registry $params */
/** @var \Ql\Module\Qltextsforusers\Site\QltextsforusersHelper $qltextsforusersHelper */

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerStyle('qltextsforusers', 'mod_qltextsforusers/styles.css');
$wa->useStyle('qltextsforusers');
?>

<div class="qltextsforusers" id="module<?php echo $module->id ?>">
    asdasdasd
</div>