<?php

namespace Modules\Connector\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class VariationResource extends Resource
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

        $array1['variation_id'] = $this->id;
        $array['selling_price_group'] = $array['group_prices'];

        $product = $array['product'];
        $array['product_image_url'] = $product['image_url'];
        $array['product_locations'] = $product['product_locations'];

        unset($array['id']);
        unset($array['group_prices']);
        unset($array['product']);

        if ($array['type'] == 'single') {
            $array['variation_name'] = '';
            $array['product_variation_name'] = '';
        }

        $array = $array1 + $array;
        return $array;
    }
}
