<?php

namespace Modules\Connector\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $array = parent::toArray($request);

        $array['brand'] = $this->brand;
        $array['unit'] = $this->unit;
        $array['category'] = $this->category;
        $array['sub_category'] = $this->sub_category;
        $array['product_tax'] = $this->product_tax;

        foreach ($array['product_variations'] as $key => $value) {
            foreach ($value['variations'] as $k => $v) {
               if (isset($v['group_prices'])) {
                    $array['product_variations'][$key]['variations'][$k]['selling_price_group'] = $v['group_prices'];
                    unset($array['product_variations'][$key]['variations'][$k]['group_prices']);
                }
            }
        }
        
        return array_diff_key($array, array_flip($this->__excludeFields()));
    }

    private function __excludeFields(){
        return [
            'created_at',
            'updated_at',
            'brand_id',
            'unit_id',
            'category_id',
            'sub_category_id',
            'tax',
            'tax_type',
        ];
    }
}
