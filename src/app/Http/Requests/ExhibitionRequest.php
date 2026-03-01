<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
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
        return [
        'name' => ['required'],
        'description' => ['required', 'max:255'],
        'image_path' => ['required', 'file', 'image', 'mimes:jpeg,png'],
        'categories' => ['required'],
        'condition' => ['required',],
        'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function message()
    {
        return [
        'name.required' => '商品名を入力してください',
        'description.required' => '商品の説明を入力してください',
        'description.max' => '商品名を入力してください',
        'image_path.required' => '画像を選択してください',
        'image_path.mimes' => '画像はjpegまたはpngでアップロードしてください',
        'categories.required' => '商品のカテゴリーをしてください',
        'condition.required' => '商品の状態を選択してください',
        'price.required' => '商品価格を入力してください',
        'price.integer' => '商品価格を数値でしてください',
        'price.min' => '0円以上で入力してください',
        ];
    }
}
