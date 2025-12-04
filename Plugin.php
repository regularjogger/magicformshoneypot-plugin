<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot;

use System\Classes\PluginBase;
use Event;
use Log; // pryč
use RegularJogger\MagicFormsHoneypot\Classes\BotDetector;

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
    public array $compatPlugins = [
        'martin.forms',
        'blakejones.magicforms',
        'publipresse.forms'
    ];

    /**
     * method to detect bot submissions
     */
    public function detectBots(array &$post, object $component): void
    {
        if (! empty($post['web']) || ! array_key_exists('web-url', $post) || ! empty($post['web-url'])) {
            $post['HONEYPOT_web'] = $post['web'];
            unset($post['web']);
            $post['HONEYPOT_TIMED_web_url'] = $post['web_url'];
            unset($post['web-url']);
            Log::info('Magic Forms submission dismissed.' . PHP_EOL . PHP_EOL . 'Form alias/name: ' . $component->alias . '/' . $component->name . PHP_EOL . PHP_EOL . print_r($post, true));
            $component->setProperty('mail_enabled', 0);
            $component->setProperty('mail_resp_enabled', 0);
            $component->setProperty('skip_database', 1);
        }
        unset($post['web']);
        unset($post['web-url']);
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot(): void
    {
        foreach ($this->compatPlugins as $plugin) {
            Event::listen( $plugin . '.beforeSaveRecord', [$this, 'detectBots']);
        }
    }

    /**
     * registerComponents used by the frontend
     */
    public function registerComponents(): array
    {
        return [
            'regularJogger\MagicFormsHoneypot\Components\HoneypotFields' => 'honeypotFields'
        ];
    }
}
