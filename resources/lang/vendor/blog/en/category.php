<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Language files for category in blog package
    |--------------------------------------------------------------------------
    |
    | The following language lines are  for  category module in blog package
    | and it is used by the template/view files in this module
    |
    */

    /**
     * Singlular and plural name of the module
     */
    'name'          => '类别',
    'names'         => '类别',
    
    /**
     * Singlular and plural name of the module
     */
    'title'         => [
        'main'  => '类别',
        'sub'   => '类别',
        'list'  => '类别列表',
        'edit'  => '编辑类别',
        'create'    => '创建类别'
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
        'id'                         => '请输入id',
        'name'                       => '请输入类别',
        'slug'                       => '请输入 slug',
        'status'                     => '请选择状态',
        'user_type'                  => '请输入用户类型',
        'user_id'                    => '请输入用户ID',
        'upload_folder'              => '请输入上传文件夹',
        'created_at'                 => '请选择创建于',
        'updated_at'                 => '请选择更新于',
        'deleted_at'                 => '请选择删除于',
    ],

    /**
     * Labels for inputs.
     */
    'label'         => [
        'id'                         => 'Id',
        'name'                       => 'Name',
        'slug'                       => 'Slug',
        'status'                     => '状态',
        'user_type'                  => '用户类型',
        'user_id'                    => '用户类型 id',
        'upload_folder'              => '上传文件夹',
        'created_at'                 => '创建于',
        'updated_at'                 => '更新于',
        'deleted_at'                 => '删除于',
    ],

    /**
     * Columns array for show hide checkbox.
     */
    'cloumns'         => [
        'id'                         => ['name' => 'Id', 'data-column' => 1, 'checked'],
        'name'                       => ['name' => 'Name', 'data-column' => 2, 'checked'],
        'slug'                       => ['name' => 'Slug', 'data-column' => 3, 'checked'],
        'status'                     => ['name' => '状态', 'data-column' => 4, 'checked'],
        'user_type'                  => ['name' => '用户类型', 'data-column' => 5, 'checked'],
        'created_at'                 => ['name' => '创建于', 'data-column' => 6, 'checked'],
    ],

    /**
     * Tab labels
     */
    'tab'           => [
        'name'  => '类别',
    ],

    /**
     * Texts  for the module
     */
    'text'          => [
        'preview' => '点击下面的列表进行预览',
    ],
];
