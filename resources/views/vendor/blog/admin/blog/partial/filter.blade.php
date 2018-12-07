<div class="btn-group blog-blog">
    <button class="btn btn-xs btn-danger btn-search" type="button">
        <i aria-hidden="true" class="fa fa-search">
        </i>
        <span class="hidden-sm hidden-xs"> 搜索</span>
    </button>
    <button aria-expanded="false" class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown" type="button">
        <span class="caret">
        </span>
        <span class="sr-only">
            切换下拉列表
        </span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a class="btn-search" style="cursor:pointer;">
                <i aria-hidden="true" class="fa fa-fw fa-filter">
                </i>
                显示过滤器
            </a>
        </li>
        <li>
            <a class="btn-reset-filter" style="cursor:pointer;">
                <i class="fa fa-fw fa-ban text-danger">
                </i>
                清除过滤器
            </a>
        </li>
        <li class="divider">
        </li>
        <li>
            <a class="btn-save" style="cursor:pointer;">
                <i aria-hidden="true" class="fa fa-fw fa-floppy-o">
                </i>
                保存搜索
            </a>
        </li>
        <li>
            <a class="btn-open" style="cursor:pointer;">
                <i aria-hidden="true" class="fa fa-fw fa-folder-open-o">
                </i>
                保存的搜索
            </a>
        </li>
    </ul>
</div>

<div class="modal fade" id="modal-search">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dd4b39; color: #fff;">
              <button type="button" class="close" data-dismiss="modal" aaria-hidden="true">&times;</button>
              <h4 class="modal-title">搜索</h4>
            </div>
              {!!Form::horizontal_open()
              ->id('form-search')
              ->method('POST')
              ->action(guard_url('settings/settings'))!!}
                <div class="modal-body has-form clearfix">
                    <div class="modal-form">
<div class="container-fluid">
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[id]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.id')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[id]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[category_id]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.category_id')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[category_id]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[title]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.title')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[title]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[viewcount]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.viewcount')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[viewcount]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[published]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.published')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[published]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[published_at]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.published_at')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[published_at]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[user_type]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.user_type')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[user_type]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <label for="search[created_at]" class="col-sm-2 control-label">
                                        {!! trans('blog::blog.label.created_at')!!}
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::text('search[created_at]')->raw()!!}
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 col-lg-12">
                        <button aria-label="Close" class="btn pull-right btn-danger" data-dismiss="modal" type="button">
                            <i class="fa fa-times-circle">
                            </i>
                            关闭
                        </button>
                        <button class="btn btn-success pull-right " id="btn-apply-search" name="new" style="margin-right:1%" type="button">
                            <i class="fa fa-check-circle">
                            </i>
                            搜索
                        </button>
                    </div>
                </div>
              {!!Form::close()!!}
        </div>
    </div>
</div>


<div class="modal fade" id="modal-open">
  <div class="modal-dialog">
    <div class="modal-content" style="max-width:400px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Saved</h4>
      </div>
      <div class="modal-body" style="height:210px; overflow-y: auto;">
        
        <div id="saved-list">
          
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger"  name="Closerep" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
$(document).ready(function(){

    $(".blog-blog .btn-open").click(function(){
        toastr.info('This feature will be enabled soon.', 'Coming soon');
        return false;
        $('#open-list').load("{!!guard_url('/settings/setting/search/blog.blog.search')!!}");
        $('#modal-open').modal("show");
    });

   $(".blog-blog .btn-search").click(function(){
      $('#modal-search').modal("show");
    });
   
    $('.blog-blog .btn-save').click(function(e){
        toastr.info('This feature will be enabled soon.', 'Coming soon');
        return false;
        var search = prompt("Please enter name for your search");
        if (search == null) {
            toastr.error('Please enter valid name.', 'Error');
            return false;
        }
        var formData = new FormData();
        formData.append('value', $("#form-search").serialize());
        formData.append('name', search);
        formData.append('key', 'blog.blog.search');
        formData.append('package', 'Page');
        formData.append('module', 'Page');

        $.ajax({
            url : "{!!guard_url('/settings/setting')!!}",
            type: "POST",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success:function(data, textStatus, jqXHR)
            {
                toastr.success('Search saved successfully.', 'Success');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                toastr.error('An error occurred while saving.', 'Error');
            }
        });

        e.preventDefault();
    });

    $('#btn-apply-search').click( function() {
        oSearch = {};
        $('#form-search input,#form-search select').each( function () {
          key = $(this).attr('name');
          val = $(this).val();
          oSearch[key] = val;
        });
        oTable.api().draw();
        $('#blog-blog-list .btn-reset-filter').css('display', '');
        $('#modal-search').modal("hide");
        
      });
    
    $(".btn-reset-filter").click(function (e) {
        e.preventDefault();
        $("#form-search")[ 0 ].reset();
        oSearch = {};
        $('#form-search input,#form-search select').each( function () {
          key = $(this).attr('name');
          val = $(this).val();
          oSearch[key] = val;
        });
        oTable.api().draw();
        $('#blog-blog-list .btn-reset-filter').css('display', 'none');

    });

});
</script>