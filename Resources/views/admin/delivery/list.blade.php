@extends('admin.public.header')
@section('title','快递单设置列表')

@section('listsearch')
    <fieldset class="table-search-fieldset" style="display:none">
        <legend>搜索信息</legend>
        <div style="margin: 10px 10px 10px 10px">
            <form class="layui-form layui-form-pane form-search" action="" id="searchFrom">
                <div class="layui-form-item">

                    <div class="layui-inline">
                        <button type="submit" class="layui-btn layui-btn-sm layui-btn-normal"  lay-submit lay-filter="data-search-btn"><i class="layui-icon"></i> 搜 索</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
@endsection

@section('listcontent')
    <table class="layui-hide" id="tableList" lay-filter="tableList"></table>
    <!-- 表头左侧按钮 -->
    <script type="text/html" id="toolbarColumn">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm layuimini-btn-primary" onclick="window.location.reload();" ><i class="layui-icon layui-icon-refresh-3"></i></button>
            <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"><i class="layui-icon layui-icon-add-circle"></i>新增</button>
            <button class="layui-btn layui-btn-sm" lay-event="checkLodop">检测是否安装打印插件</button>
        </div>
    </script>
    <!-- 操作按钮 -->
    <script type="text/html" id="barOperate">
        <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
    </script>
@endsection

@section('listscript')
    <script src="{{asset('modules/sheet/js/LodopFuncs.js?v=1')}}" charset="utf-8"></script>
    <script type="text/javascript">
        layui.use(['form','table','laydate', 'treetable'], function(){
            var table = layui.table, $=layui.jquery, form = layui.form, treetable = layui.treetable, laydate = layui.laydate;
            // 渲染表格
            table.render({
                elem: '#tableList',
                url: '/admin/delivery/ajaxList',
                parseData: function(res) { //res 即为原始返回的数据
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.message, //解析提示文本
                        "count": res.data.count, //解析数据长度
                        "data": res.data.list //解析数据列表
                    }
                },
                cellMinWidth: 80,//全局定义常规单元格的最小宽度
                toolbar: '#toolbarColumn',
                defaultToolbar: [
                    'filter',
                    'exports',
                    'print'
                ],
                title: '快递单设置列表',
                cols: [[
                    {field: 'id', title: 'ID', width: 80},
                    {field: 'express_name', title: '快递公司', width: 250},
                    {field: 'send_name', title: '网点名称', width: 250},
                    {field: 'send_site', title: '网点编码', width: 250},
                    {field: 'customer_name', title: '客户号', width: 250},
                    {field: 'sender', title: '发件人信息',
                        templet: function(info){
                            let divs = "<div>";
                            divs += "<p>名称："+info.name+"</p>";
                            divs += "<p>联系方式："+info.tel+"</p>";
                            divs += "<p>地址："+info.province+info.city+info.exp_area+info.address+"</p>";
                            divs += "</div>";
                            return divs;
                        }
                    },
                    {title:'操作', toolbar: '#barOperate', align: 'center', width: 150}
                ]],
                id: 'listReload',
                limits: [10, 20, 30, 50, 100,200],
                limit: 10,
                page: true,
                text: {
                    none: '抱歉！暂无数据~' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
                }
            });

            //头工具栏事件
            table.on('toolbar(tableList)', function(obj){
                switch(obj.event){
                    case "add": // 新增
                        var index = layer.open({
                            title: '新增快递单设置',
                            type: 2,
                            shade: 0.2,
                            maxmin:true,
                            skin:'layui-layer-lan',
                            shadeClose: true,
                            area: ['80%', '80%'],
                            content: '/admin/delivery/edit',
                        });
                        break;
                    case 'checkLodop': // 检测打印插件是否安装
                        try {
                            var LODOP = getLodop();
                            if(LODOP === false || LODOP === undefined){
                                layer.open({
                                    title: '安装提示',
                                    type: 1,
                                    shade: 0.2,
                                    maxmin:true,
                                    shadeClose: true,
                                    area: ['500px'],
                                    offset: '100px',
                                    content: "<P style='padding: 15px;'>CLodop云打印服务(localhost本地)未安装启动!点击这里<a href='http://www.mtsoftware.cn/download.html' target='_blank' style='color: #0275d8;'>执行安装</a>,安装后请刷新页面。</P>",
                                    btn: ['确认'],
                                    yes: function(index, layero){
                                        layer.close(index); //如果设定了yes回调，需进行手工关闭
                                    }
                                });
                                return false;
                            }
                            let content = "";
                            if (LODOP.CVERSION) {
                                content = "当前有C-Lodop云打印可用！<br> C-Lodop版本:" + LODOP.CVERSION + "(内含Lodop" + LODOP.VERSION + ")"
                            }else{
                                content = "本机已成功安装了Lodop控件！<br> 版本号:" + LODOP.VERSION
                            }
                            layer.open({
                                title: '打印插件提示',
                                type: 1,
                                shade: 0.2,
                                maxmin:true,
                                shadeClose: true,
                                area: ['500px'],
                                offset: '100px',
                                content: "<P style='padding: 15px;'>"+content+"</P>",
                                btn: ['确认'],
                                yes: function(index, layero){
                                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                                }
                            });
                        } catch (err) {
                            layer.open({
                                title: '错误提示',
                                type: 1,
                                shade: 0.2,
                                maxmin:true,
                                shadeClose: true,
                                area: ['500px'],
                                offset: '100px',
                                content: "<P style='padding: 15px;'>"+err+"</P>",
                                btn: ['确认'],
                                yes: function(index, layero){
                                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                                }
                            });
                        }
                        break;
                };
            });

            // 监听行工具事件
            table.on('tool(tableList)', function(obj){
                var data = obj.data;
                var id = data.id;
                switch (obj.event){
                    case "edit":  // 编辑功能
                        var index = layer.open({
                            title: '编辑快递单设置',
                            type: 2,
                            shade: 0.2,
                            maxmin:true,
                            skin:'layui-layer-lan',
                            shadeClose: true,
                            area: ['80%', '80%'],
                            content: '/admin/delivery/edit?id='+id,
                        });
                        break;
                    case "del":  // 删除功能
                        layer.confirm('确定删除快递单设置['+id+']吗？', {
                            title : "删除快递单设置",
                            skin: 'layui-layer-lan'
                        },function(index){
                            $.ajax({
                                url:'/admin/delivery/del',
                                type:'post',
                                data:{'id':id},
                                dataType:"JSON",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                success:function(data){
                                    if(data.code == 0){
                                        layer.msg(data.message,{icon: 1,time:1500},function(){
                                            window.location.reload();
                                        });
                                    }else{
                                        layer.msg(data.message,{icon: 2});
                                    }
                                },
                                error:function(e){
                                    layer.msg(data.message,{icon: 2});
                                },
                            });
                        });
                        break;
                }
            });

            // 监听搜索操作
            form.on('submit(data-search-btn)', function (data) {
                //执行搜索重载
                table.reload('listReload', {
                    where: data.field,
                    page: {
                        curr: 1
                    }
                });
                return false;
            });
        });
    </script>
@endsection
