<?php

namespace Domain\Automation\Actions;

use Domain\Automation\DTOs\AutomationData;
use Domain\Automation\DTOs\AutomationStepData;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Domain\Shared\Models\User;
use Illuminate\Support\Facades\DB;

class UpsertAutomationAction
{
    public static function execute(AutomationData $data, User $user): Automation
    {
        return DB::transaction(function () use ($data, $user) {
            // 执行插入/更新自动化记录操作
            $automation = self::upsertAutomation($data, $user);

            // 将自动化记录中的每个步骤都删除
            $automation->steps->each->delete();

            // 触发对应自动化事件
            self::upsertEvent($automation, $data);

            // 触发对应自动化当作
            self::upsertActions($automation, $data);

            // 返回自动化对象实例，包含步骤
            return $automation->load('steps');
        });
    }

    private static function upsertAutomation(AutomationData $data, User $user): Automation
    {
        return Automation::updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->toArray(),
                'user_id' => $user->id,
            ]
        );
    }

    private static function upsertEvent(Automation $automation, AutomationData $data): void
    {
        $automation->steps()->updateOrCreate(
            [
                'id' => $data->event->id
            ],
            [
                'type' => AutomationStepType::EVENT,
                'name' => $data->event->name,
                'value' => ['id' => $data->event->value],
            ]
        );
    }

    private static function upsertActions(Automation $automation, AutomationData $data): void
    {
        $data->actions->toCollection()->each(
            fn (AutomationStepData $stepData) =>
            $automation->steps()->updateOrCreate(
                [
                    'id' => $stepData->id,
                ],
                [
                    'type' => AutomationStepType::ACTION,
                    'name' => $stepData->name,
                    'value' => ['id' => $stepData->value],
                ]
            )
        );
    }
}
