<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsDomain\Classes;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Vdlp\Redirect\Classes\RedirectRule;
use Vdlp\RedirectConditions\Classes\Condition;

class DomainCondition extends Condition
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getCode(): string
    {
        return 'vdlp_domain';
    }

    public function getDescription(): string
    {
        return 'Domain';
    }

    public function getExplanation(): string
    {
        return 'Match on Domain name.';
    }

    public function passes(RedirectRule $rule, string $requestUri): bool
    {
        $parameters = $this->getParameters($rule->getId());

        if (empty($parameters)) {
            return true;
        }

        $domain = (string) ($parameters['domain'] ?? '');

        if (empty($domain)) {
            return true;
        }

        try {
            $host = $this->request->getHost();
        } catch (SuspiciousOperationException $exception) {
            return false;
        }

        return $domain === $host;
    }

    public function getFormConfig(): array
    {
        return [
            'domain' => [
                'tab' => self::TAB_NAME,
                'label' => 'Domain name',
                'type' => 'text',
                'span' => 'left',
                'placeholder' => 'example.com',
            ],
        ];
    }
}
