<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot\Components;

use Cms\Classes\ComponentBase;

/**
 * HoneypotFields Component
 *
 * @link https://docs.octobercms.com/4.x/extend/cms-components.html
 */
class HoneypotField extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Honeypot field',
            'description' => 'Injects honeypot input field with required assets in your form.',
            'icon' => 'icon-add-below'
        ];
    }

    /**
     * @link https://docs.octobercms.com/4.x/element/inspector-types.html
     */
    public function defineProperties(): array
    {
        return [];
    }

    /**
     * onRun method, executed when page or layout loads.
     */
    public function onRun(): void
    {
        $this->injectAssets();
    }

    /**
     * Injects frontend assets.
     */
    protected function injectAssets(): void
    {
        $this->addCss('assets/css/rj-moneyspot.css');
    }
}
