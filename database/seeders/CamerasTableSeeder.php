<?php

namespace Database\Seeders;

use App\Models\Camera;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class CamerasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dataType = $this->dataType('slug', 'cameras');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'cameras',
                'display_name_singular' => "Cámara",
                'display_name_plural'   => 'Cámaras',
                'icon'                  => '',
                'model_name'            => 'App\\Models\\Camera',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        Permission::generateFor('cameras');

        $genericDataType = DataType::where('slug', 'cameras')->firstOrFail();

        $count_order = 0;

        $dataRow = $this->dataRow($genericDataType, 'id');
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

        $dataRow = $this->dataRow($genericDataType, 'client_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => "client_id",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'client_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Cliente",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'model' => 'App\\Models\\Client',
                    'table' => 'clients',
                    'type' => 'belongsTo',
                    'column' => 'client_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => 'clients',
                    'pivot'       => 0,
                ]
            ])->save();
        }


        $dataRow = $this->dataRow($genericDataType, 'name');
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

        MenuItem::updateOrCreate(
            ['title' => 'Cámaras'],
            [
                'menu_id' => $menu->id,
                'url'     => '',
                'route'   => 'voyager.cameras.index',
                'target'     => '_self',
                'icon_class' => 'voyager-boat',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 30,
            ]
        );


        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        Camera::create([
            "name"=>"ENTRADA",
            "client_id"=>1
        ]);
        Camera::create([
            "name"=>"INGRESO",
            "client_id"=>2
        ]);
        Camera::create([
            "name"=>"SALIDA",
            "client_id"=>2
        ]);
        Camera::create([
            "name"=>"GARAGE",
            "client_id"=>2
        ]);
        Camera::create([
            "name"=>"ENTRADA",
            "client_id"=>3
        ]);

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
