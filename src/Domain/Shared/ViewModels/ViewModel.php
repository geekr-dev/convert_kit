<?php

namespace Domain\Shared\ViewModels;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Reflection;
use ReflectionClass;
use ReflectionMethod;

class ViewModel implements Arrayable
{
    public function toArray(): array
    {
        return collect((new ReflectionClass($this))->getMethods())
            ->reject(
                // 排除掉构造函数和toArray函数
                fn (ReflectionMethod $method) =>
                in_array(
                    $method->getName(),
                    ['__construct', 'toArray']
                )
            )
            ->filter(
                // 只有public函数有效
                fn (ReflectionMethod $method) =>
                in_array(
                    'public',
                    Reflection::getModifierNames(
                        $method->getModifiers()
                    )
                )
            )
            ->mapWithKeys(fn (ReflectionMethod $method) => [
                // 方法名改成蛇形
                Str::snake($method->getName()) => $this->{$method->getName()}()
            ])
            ->toArray();
    }
}
