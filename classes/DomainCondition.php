<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsDomain\Classes;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Vdlp\Redirect\Classes\RedirectRule;
use Vdlp\RedirectConditions\Classes\Condition;

class DomainCondition extends Condition
{
    public function __construct(
        private Request $request,
    ) {
    }

    public function getCode(): string
    {
        return 'vdlp_domain';
    }

    public function getDescription(): string
    {
        return 'vdlp.redirectconditionsdomain::lang.domain.description';
    }

    public function getExplanation(): string
    {
        return 'vdlp.redirectconditionsdomain::lang.domain.explanation';
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
        } catch (SuspiciousOperationException) {
            return false;
        }

        return $domain === $host;
    }

    public function getFormConfig(): array
    {
        return [
            'domain' => [
                'tab' => self::TAB_NAME,
                'label' => 'vdlp.redirectconditionsdomain::lang.domain.label',
                'type' => 'text',
                'span' => 'left',
                'placeholder' => 'vdlp.redirectconditionsdomain::lang.domain.placeholder',
            ],
        ];
    }
}
