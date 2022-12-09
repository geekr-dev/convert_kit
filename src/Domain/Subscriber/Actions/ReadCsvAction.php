<?php

namespace Domain\Subscriber\Actions;

use Illuminate\Support\Collection;

class ReadCsvAction
{
    public static function execute(string $path): Collection
    {
        $handle = fopen($path, "r");
        $i = 0;
        $fields = ['email', 'first_name', 'last_name', 'tags'];
        $fieldMap = array_flip($fields);
        $items = [];
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($i == 0) {
                continue;
            }
            $item = [];
            foreach ($data as $k => $v) {
                $item[$fieldMap[$k]] = $v;
            }
            $items[] = $item;
            $i++;
        }
        return collect($items);
    }
}
