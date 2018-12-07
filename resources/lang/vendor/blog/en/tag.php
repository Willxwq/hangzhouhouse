<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Language files for tag in blog package
    |--------------------------------------------------------------------------
    |
    | The following language lines are  for  tag module in blog package
    | and it is used by the template/view files in this module
    |
    */

    /**
     * Singlular and plural name of the module
     */
    'name'          => '标签',
    'names'         => '标签',
    
    /**
     * Singlular and plural name of the module
     */
    'title'         => [
        'main'  => '标签',
        'sub'   => '标签',
        'list'  => '标签列表',
        'edit'  => '编辑标签',
        'create'    => '创建新标签'
    ],

    /**
     * Options for select/radio/check.
     */
    'options'       => [
            'status'           => ['show' => '展示','hide' => '隐藏'],
    ],

    /**
     * Placeholder for inputs
     */
    'placeholder'   => [
        'id'                         => '请输入 id',
        'name'                       => '请输入Name',
        'frequency'                  => '请输入频率',
        'slug'                       => '请输入 slug',
        'status'                     => '请选择状态',
        'created_at'                 => '请选择创建于',
        'updated_at'                 => '请选择修改于',
        'deleted_at'                 => '请选择删除于',
    ],

    /**
     * Labels for inputs.
     */
    'label'         => [
        'id'                         => 'Id',
        'name'                       => 'Name',
        'frequency'                  => '频率',
        'slug'                       => 'Slug',
        'status'                     => '状态',
        'created_at'                 => '创建于',
        'updated_at'                 => '编辑于',
        'deleted_at'                 => '删除于',
    ],

    /**
     * Columns array for show hide checkbox.
     */
    'cloumns'         => [
        'id'                         => ['name' => 'Id', 'data-column' => 1, 'checked'],
        'name'                       => ['name' => 'Name', 'data-column' => 2, 'checked'],
        'frequency'                  => ['name' => '频率', 'data-column' => 3, 'checked'],
        'status'                     => ['name' => '状态', 'data-column' => 4, 'checked'],
        'created_at'                 => ['name' => '创建于', 'data-column' => 5, 'checked'],
    ],

    /**
     * Tab labels
     */
    'tab'           => [
        'name'  => '标签',
    ],

    /**
     * Texts  for the module
     */
    'text'          => [
        'preview' => '点击下面的列表进行预览',
    ],
];
