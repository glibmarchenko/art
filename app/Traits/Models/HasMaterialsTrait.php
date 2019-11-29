<?php

    namespace App\Traits\Models;

    use App\Models\Material;

    trait HasMaterialsTrait
    {

        public function materials()
        {
            return $this->belongsToMany(Material::class,'material_to_product','product_id');
        }
        
        public function fillMaterials($materials) {
            if($materials) {
               $materials = collect($materials)->pluck('id');
               $this->materials()->sync($materials);
            }
        }

        /**
         * @return \Illuminate\Support\Collection
         */
        public function materialsList()
        {
            $materials = $this->materials;
            $materialsList = [];
            foreach ($materials as $material) {
                $materialsList[] = ['id' => $material->id, 'name' => $material->name];
            }
            return collect($materialsList);
        }

    }