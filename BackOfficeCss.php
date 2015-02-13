<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace BackOfficeCss;

use Thelia\Module\BaseModule;

class BackOfficeCss extends BaseModule
{
    const MESSAGE_DOMAIN = "backofficecss";

    public static function getStylesheetPath()
    {
        return __DIR__.DS."templates".DS."frontOffice".DS.
            "bo-css-module".DS."assets".DS."css".DS."stylesheet.css";
    }
}
