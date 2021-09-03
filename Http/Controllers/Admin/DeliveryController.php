<?php
// @author liming
namespace Modules\Sheet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Sheet\Http\Controllers\Controller;
use Modules\Sheet\Http\Requests\Admin\DeliveryEditRequest;
use Modules\Sheet\Entities\Area;
use Modules\Sheet\Entities\Delivery;
use Modules\Sheet\Entities\Express;

class DeliveryController extends Controller
{
    /**
     * 分页列表
     */
    public function list()
    {
        return view('sheetview::admin.delivery.list');
    }

    /**
     * ajax获取列表数据
     */
    public function ajaxList(Request $request)
    {
        $pagesize = $request->input('limit'); // 每页条数
        $page = $request->input('page',1);//当前页
        $where = [];

        //获取总条数
        $count = Delivery::where($where)->count();

        //求偏移量
        $offset = ($page-1)*$pagesize;
        $list = Delivery::where($where)
            ->offset($offset)
            ->limit($pagesize)
            ->orderBy("id", "desc")
            ->get();
        foreach ($list as &$item){
            $express = Express::where("id", $item->express_id)->first();
            $item["express_name"] = $express->name ?? "";
        }
        return $this->success(compact('list', 'count'));
    }

    /**
     * 新增|编辑面单打印设置项
     * @param $id
     */
    public function edit(DeliveryEditRequest $request)
    {
        if($request->isMethod('post')) {
            $request->check();
            $data = $request->post();

            if(isset($data["id"])){
                $info = Delivery::where("id",$data["id"])->first();
                if(!$info) return $this->failed('数据不存在');
            }else{
                $info = new Delivery();
            }

            $info->express_id = $data["express_id"];
            $info->customer_name = $data["customer_name"];
            $info->customer_pwd = $data["customer_pwd"];
            $info->month_code = $data["month_code"];
            $info->send_site = $data["send_site"];
            $info->send_name = $data["send_name"];
            $info->company = $data["company"];
            $info->name = $data["name"];
            $info->tel = $data["tel"];
            $info->mobile = $data["mobile"];
            $info->post_code = $data["post_code"];
            $info->province = $data["province"];
            $info->city = $data["city"];
            $info->exp_area = $data["exp_area"];
            $info->address = $data["address"];
            if(!$info->save()) return $this->failed('操作失败');
            return $this->success();
        } else {
            $id = $request->input('id') ?? 0;
            if($id > 0){
                $info = Delivery::where('id',$id)->first();
                $title = "编辑打印机";
            }else{
                $info = new Delivery();
                $title = "新增快递单设置";
            }
            $express = Express::get();
            $areaList = Area::where("level", "province")->orderBy("id")->get()->toArray();
            foreach ($areaList as &$item){
                $item["children"] = Area::where("parent_id", $item["id"])->orderBy("id")->get()->toArray();
                foreach ($item["children"] as &$city){
                    $city["children"] = Area::where("parent_id", $city["id"])->orderBy("id")->get()->toArray();
                }
            }
            return view('sheetview::admin.delivery.edit', compact('info', 'title', 'express', 'areaList'));
        }
    }

    /**
     * 删除面单打印设置项
     */
    public function del(Request $request)
    {
        if($request->isMethod('post')){
            $id = $request->input('id');
            $info = Delivery::where('id', $id)->first();
            if (!$info) return $this->failed("数据不存在");
            if (!$info->delete()) return $this->failed("操作失败：删除数据失败");
            return $this->success();
        }
        return $this->failed('请求出错.');
    }
}
