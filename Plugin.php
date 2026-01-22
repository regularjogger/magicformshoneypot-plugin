<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot;

use System\Classes\PluginBase;
use Event;
use RegularJogger\MagicFormsHoneypot\Classes\Events\FormSubmissionHandler;
use RegularJogger\MagicFormsHoneypot\Components\HoneypotField;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/4.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name' => 'Magic Forms Honeypot',
            'description' => 'Dismisses bot submissions to Magic Forms using the honeypot technique.',
            'author' => 'RegularJogger',
            'icon' => 'icon-bolt',
            'homepage' => 'https://github.com/regularjogger/magicformshoneypot-plugin'
        ];
    }

    /**
     * compatible plugins
     */
    protected array $compatiblePlugins = [
        'martin.forms',
        'blakejones.magicforms',
        'publipresse.forms'
    ];

    /**
     * boot method, called right before the request route.
     */
    public function boot(): void
    {
        foreach ($this->compatiblePlugins as $plugin) {
            Event::listen($plugin . '.beforeSaveRecord', FormSubmissionHandler::class);
        }
    }

    /**
     * registerComponents used by the frontend
     */
    public function registerComponents(): array
    {
        return [
            HoneypotField::class => 'honeypotField'
        ];
    }
}
