@extends('admin.public.header')
@section('title',$title)
@section('listcontent')
    <div class="layui-form layuimini-form">
        @if(isset($info->id))
        <input type="hidden" name="id" value="{{$info->id}}" />
        @endif

        <div class="layui-form-item">
            <label class="layui-form-label required">选择快递公司</label>
            <div class="layui-input-block">
                <select name="express_id">
                    @foreach($express as $eitem)
                        <option value="{{$eitem->id}}" @if(isset($info->express_id) && $info->express_id == $eitem->id) selected @endif>{{$eitem->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">电子面单客户账号</label>
            <div class="layui-input-block">
                <input type="text" name="customer_name" lay-verify="required" lay-reqtext="电子面单客户账号不能为空" placeholder="请输入电子面单客户账号" value="{{$info->customer_name ?? ''}}" class="layui-input" />
                <div style="font-size: 10px; color: #636c72;">与快递网点申请</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">电子面单密码</label>
            <div class="layui-input-block">
                <input type="text" name="customer_pwd" lay-verify="required" lay-reqtext="电子面单密码不能为空" placeholder="请输入电子面单密码" value="{{$info->customer_pwd ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">月结编码</label>
            <div class="layui-input-block">
                <input type="text" name="month_code" lay-verify="required" lay-reqtext="月结编码不能为空" placeholder="请输入月结编码" value="{{$info->month_code ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">网点编码</label>
            <div class="layui-input-block">
                <input type="text" name="send_site" lay-verify="required" lay-reqtext="网点编码不能为空" placeholder="请输入网点编码" value="{{$info->send_site ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">网点名称</label>
            <div class="layui-input-block">
                <input type="text" name="send_name" lay-verify="required" lay-reqtext="网点名称不能为空" placeholder="请输入网点名称" value="{{$info->send_name ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">发件人公司</label>
            <div class="layui-input-block">
                <input type="text" name="company" lay-verify="required" lay-reqtext="发件人公司不能为空" placeholder="请输入发件人公司" value="{{$info->company ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">发件人名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" lay-reqtext="发件人名称不能为空" placeholder="请输入发件人名称" value="{{$info->name ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">发件人电话</label>
            <div class="layui-input-block">
                <input type="text" name="tel" lay-verify="required" lay-reqtext="发件人电话不能为空" placeholder="请输入发件人电话" value="{{$info->tel ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">发件人手机</label>
            <div class="layui-input-block">
                <input type="text" name="mobile" lay-verify="required" lay-reqtext="发件人手机不能为空" placeholder="请输入发件人手机" value="{{$info->mobile ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">发件人邮编</label>
            <div class="layui-input-block">
                <input type="text" name="post_code" lay-verify="required" lay-reqtext="发件人邮编不能为空" placeholder="请输入发件人邮编" value="{{$info->post_code ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">发件人地址</label>
            <div class="layui-input-block">
                <div id="area-three-select" style="float: left; margin-bottom: 15px;">
                    <div class="layui-input-inline">
                        <select name="province" lay-filter="province">
                            <option value="">请选择省</option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="city" lay-filter="city">
                            <option value="">请选择市</option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="exp_area" lay-filter="exp_area">
                            <option value="">请选择县/区</option>
                        </select>
                    </div>
                </div>
                <input type="text" name="address" lay-verify="required" lay-reqtext="发件人详细地址不能为空" placeholder="请输入发件人详细地址" value="{{$info->address ?? ''}}" class="layui-input" />
            </div>
        </div>

        <div class="hr-line"></div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" id="saveBtn" lay-submit lay-filter="saveBtn">保存</button>
            </div>
        </div>

    </div>
@endsection

@section('listscript')
    <script type="text/javascript">
        layui.use(['iconPickerFa', 'form', 'layer', 'upload'], function () {
            var iconPickerFa = layui.iconPickerFa,
                form = layui.form,
                layer = layui.layer,
                upload = layui.upload,
                $ = layui.$;

            var areaListObj = eval('<?php echo json_encode($areaList);?>');
            var info = {
                province: '{{$info->province ?? ""}}',
                city: '{{$info->city ?? ""}}',
                exp_area: '{{$info->exp_area ?? ""}}',
            };
            setAreaList(info);

            // 动态选择省
            form.on('select(province)', function(data){
                let selectInfo = {
                    province: data.value,
                    city: '',
                    exp_area: '',
                }
                setAreaList(selectInfo);
            });

            // 动态选择市
            form.on('select(city)', function(data){
                let selectInfo = {
                    province: $("select[name='province']").find("option:selected").val(),
                    city: data.value,
                    exp_area: '',
                }
                setAreaList(selectInfo);
            });

            // 动态选择县/区
            form.on('select(exp_area)', function(data){});

            // 动态生成地址联动信息
            function setAreaList(nInfo){
                let pSelectDiv = '<div class="layui-input-inline">';
                pSelectDiv += '<select name="province" lay-filter="province">';
                pSelectDiv += '<option value="">请选择省</option>';
                let celectDiv = '<div class="layui-input-inline">';
                celectDiv += '<select name="city" lay-filter="city">';
                celectDiv += '<option value="">请选择市</option>';
                let dSelectDiv = '<div class="layui-input-inline">';
                dSelectDiv += '<select name="exp_area" lay-filter="exp_area">';
                dSelectDiv += '<option value="">请选择县/区</option>';
                for (let pi in areaListObj){
                    if(nInfo.hasOwnProperty("province") && areaListObj[pi].name === nInfo.province){
                        pSelectDiv += '<option value="'+areaListObj[pi].name+'" selected>'+areaListObj[pi].name+'</option>';
                        for(let ci in areaListObj[pi].children){
                            if(nInfo.hasOwnProperty("city") && areaListObj[pi].children[ci].name === nInfo.city){
                                celectDiv += '<option value="'+areaListObj[pi].children[ci].name+'" selected>'+areaListObj[pi].children[ci].name+'</option>';
                                for(let di in areaListObj[pi].children[ci].children){
                                    if(nInfo.hasOwnProperty("exp_area") && areaListObj[pi].children[ci].children[di].name === nInfo.exp_area){
                                        dSelectDiv += '<option value="'+areaListObj[pi].children[ci].children[di].name+'" selected>'+areaListObj[pi].children[ci].children[di].name+'</option>';
                                    }else{
                                        dSelectDiv += '<option value="'+areaListObj[pi].children[ci].children[di].name+'">'+areaListObj[pi].children[ci].children[di].name+'</option>';
                                    }
                                }
                            }else{
                                celectDiv += '<option value="'+areaListObj[pi].children[ci].name+'">'+areaListObj[pi].children[ci].name+'</option>';
                            }
                        }
                    }else{
                        pSelectDiv += '<option value="'+areaListObj[pi].name+'">'+areaListObj[pi].name+'</option>';
                    }
                }
                pSelectDiv += '</select>';
                pSelectDiv += '</div>';
                celectDiv += '</select>';
                celectDiv += '</div>';
                dSelectDiv += '</select>';
                dSelectDiv += '</div>';
                $("#area-three-select").html(pSelectDiv + celectDiv + dSelectDiv);
                form.render();
            }

            //监听提交
            form.on('submit(saveBtn)', function(data){
                $("#saveBtn").addClass("layui-btn-disabled");
                $("#saveBtn").attr('disabled', 'disabled');
                $.ajax({
                    url:'/admin/delivery/edit',
                    type:'post',
                    data:data.field,
                    dataType:'JSON',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success:function(res){
                        if(res.code==0){
                            layer.msg(res.message,{icon: 1},function (){
                                parent.location.reload();
                            });
                        }else{
                            layer.msg(res.message,{icon: 2});
                            $("#saveBtn").removeClass("layui-btn-disabled");
                            $("#saveBtn").removeAttr('disabled');
                        }
                    },
                    error:function (data) {
                        layer.msg(res.message,{icon: 2});
                        $("#saveBtn").removeClass("layui-btn-disabled");
                        $("#saveBtn").removeAttr('disabled');
                    }
                });
            });
        });
    </script>
@endsection