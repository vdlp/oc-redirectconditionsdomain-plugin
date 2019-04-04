<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsDomain\Tests;

use Illuminate\Http\Request;
use PluginTestCase;
use Vdlp\RedirectConditions\Models\ConditionParameter;
use Vdlp\RedirectConditions\Tests\Factories\RedirectRuleFactory;
use Vdlp\RedirectConditionsDomain\Classes\DomainCondition;

/**
 * Class DomainConditionTest
 *
 * @package Vdlp\RedirectConditionsDomain\Tests
 */
class DomainConditionTest extends PluginTestCase
{
    /**
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testWithSpecificDomain()
    {
        /** @var Request $request */
        $request = resolve(Request::class);
        $request->headers->set('Accept-Language', 'nl-nl,nl;q=0.5');

        /** @var DomainCondition $condition */
        $condition = resolve(DomainCondition::class);

        ConditionParameter::create([
            'redirect_id' => 1,
            'condition_code' => $condition->getCode(),
            'is_enabled' => date('Y-m-d H:i:s'),
            'parameters' => [
                'domain' => 'example.com',
            ]
        ]);

        $rule = RedirectRuleFactory::createRedirectRule();

        $this->assertTrue($condition->passes($rule, '/from/url'));
    }
}
