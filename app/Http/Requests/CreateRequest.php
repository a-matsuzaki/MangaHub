<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateRequest クラス
 *
 * 新規作成時のリクエストバリデーションルールを提供するためのクラス。
 *
 */
class CreateRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを行うことを許可するかどうかを判定する。
     *
     * @return bool ユーザーがこのリクエストを行うことを許可する場合は true、そうでない場合は false。
     */
    public function authorize(): bool
    {
        // すべてのユーザーがこのリクエストを行うことを許可している。
        return true;
    }

    /**
     * リクエストに適用するバリデーションルールを取得する。
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string> バリデーションルールのリスト。
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',             // タイトルは必須、文字列型、最大255文字。
            'start_volume_add' => 'nullable|integer|min:1',   // 開始巻数は整数型、最小値1。指定されていない場合はnull。
            'end_volume_add' => 'nullable|integer|min:1|gte:start_volume_add',  // 終了巻数は整数型、最小値1、開始巻数以上。指定されていない場合はnull。
            'author' => 'nullable|string|max:255',            // 作者名は文字列型、最大255文字。指定されていない場合はnull。
            'publication' => 'nullable|string|max:255',       // 出版情報は文字列型、最大255文字。指定されていない場合はnull。
            'note' => 'nullable|string|max:1000',             // メモは文字列型、最大1000文字。指定されていない場合はnull。
        ];
    }

    /**
     * バリデーションのためのデータを準備する。
     *
     * このメソッドは、リクエスト入力を整形するために使用されます。
     * 例：全角数字を半角数字に変換
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // 全角数字を半角数字に変換し、リクエストデータをマージする。
        $this->merge([
            'start_volume_add' => $this->input('start_volume_add')
                ? (int)mb_convert_kana($this->input('start_volume_add'), 'n')  // 開始巻数の全角数字を半角に変換
                : null,
            'end_volume_add' => $this->input('end_volume_add')
                ? (int)mb_convert_kana($this->input('end_volume_add'), 'n')    // 終了巻数の全角数字を半角に変換
                : ($this->input('start_volume_add') ? (int)mb_convert_kana($this->input('start_volume_add'), 'n') : null), // 終了巻数が指定されていない場合、開始巻数を設定する
        ]);
    }
}
