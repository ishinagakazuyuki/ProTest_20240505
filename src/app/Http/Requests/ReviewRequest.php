<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'shop_review' => 'required|in:1,2,3,4,5',
            'comment' => 'required|string|max:400',
            'image' => 'required|mimes:jpeg,png,jpg'
        ];
    }
    public function messages()
    {
        return [
            'shop_review.required' => '評価を選択してください。',
            'shop_review.in' => '評価は1から5の間で指定してください。',
            'comment.required' => '口コミを入力してください。',
            'comment.max' => '口コミは400文字以内で入力してください。',
            'image.required' => '画像を添付してください。',
            'image.mimes' => 'アップロードする画像はjpegかpngでお願いします'
        ];
    }
}
