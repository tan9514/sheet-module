<?php

namespace Modules\Sheet\Http\Requests\Admin;

use Modules\Sheet\Http\Requests\BaseRequest;

class SenderSettingRequest extends BaseRequest
{
    /**
     * 判断用户是否有请求权限
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 获取规则
     * @return string[]
     */
    public function newRules()
    {
        return [
            'company' => 'required|string|min:1',
            'name' => 'required|string|min:1',
            'tel' => 'required|string|min:1',
            'mobile' => 'required|string|min:1',
            'post_code' => 'required|string|min:1',
            'province' => 'required|string|min:1',
            'city' => 'required|string|min:1',
            'exp_area' => 'required|string|min:1',
            'address' => 'required|string|min:1',
        ];
    }

    /**
     * 获取自定义验证规则的错误消息
     * @return array
     */
    public function messages()
    {
        return [
//            'phone.regex' => "请输入正确的 :attribute",
        ];
    }

    /**
     * 获取自定义参数别名
     * @return string[]
     */
    public function attributes()
    {
        return [
            "company" => "发件人公司",
            "name" => "发件人名称",
            "tel" => "发件人电话",
            "mobile" => "发件人手机",
            "post_code" => "发件人邮编",
            "province" => "省",
            "city" => "市",
            "exp_area" => "县/区",
            "address" => "详细地址",
        ];
    }

    /**
     * 验证规则
     */
    public function check()
    {
        $validator = \Validator::make($this->all(), $this->newRules(), $this->messages(), $this->attributes());
        $error = $validator->errors()->first();
        if($error){
            return $this->resultErrorAjax($error);
        }
    }
}
