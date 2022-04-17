<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class EntriesTableSeeder extends Seeder
{
    public function run()
    {

        $dataType = $this->dataType('slug', 'entries');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'entries',
                'display_name_singular' => "Ingreso",
                'display_name_plural'   => 'Ingresos',
                'icon'                  => '',
                'model_name'            => 'App\\Models\\Entry',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('entries');

        $genericDataType = DataType::where('slug', 'entries')->firstOrFail();

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

        $dataRow = $this->dataRow($genericDataType, 'date_in');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => "Fecha Ingreso",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'display' => [
                        'width' => 6
                    ]
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'date_out');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => "Fecha Salida",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'display' => [
                        'width' => 6
                    ]
                ]
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

        $dataRow = $this->dataRow($genericDataType, 'client_entry_relationship');
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
                    'pivot_table'=>'clients',
                    'display' => [
                        'width' => 4
                    ]
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'camera_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => "camera_id",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'camera_entry_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Cámara",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'view' => 'custom_form_fields.Entries.camera',
                    'model' => 'App\\Models\\Camera',
                    'table' => 'cameras',
                    'type' => 'belongsTo',
                    'column' => 'camera_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table'=>'cameras',
                    'display' => [
                        'width' => 4
                    ]

                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'responsible_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => "responsible_id",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'responsibles_client_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Responsable",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'view' => 'custom_form_fields.Entries.responsibles',
                    'display' => [
                        'width' => 4
                    ],
                    'model' => 'App\\Models\\Responsible',
                    'table' => 'responsibles',
                    'type' => 'belongsTo',
                    'column' => 'responsible_id',
                    'key' => 'id',
                    'label' => 'full_name',
                    'pivot_table'=>'responsibles'

                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'reason_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => "reason_id",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'reasons_entry_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Motivo",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'model' => 'App\\Models\\Reason',
                    'table' => 'reasons',
                    'type' => 'belongsTo',
                    'column' => 'reason_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table'=>'reasons',
                    'display' => [
                        'width' => 4
                    ]
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'visitor_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => "visitor_id",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'visitor_entry_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => "Visitante",
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'model' => 'App\\Models\\Visitor',
                    'table' => 'visitors',
                    'type' => 'belongsTo',
                    'column' => 'visitor_id',
                    'key' => 'id',
                    'label' => 'full_name_dni',
                    'pivot_table'=>'visitors',
                    'display' => [
                        'width' => 4
                    ]
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'image_path');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'image',
                'display_name' => "Imágen",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'display' => [
                        'width' => 4
                    ]
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($genericDataType, 'observation');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text_area',
                'display_name' => "Observación",
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count_order++,
                'details' => [
                    'display' => [
                        'width' => 12
                    ]
                ]
            ])->save();
        }

        $menu = Menu::where('name', 'admin')->firstOrFail();

        MenuItem::updateOrCreate(
            ['title' => 'Ingresos'],
            [
                'menu_id' => $menu->id,
                'url'     => '',
                'route'   => 'voyager.entries.index',
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
