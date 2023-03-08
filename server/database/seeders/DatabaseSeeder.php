<?php

namespace Database\Seeders;

use App\Models\DoorParam;
use App\Models\DoorParamsType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $doorColors = [
            [
                'title' => 'Красный',
                'value' => 'red',
                'price' => 1000
            ],
            [
                'title' => 'Желтый',
                'value' => 'yellow',
                'price' => 1200
            ],
            [
                'title' => 'Зеленый',
                'value' => 'green',
                'price' => 1400
            ],
            [
                'title' => 'Синий',
                'value' => 'blue',
                'price' => 1500
            ],
        ];
        $doorSizes = [1000, 1200, 1400];
        $doorSides = [
            [
                'title' => 'Справа',
                'value' => 'right',
                'price' => 0
            ],
            [
                'title' => 'Слева',
                'value' => 'left',
                'price' => 200
            ],
        ];

        $doorColoredParamsTypes = ['paint', 'film', 'handle'];
        $doorSizeParamsTypes = ['width', 'height'];

        // id внешнего ключа из таблицы door_params
        // который ссылается на тип door_params(door_params_types)
        $doorParamsTypeId = 1;

        $doorParamsType = new DoorParamsType;
        $doorParamsType->type = 'side';
        $doorParamsType->save();

        // заполняем таблицу door_params 
        // данными сторон открывания
        foreach ($doorSides as $doorSide) {
            $doorParams = new DoorParam;
            $doorParams->door_params_type_id = $doorParamsTypeId;
            $doorParams->title = $doorSide['title'];
            $doorParams->value = $doorSide['value'];
            $doorParams->price = $doorSide['price'];
            $doorParams->save();
        }
        $doorParamsTypeId++;

        $doorParamsType = new DoorParamsType;
        $doorParamsType->type = 'accessories';
        $doorParamsType->save();

        // заполняем таблицу door_params 
        // данными аксессуаров
        for ($i = 1; $i < 5; $i++) {
            $doorParams = new DoorParam;
            $doorParams->door_params_type_id = $doorParamsTypeId;
            $doorParams->title = "A$i";
            $doorParams->value = "A$i";
            $doorParams->price = 1000 + 100 * $i;
            $doorParams->save();
        }
        $doorParamsTypeId++;

        // заполняем таблицу door_params 
        // данными параметрами имеющие цвета
        foreach ($doorColoredParamsTypes as $doorColoredParamsType) {
            $doorParamsType = new DoorParamsType;
            $doorParamsType->type = $doorColoredParamsType;
            $doorParamsType->save();

            foreach ($doorColors as $doorColor) {
                $doorParams = new DoorParam;
                $doorParams->door_params_type_id = $doorParamsTypeId;
                $doorParams->title = $doorColor['title'];
                $doorParams->value = $doorColor['value'];
                $doorParams->price = $doorColor['price'];
                $doorParams->save();
            }
            $doorParamsTypeId++;
        }

        // заполняем таблицу door_params 
        // данными параметрами имеющие размер
        foreach ($doorSizeParamsTypes as $doorSizeParamsType) {
            $doorParamsType = new DoorParamsType;
            $doorParamsType->type = $doorSizeParamsType;
            $doorParamsType->save();

            foreach ($doorSizes as $doorSize) {
                $doorParams = new DoorParam;
                $doorParams->door_params_type_id = $doorParamsTypeId;
                $doorParams->title = $doorSize;
                $doorParams->value = $doorSize;
                $doorParams->price = $doorSize;
                $doorParams->save();
            }
            $doorParamsTypeId++;
        }
    }
}