<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsDomain\Classes;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Vdlp\Redirect\Classes\RedirectRule;
use Vdlp\RedirectConditions\Classes\Condition;

/**
 * Class DomainCondition
 *
 * @package Vdlp\RedirectConditionsDomain\Classes
 */
class DomainCondition extends Condition
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * @param Request $request
     * @param LoggerInterface $log
     */
    public function __construct(Request $request, LoggerInterface $log)
    {
        $this->request = $request;
        $this->log = $log;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'vdlp_domain';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Domain';
    }

    /**
     * {@inheritdoc}
     */
    public function getExplanation(): string
    {
        return 'Match on Domain name.';
    }

    /**
     * {@inheritdoc}
     */
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
        } catch (SuspiciousOperationException $e) {
            return false;
        }

        return $domain === $host;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormConfig(): array
    {
        return [
            'domain' => [
                'tab' => self::TAB_NAME,
                'label' => 'Domain name',
                'type' => 'text',
                'span' => 'left',
                'placeholder' => 'example.com'
            ],
        ];
    }
}
