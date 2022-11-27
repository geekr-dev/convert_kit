<?php
namespace Domain\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory;

    // 定义新的模型工厂加载逻辑
    protected static function newFactory()
    {
        $parts = str(get_called_class())->explode("\\");
        $domain = $parts[1];
        $model = $parts->last();

        // 返回模型工厂实例
        return app(
            "Database\\Factories\\{$domain}\\{$model}Factory"
        );
    }
}