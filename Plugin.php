<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot;

use System\Classes\PluginBase;
use Event;
use Log;

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
            'icon' => 'icon-bolt'
        ];
    }

    /**
     * @var array compatible plugins
     */
    public $compatPlugins = ['martin.forms', 'blakejones.magicforms', 'publipresse.forms'];

    /**
     * boot method, called right before the request route.
     */
    public function boot(): void
    {
        foreach ($this->compatPlugins as $plugin) {
            Event::listen( $plugin . '.beforeSaveRecord', function (array &$post, object $component): void {
                if (! empty($post['web'])) {
                    Log::info('Magic Forms submission dismissed.' . PHP_EOL . PHP_EOL . 'Form alias/name: ' . $component->alias . '/' . $component->name . PHP_EOL . PHP_EOL . print_r($post, true));
                    $component->setProperty('mail_enabled', 0);
                    $component->setProperty('mail_resp_enabled', 0);
                    $component->setProperty('skip_database', 1);
                }
                unset($post['web']);
            });
        }
    }

    /**
     * registerMarkupTags used
     */
    public function registerMarkupTags(): array
    {
        return [
            'functions' => [
                'honeypot_field' => [function(string $label = 'Web', string $type = 'text', string $id = 'web', string $name = 'web', string $placeholder = 'www', string $class = 'web-form-control'): string
                {
                    return sprintf('<label>%s <input type="%s" id="%s" name="%s" placeholder="%s" class="%s"></label>', $label, $type, $id, $name, $placeholder, $class);
                }, false]
            ]
        ];
    }
}
