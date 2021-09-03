<?php
// @author liming
namespace Modules\Sheet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Sheet\Http\Controllers\Controller;
use Modules\Sheet\Http\Requests\Admin\SenderSettingRequest;
use Modules\Sheet\Entities\Area;

class SenderController extends Controller
{
    /**
     * 设置发件人信息
     * // province city exp_area
     */
    public function setting(SenderSettingRequest $request)
    {
        if($request->isMethod("post")){
            $request->check();
            $data = $request->input();
            if(!file_exists(module_path('Sheet', '/Config/sender.php'))){
                return $this->failed('配置文件不存在');
            }else{
                $myfile = fopen(module_path('Sheet', '/Config/sender.php'), "w");
                fwrite($myfile, "<?php");
                fwrite($myfile, "\n");
                fwrite($myfile, "return [");
                fwrite($myfile, "\n");

                foreach ($data as $field => $val){
                    fwrite($myfile, '  "'.$field.'" => "'.$val.'",');
                    fwrite($myfile, "\n");
                }

                fwrite($myfile, "];");
                fwrite($myfile, "\n");
            }
            fclose($myfile);
            return $this->success();
        } else {
            $title = "设置公共发件人信息";
            $info = config("sheetsender");
            $areaList = Area::where("level", "province")->orderBy("id")->get()->toArray();
            foreach ($areaList as &$item){
                $item["children"] = Area::where("parent_id", $item["id"])->orderBy("id")->get()->toArray();
                foreach ($item["children"] as &$city){
                    $city["children"] = Area::where("parent_id", $city["id"])->orderBy("id")->get()->toArray();
                }
            }
            return view('sheetview::admin.sender.setting', compact("title", "info", "areaList"));
        }
    }

}
