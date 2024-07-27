<?php
/**
 * @package        mod_qltextsforusers
 * @copyright    Copyright (C) 2024 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Ql\Module\Qltextsforusers\Site\Helper\QltextsforusersHelper;
use Ql\Module\Qltextsforusers\Site\Text;

// no direct access
defined('_JEXEC') or die;

/** @var stdClass $module */
/** @var Registry $params */
/** @var QltextsforusersHelper $qltextsforusersHelper */
/** @var Text $textForAllUsers */
/** @var Text $textForUnloggedUser  */
/** @var Text[] $textForUsergroups  */

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerStyle('qltextsforusers', 'mod_qltextsforusers/styles.css');
$wa->useStyle('qltextsforusers');
?>
<div class="qltextsforusers" id="module<?php echo $module->id ?>">
    <div class="text_for_all_users">
        <?= $textForAllUsers->getText() ?>
    </div>
    <?php if ($textForUnloggedUser->issetText()) : ?>
        <div class="text_unlogged_user">
            <?= $textForUnloggedUser->getText() ?>
        </div>
    <?php endif; ?>
    <?php if (0 < count($textForUsergroups)) foreach ($textForUsergroups as $text) : ?>
        <?php if ($text->issetText()) : ?>
            <div class="text_for_usergroup text_for_usergroup_<?= $text->getUserGroupId()?> text_for_usergroup_select_<?= $text->getUserGroupSelect()?>">
                <?= $text->getText() ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
