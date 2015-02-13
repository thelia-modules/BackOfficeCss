<?php

namespace BackOfficeCss\Controller;

use BackOfficeCss\BackOfficeCss;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Cache\CacheEvent;
use Thelia\Core\Event\TheliaEvents;

/**
 * Class StylesheetEditorController
 * @package BackOfficeCss\Controller
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class StylesheetEditorController extends BaseAdminController
{
    public function showEditorAction()
    {
        foreach ($this->readFileErrors($file = BackOfficeCss::getStylesheetPath()) as $error) {
            $this->getParserContext()->set($error, true);
        }

        $this->getParserContext()->set("file_contents", @file_get_contents($file));

        return $this->render("backoffice-stylesheet-editor");
    }

    public function saveAction()
    {
        $errors = $this->readFileErrors($file = BackOfficeCss::getStylesheetPath());

        // If the file
        if (empty($errors) || (1 === count($errors) && $errors[0] === "file_not_readable")) {
            $baseForm = $this->createForm("backofficecss.edition_form");
            $errorMessage = null;

            try {
                /**
                 * Validate Csrf token and write the file
                 */
                $form = $this->validateForm($baseForm);

                $saveReturn = @file_put_contents($file, $form->get("css_code")->getData());
                if (false === $saveReturn) {
                    $errorMessage = $this->translator->trans(
                        "An unknown error happened while saving the file",
                        [],
                        BackOfficeCss::MESSAGE_DOMAIN
                    );
                } else {
                    /**
                     * Everything worked well, clear assets cache
                     */
                    $this->dispatch(
                        TheliaEvents::CACHE_CLEAR,
                        new CacheEvent(THELIA_WEB_DIR."assets")
                    );
                }
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
            }

            if (null !== $errorMessage) {
                $this->getParserContext()->set("error_message", $errorMessage);
            } else {
                $this->getParserContext()->set("success", true);
            }
        }

        return $this->showEditorAction();
    }

    protected function readFileErrors($file)
    {
        $errors = array();

        if ((!is_file($file) && !@touch($file))) {
            $errors[] = "file_dont_exist";
        }

        if (is_file($file)) {
            if (!is_writable($file)) {
                $errors[] = "file_readonly";
            }

            if (!is_readable($file)) {
                $errors[] = "file_not_readable";
            }
        }

        if (is_dir($file)) {
            $errors[] = "file_is_directory";
        }

        return $errors;
    }
}
