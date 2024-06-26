<?php

namespace App\Exports\Common\Sheets;

use App\Abstracts\Export;
use App\Http\Requests\Common\ItemTax as Request;
use App\Interfaces\Export\WithParentSheet;
use App\Models\Common\ItemTax as Model;

class ItemTaxes extends Export implements WithParentSheet
{
    public $request_class = Request::class;

    public function collection()
    {
        return Model::with('item', 'tax')->collectForExport($this->ids, null, 'item_id');
    }

    public function map($model): array
    {
        $item = $model->item;

        if (empty($item)) {
            return [];
        }

        $model->item_name = $model->item->name;
        $model->tax_rate = $model->tax->rate;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'item_name',
            'tax_rate',
        ];
    }
}
