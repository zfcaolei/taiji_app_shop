{extend name="public/container"}
{block name="content"}

<div class="row">

    <div class="col-sm-12">

        <div class="ibox float-e-margins">

            <div class="ibox-title">

                <a type="button" class="btn btn-w-m btn-primary" href="{:url('create')}">添加视频</a>

            </div>
            <div class="ibox-content">

                <div class="row">

                    <div class="m-b m-l">

                        <form action="" class="form-inline">

                            <select name="status" aria-controls="editable" class="form-control input-sm">
                                <option value="">是否显示</option>
                                <option value="1" {eq name="$where.status" value="1"}selected="selected"{/eq}>显示</option>
                                <option value="0" {eq name="$where.status" value="0"}selected="selected"{/eq}>不显示</option>
                            </select>
                            <div class="input-group" style="margin-top: 5px">
                                <input type="text" placeholder="请输入关键词" class="input-sm form-control" name="vedio_name" value="{$where.vedio_name}">
                                <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-search" ></i>搜索</button> </span>
                            </div>

                        </form>

                    </div>



                </div>

                <div class="table-responsive">

                    <table class="table table-striped  table-bordered">

                        <thead>

                        <tr>



                            <th>编号</th>

                            <th>视频名称</th>

                            <th>视频封面图</th>

                            <th>状态</th>

                            <th>查看视频</th>

                            <th>操作</th>

                        </tr>

                        </thead>

                        <tbody class="">

                        {volist name="list" id="vo"}

                        <tr>

                            <td class="text-center">

                                {$vo.id}

                            </td>

                            <td class="text-center">

                                {$vo.vedio_name}

                            </td>

                            <td class="text-center">

                                <img data-image="{$vo.vedio_img}" class="vedio_img" src="{$vo.vedio_img}" alt="{$vo.vedio_img}" title="{$vo.vedio_name}" style="width: 50px;cursor: pointer">

                            </td>

                            <td class="text-center">
                                {if condition="$vo['status'] eq 1"}
                                <i class="fa fa-check text-navy"></i>
                                {else/}
                                <i class="fa fa-close text-danger"></i>
                                {/if}

                            </td>

                            <td class="text-center">

                                <a href="http://prhiiqxdd.bkt.clouddn.com/{$vo['vedio_url']}" style="color: #666;display: block;padding: 5px 0;">查看视频</a>

                            </td>


                            <td class="text-center">

                                <a  href="{:url('create',array('id'=>$vo['id']))}"  class="btn btn-info btn-xs" type="button"  <i class="fa fa-paste"></i> 编辑</a>

                                <button class="btn btn-danger btn-xs del_config_tab" data-id="{$vo.id}" type="button" data-url="{:Url('delete',array('id'=>$vo['id']))}" ><i class="fa fa-warning"></i> 删除

                                </button>
                                    {if condition="$vo['status'] eq 1"}
                                         <a  href="{:url('hidden',array('id'=>$vo['id'],'type'=>0))}"  class="btn btn-warning btn-xs" type="button"  <i class="fa fa-paste"></i> 隐藏</a>
                                    {else/}
                                        <a  href="{:url('hidden',array('id'=>$vo['id'],'type'=> 1))}"  class="btn btn-warning btn-xs" type="button"  <i class="fa fa-paste"></i> 显示</a>
                                    {/if}
                            </td>

                        </tr>

                        {/volist}

                        </tbody>

                    </table>

                </div>

                {include file="public/inner_page"}

            </div>

        </div>

    </div>

</div>
{/block}
{block name="script"}
<script src="{__ADMIN_PATH}js/layuiList.js"></script>
<script>

    $('.image_info').on('click',function (e) {
        var image_url = $(this).data('image');
        $eb.openImage(image_url);
    })
    $('.add-filed').on('click',function (e) {
        $eb.createModalFrame(this.innerText,"{:Url('create')}");
    })
    $('.del_config_tab').on('click',function(){

        var _this = $(this),url =_this.data('url');

        $eb.$swal('delete',function(){

            $eb.axios.get(url).then(function(res){

                if(res.status == 200 && res.data.code == 200) {

                    $eb.$swal('success',res.data.msg);

                    _this.parents('tr').remove();

                }else

                    return Promise.reject(res.data.msg || '删除失败')

            }).catch(function(err){

                $eb.$swal('error',err);

            });

        })

    });
    $('.add_filed_base').on('click',function (e) {
        $eb.swal({
            title: '请选择数据类型',
            input: 'radio',
            inputOptions: ['文本框','多行文本框','单选框','文件上传','多选框'],
            inputValidator: function(result) {
                return new Promise(function(resolve, reject) {
                    if (result) {
                        resolve();
                    } else {
                        reject('请选择数据类型');
                    }
                });
            }
        }).then(function(result) {
            if (result) {
                $eb.createModalFrame(this.innerText,"{:Url('SystemConfig/create')}?type="+result);
            }
        })
    })
</script>
{/block}