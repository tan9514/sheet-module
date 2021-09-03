<?php

namespace Modules\Sheet\Http\Requests\Admin;

use Modules\Sheet\Http\Requests\BaseRequest;

class DeliveryEditRequest extends BaseRequest
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
            'id' => 'nullable|integer|min:1',
            'express_id' => 'required|integer|min:1',
            'customer_name' => 'required|string|min:1|max:255',
            'customer_pwd' => 'required|string|min:1|max:255',
            'month_code' => 'required|string|min:1|max:255',
            'send_site' => 'required|string|min:1|max:255',
            'send_name' => 'required|string|min:1|max:255',
            'company' => 'required|string|min:1|max:255',
            'name' => 'required|string|min:1|max:255',
            'tel' => 'required|string|min:1|max:255',
            'mobile' => 'required|string|min:1|max:255',
            'post_code' => 'required|string|min:1|max:255',
            'province' => 'required|string|min:1|max:255',
            'city' => 'required|string|min:1|max:255',
            'exp_area' => 'required|string|min:1|max:255',
            'address' => 'required|string|min:1|max:255',
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
            'express_id' => '快递公司ID',
            'customer_name' => '电子面单客户账号',
            'customer_pwd' => '电子面单密码',
            'month_code' => '月结编码',
            'send_site' => '网点编码',
            'send_name' => '网点名称',
            'company' => '发件人公司',
            'name' => '发件人名称',
            'tel' => '发件人电话',
            'mobile' => '发件人手机',
            'post_code' => '发件人邮编',
            'province' => '发件人地址-省',
            'city' => '发件人地址-市',
            'exp_area' => '发件人地址-县/区',
            'address' => '详细地址',
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
