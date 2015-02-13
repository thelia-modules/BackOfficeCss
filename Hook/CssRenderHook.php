<?php

namespace BackOfficeCss\Hook;

use BackOfficeCss\BackOfficeCss;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Tools\URL;

/**
 * Class CssRenderHook
 * @package BackOfficeCss\Hook
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class CssRenderHook extends BaseHook
{
    public function onMainStylesheet(HookRenderEvent $event)
    {
        // Backup current template definition
        $backup = $this->getParser()->getTemplateDefinition();

        $this->getParser()->setTemplateDefinition(
            new TemplateDefinition("bo-css-module", TemplateDefinition::FRONT_OFFICE)
        );

        $event->add($this->render("hook/stylesheet-renderer.html"));

        // then restore
        $this->getParser()->setTemplateDefinition($backup);
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add([
            "title" => $this->trans("Edit stylesheet", [], BackOfficeCss::MESSAGE_DOMAIN),
            "url" => URL::getInstance()->absoluteUrl("/admin/module/BackOfficeCss"),
        ]);
    }
}
