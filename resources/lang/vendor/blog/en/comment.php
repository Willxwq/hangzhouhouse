<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Language files for comment in blog package
    |--------------------------------------------------------------------------
    |
    | The following language lines are  for  comment module in blog package
    | and it is used by the template/view files in this module
    |
    */

    /**
     * Singlular and plural name of the module
     */
    'name'          => '评论',
    'names'         => '评论',
    
    /**
     * Singlular and plural name of the module
     */
    'title'         => [
        'main'  => '评论',
        'sub'   => '评论',
        'list'  => '评论列表',
        'edit'  => '编辑评论',
        'create'    => '创建新评论'
    ],

    /**
     * Options for select/radio/check.
     */
    'options'       => [
            'published'           => ['yes' =>'yes', 'no' =>'no'],
    ],

    /**
     * Placeholder for inputs
     */
    'placeholder'   => [
        'id'                         => '请输入id',
        'comment'                    => '请输入评论',
        'author'                     => '请输入作者',
        'email'                      => '请输入电子邮件',
        'mobile'                      => '请输入手机',
        'published'                  => '请选择已发布',
        'user_id'                    => '请输入用户ID',
        'user_type'                  => '请输入用户类型',
        'blog_id'                    => '请输入博客ID',
        'created_at'                 => '请选择创建于',
        'updated_at'                 => '请选择更新于',
        'deleted_at'                 => '请选择删除于',
    ],

    /**
     * Labels for inputs.
     */
    'label'         => [
        'id'                         => 'Id',
        'comment'                    => '评论',
        'author'                     => '作者',
        'email'                      => '电子邮件',
        'mobile'                      => '手机',
        'slug'                       => 'Slug',
        'published'                  => '已发布',
        'user_id'                    => 'User id',
        'user_type'                  => 'User type',
        'blog_id'                    => 'Blog id',
        'created_at'                 => '创建于',
        'updated_at'                 => '更新于',
        'deleted_at'                 => '删除于',
    ],

    /**
     * Columns array for show hide checkbox.
     */
    'cloumns'         => [
        'id'                         => ['name' => 'Id', 'data-column' => 1, 'checked'],
        'author'                     => ['name' => '作者', 'data-column' => 2, 'checked'],
        'email'                      => ['name' => '电子邮件', 'data-column' => 3, 'checked'],
        'mobile'                      => ['name' => '手机', 'data-column' => 4, 'checked'],
        'published'                  => ['name' => '已发布', 'data-column' => 5, 'checked'],
        'user_type'                  => ['name' => 'User type', 'data-column' => 6, 'checked'],
        'blog_id'                    => ['name' => 'Blog id', 'data-column' => 7, 'checked'],
        'created_at'                 => ['name' => '创建于', 'data-column' => 8, 'checked'],
    ],

    /**
     * Tab labels
     */
    'tab'           => [
        'name'  => '评论',
    ],

    /**
     * Texts  for the module
     */
    'text'          => [
        'preview' => '点击下面的列表进行预览',
    ],
];
