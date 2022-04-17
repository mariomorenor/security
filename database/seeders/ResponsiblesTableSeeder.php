<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Responsible;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class ResponsiblesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dataType = $this->dataType('slug', 'responsibles');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'responsibles',
                'display_name_singular' => "Responsable",
                'display_name_plural'   => 'Responsables',
                'icon'                  => '',
                'model_name'            => 'App\\Models\\Responsible',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        Permission::generateFor('responsibles');

        $genericDataType = DataType::where('slug', 'responsibles')->firstOrFail();

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
                'display_name' => "Nombres",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }
        $dataRow = $this->dataRow($genericDataType, 'last_name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => "Apellidos",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }
        $dataRow = $this->dataRow($genericDataType, 'clients_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Clientes",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'model' => 'App\\Models\\Client',
                    'table' => 'clients',
                    'type' => 'belongsToMany',
                    'column' => 'responsible_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => 'client_responsible',
                ]
            ])->save();
        }

        $menu = Menu::where('name', 'admin')->firstOrFail();

        MenuItem::updateOrCreate(
            ['title' => 'Responsables'],
            [
                'menu_id' => $menu->id,
                'url'     => '',
                'route'   => 'voyager.responsibles.index',
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

        $responsible = Responsible::create(
            [
                "name" => "Nora",
                "last_name" => "Naranjo"
            ]
        );
        $client = Client::find(2);
        $responsible->clients()->attach($client);
        $responsible->save();
        $responsible = Responsible::create(
            [
                "name" => "Marco",
                "last_name" => "Mora"
            ]
        );


        $client = Client::find(2);
        $responsible->clients()->attach($client);
        $responsible->save();
        $responsible = Responsible::create(
            [
                "name" => "Javier",
                "last_name" => "Solano"
            ]
        );

        $client = Client::find(3);
        $responsible->clients()->attach($client);
        $responsible->save();
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
