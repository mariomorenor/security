<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class ReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dataType = $this->dataType('slug', 'reasons');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'reasons',
                'display_name_singular' => "Motivo",
                'display_name_plural'   => 'Motivos',
                'icon'                  => '',
                'model_name'            => 'App\\Models\\Reason',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        Permission::generateFor('reasons');

        $reasonDataType = DataType::where('slug', 'reasons')->firstOrFail();

        $count_order = 0;

        $dataRow = $this->dataRow($reasonDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => $count_order++,
            ])->save();
        }

        $dataRow = $this->dataRow($reasonDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => "Nombre",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }

        $menu = Menu::where('name', 'admin')->firstOrFail();

        $menuItem = MenuItem::updateOrCreate(
            ['title'=>'Motivos'],
            [
            'menu_id' => $menu->id,
            'url'     => '',
            'route'   => 'voyager.reasons.index',
            'target'     => '_self',
            'icon_class' => 'voyager-boat',
            'color'      => null,
            'parent_id'  => null,
            'order'      => 30,
        ]);


        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        Reason::updateOrCreate(
            ["name"=>"Visita"]
        );
        Reason::updateOrCreate(
            ["name"=>"Laborar"]
        );
        Reason::updateOrCreate(
            ["name"=>"Delivery"]
        );

    }

    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }

    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
