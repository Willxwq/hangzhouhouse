<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Language files for blog in blog package
    |--------------------------------------------------------------------------
    |
    | The following language lines are  for  blog module in blog package
    | and it is used by the template/view files in this module
    |
     */

    /**
     * Singlular and plural name of the module
     */
    'name'        => '博客',
    'names'       => '博客',

    /**
     * Singlular and plural name of the module
     */
    'title'       => [
        'main'   => '博客',
        'sub'    => '博客',
        'list'   => '博客列表',
        'edit'   => '编辑博客',
        'create' => '创建博客',
    ],

    /**
     * Options for select/radio/check.
     */
    'options'     => [
        'published' => ['yes' => 'yes', 'no' => 'no'],
    ],

    /**
     * Placeholder for inputs
     */
    'placeholder' => [
        'id'               => '请输入id',
        'category_id'      => '请选择类别',
        'title'            => '请输入标题',
        'description'      => '请输入说明',
        'images'           => '请输入图片',
        'tags'             => '请输入标签',
        'viewcount'        => '请输入 viewcount',
        'slug'             => '请输入 slug',
        'meta_title'       => '请输入标题',
        'meta_description' => '请输入说明',
        'meta_keyword'     => '请输入关键字',
        'published'        => '请选择已发布',
        'published_at'     => '请选择发布于',
        'user_type'        => '请输入用户类型',
        'user_id'          => '请输入用户ID',
        'upload_folder'    => '请输入上传文件夹',
        'created_at'       => '请选择创建于',
        'updated_at'       => '请选择更新时间',
        'deleted_at'       => '请选择已删除',
    ],

    /**
     * Labels for inputs.
     */
    'label'       => [
        'id'               => 'Id',
        'category_id'      => '类别',
        'title'            => '标题',
        'description'      => '描述',
        'images'           => '图片',
        'tags'             => '标签',
        'viewcount'        => '查看次数',
        'slug'             => 'Slug',
        'meta_title'       => '文章 标题',
        'meta_description' => '文章 描述',
        'meta_keyword'     => '文章 关键词',
        'published'        => '发布时间',
        'published_at'     => '发表于',
        'user_type'        => '用户类型',
        'user_id'          => '用户身份',
        'upload_folder'    => '上传文件夹',
        'created_at'       => '创建于',
        'updated_at'       => '更新于',
        'deleted_at'       => '删除于',
    ],

    /**
     * Columns array for show hide checkbox.
     */
    'cloumns'     => [
        'id'           => ['name' => 'Id', 'data-column' => 1, 'checked'],
        'category_id'  => ['name' => '类别 id', 'data-column' => 2, 'checked'],
        'title'        => ['name' => '标题', 'data-column' => 3, 'checked'],
        'viewcount'    => ['name' => 'Viewcount', 'data-column' => 4, 'checked'],
        'published'    => ['name' => '发布时间', 'data-column' => 5, 'checked'],
        'published_at' => ['name' => '发表于', 'data-column' => 6, 'checked'],
        'user_type'    => ['name' => '用户类型', 'data-column' => 7, 'checked'],
        'created_at'   => ['name' => '创建于', 'data-column' => 8, 'checked'],
    ],

    /**
     * Tab labels
     */
    'tab'         => [
        'name' => '博客',
    ],

    /**
     * Texts  for the module
     */
    'text'        => [
        'preview' => '点击下面的列表进行预览',
    ],
];
