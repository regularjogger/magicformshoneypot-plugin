<?php declare(strict_types=1);

namespace RegularJogger\MagicFormsHoneypot\Classes\Events;

use Cms\Classes\ComponentBase;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface as Logger;

class FormSubmissionHandler
{
    protected ?array $postData;
    protected ?ComponentBase $formObject;
    protected string $honeypotFieldName = 'web';
    protected ?string $honeypotFieldValue;
    protected ?string $formAlias;
    protected ?string $formName;
    protected ?string $url;
    protected ?string $userAgent;
    protected ?string $userIpAddr;

    public function __construct(
        protected Request $request,
        protected Logger $logger,
    ) {}

    /**
     * Entry point - initialises submission data, then checks whether a bot submitted the form and delegates.
     */
    public function handle(array &$post, ComponentBase $formComponent): void
    {
        if (! $this->isHoneypotPresent($post)) {
            return;
        }

        $this->initSubmissionData($post, $formComponent);

        if ($this->isBotSubmission()) {
            $this->processBotSubmission();
        } else {
            $this->cleanUpHoneypotField();
        }

        $this->passProcessedData($post, $formComponent);
    }

    protected function isHoneypotPresent(array $post): bool
    {
        return isset($post[$this->honeypotFieldName]);
    }

    protected function initSubmissionData(array $post, ComponentBase $formComponent): void
    {
        $this->postData = $post;
        $this->formObject = $formComponent;
        $this->honeypotFieldValue = $this->postData[$this->honeypotFieldName];
        $this->formAlias = $this->formObject->alias;
        $this->formName = $this->formObject->name;
        $this->url = $this->request->fullUrl();
        $this->userAgent = $this->request->userAgent();
        $this->userIpAddr = $this->request->ip();
    }

    protected function isBotSubmission(): bool
    {
        return $this->honeypotFieldValue !== '';
    }

    protected function processBotSubmission(): void
    {
        $this->storeHoneypotValue();
        $this->cleanUpHoneypotField();
        $this->logSubmission();
        $this->disableMail();
        $this->skipDatabase();
    }

    protected function storeHoneypotValue(): void
    {
        $this->postData['HONEYPOT_' . $this->honeypotFieldName] = $this->honeypotFieldValue;
    }

    protected function cleanUpHoneypotField(): void
    {
        unset($this->postData[$this->honeypotFieldName]);
    }

    protected function logSubmission(): void
    {
        $this->logger->info(
            'Magic Forms submission dismissed.'
            . PHP_EOL . PHP_EOL .
            'Form alias / name: ' . $this->formAlias . ' / ' .$this->formName
            . PHP_EOL . PHP_EOL .
            print_r($this->postData, true)
            . PHP_EOL .
            'URL: ' . $this->url
            . PHP_EOL .
            'User-Agent: ' . $this->userAgent
            . PHP_EOL .
            'IP address: ' . $this->userIpAddr
        );
    }

    protected function disableMail(): void
    {
        $this->formObject->setProperty('mail_enabled', 0);
        $this->formObject->setProperty('mail_resp_enabled', 0);
    }

    protected function skipDatabase(): void
    {
        $this->formObject->setProperty('skip_database', 1);
    }

    protected function passProcessedData(array &$post, ComponentBase &$formComponent): void
    {
        $post = $this->postData;
        $formComponent = $this->formObject;
    }
}
