<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot\Components;

use Cms\Classes\ComponentBase;

/**
 * HoneypotSAssets Component
 *
 * @link https://docs.octobercms.com/4.x/extend/cms-components.html
 */
class HoneypotAssets extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Honeypot Assets',
            'description' => 'Loads the honeypot assets.',
            'icon' => 'icon-clock'
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
