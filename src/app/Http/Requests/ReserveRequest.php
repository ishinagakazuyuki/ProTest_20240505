<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ReserveRequest extends FormRequest
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
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'number' => 'required|numeric',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = $this->input('date');
            $time = $this->input('time');

            // time フィールドが設定されている場合のみ Carbon インスタンスを生成
            if ($time !== null) {
                try {
                    $dateTime = Carbon::createFromFormat('Y-m-d H:i', "$date $time");

                    // 現在時刻との比較を行う条件
                    if ($dateTime->isPast()) {
                        $validator->errors()->add('date', '選択した日付と時刻は未来のものである必要があります。');
                    }
                } catch (\Exception $e) {
                    // 例外が発生した場合は何もしないか、エラーを追加するなど適切な対応を行う
                }
            }
        });
    }
}
