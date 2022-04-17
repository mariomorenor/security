<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dataType = $this->dataType('slug', 'clients');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'clients',
                'display_name_singular' => "Cliente",
                'display_name_plural'   => 'Clientes',
                'icon'                  => '',
                'model_name'            => 'App\\Models\\Client',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        Permission::generateFor('clients');

        $genericDataType = DataType::where('slug', 'clients')->firstOrFail();

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

        $dataRow = $this->dataRow($genericDataType, 'cameras_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Cámaras",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => $count_order++,
                'details'=>[
                    'model' => 'App\\Models\\Camera',
                    'table' => 'cameras',
                    'type' => 'hasMany',
                    'column' => 'client_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => 'clients',
                    'pivot'       => 0,
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'responsibles_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Responsables",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => $count_order++,
                'details'=>[
                    'model' => 'App\\Models\\Responsible',
                    'table' => 'responsibles',
                    'type' => 'belongsToMany',
                    'column' => 'client_id',
                    'key' => 'id',
                    'label' => 'full_name',
                    'pivot_table' => 'client_responsible',
                    'pivot'=>1
                ]
            ])->save();
        }

        $menu = Menu::where('name', 'admin')->firstOrFail();

        MenuItem::updateOrCreate(
            ['title' => 'Clientes'],
            [
                'menu_id' => $menu->id,
                'url'     => '',
                'route'   => 'voyager.clients.index',
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

        Client::create(["name" => "Scanner Express"],);
        Client::create(["name" => "Proají"],);
        Client::create(["name" => "Rey David"],);
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
