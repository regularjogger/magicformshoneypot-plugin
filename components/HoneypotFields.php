<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot\Components;

use Cms\Classes\ComponentBase;

/**
 * HoneypotFields Component
 *
 * @link https://docs.octobercms.com/4.x/extend/cms-components.html
 */
class HoneypotFields extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Honeypot fields',
            'description' => 'Injects honeypot fields with required assets in your form.',
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
     * Inject frontend assets
     */
    public function onRun(): void
    {
        $this->addCss('assets/css/rj-moneyspot.css');
        $this->addJs('assets/js/rj-moneyspot.js', ['defer' => true]);
    }
}
