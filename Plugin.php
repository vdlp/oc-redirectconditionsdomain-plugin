<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsDomain;

use System\Classes\PluginBase;
use Vdlp\Redirect\Classes\Contracts\RedirectManagerInterface;
use Vdlp\RedirectConditionsDomain\Classes\DomainCondition;

final class Plugin extends PluginBase
{
    /**
     * @inheritdoc
     */
    public $require = [
        'Vdlp.RedirectConditions',
    ];

    public function pluginDetails(): array
    {
        return [
            'name' => 'Redirect Conditions: Domain',
            'description' => 'Adds Domain conditions to the Redirect plugin.',
            'author' => 'Van der Let & Partners <octobercms@vdlp.nl>',
            'icon' => 'icon-link',
            'homepage' => 'https://octobercms.com/plugin/vdlp-redirectconditionsdomain',
        ];
    }

    public function boot(): void
    {
        /** @var RedirectManagerInterface $manager */
        $manager = resolve(RedirectManagerInterface::class);
        $manager->addCondition(DomainCondition::class, 110);
    }
}
