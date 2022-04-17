<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class VisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'visitors');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'visitors',
                'display_name_singular' => "Visitante",
                'display_name_plural'   => 'Visitantes',
                'icon'                  => '',
                'model_name'            => 'App\\Models\\Visitor',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        Permission::generateFor('visitors');

        $genericDataType = DataType::where('slug', 'visitors')->firstOrFail();

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

        $dataRow = $this->dataRow($genericDataType, 'dni');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => "Cédula",
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
            ['title'=>'Visitantes'],
            [
            'menu_id' => $menu->id,
            'url'     => '',
            'route'   => 'voyager.visitors.index',
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


        Visitor::create([
            "name"=>"Jonathan",
            "last_name"=>"Moreno",
            "dni"=>"2300349640"
        ]);
        Visitor::create([
            "name"=>"Pedro",
            "last_name"=>"Pérez",
            "dni"=>"2300430044"
        ]);
        Visitor::create([
            "name"=>"Señor",
            "last_name"=>"Bigotes",
            "dni"=>"1717235852"
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
