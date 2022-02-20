<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsDomain\Tests;

use PluginTestCase;
use Vdlp\RedirectConditions\Models\ConditionParameter;
use Vdlp\RedirectConditions\Tests\Factories\RedirectRuleFactory;
use Vdlp\RedirectConditionsDomain\Classes\DomainCondition;

class DomainConditionTest extends PluginTestCase
{
    /**
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testWithSpecificDomain(): void
    {
        /** @var DomainCondition $condition */
        $condition = resolve(DomainCondition::class);

        ConditionParameter::create([
            'redirect_id' => 1,
            'condition_code' => $condition->getCode(),
            'is_enabled' => date('Y-m-d H:i:s'),
            'parameters' => [
                'domain' => 'localhost',
            ],
        ]);

        $rule = RedirectRuleFactory::createRedirectRule();

        $this->assertTrue($condition->passes($rule, '/from/url'));
    }
}
