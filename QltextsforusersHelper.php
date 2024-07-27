<?php
/**
 * @package        mod_qlqltextsforusers
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Ql\Module\Qltextsforusers\Site;
// no direct access
use Joomla\Registry\Registry;
use stdClass;

defined('_JEXEC') or die;

class QltextsforusersHelper
{
    public Registry $params;
    public stdClass $module;

    function __construct(stdClass $module, Registry $params)
    {
        $this->module = $module;
        $this->params = $params;
    }

    public function someMethod()
    {

    }
}
