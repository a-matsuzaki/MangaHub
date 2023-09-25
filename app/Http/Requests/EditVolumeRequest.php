<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * EditVolumeRequest クラス
 *
 * 個別の巻の編集時のリクエストバリデーションルールを提供するためのクラス。
 *
 */
class EditVolumeRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを行うことを許可するかどうかを判定する。
     *
     * @return bool ユーザーがこのリクエストを行うことを許可する場合は true、そうでない場合は false。
     */
    public function authorize(): bool
    {
        // このサンプルでは、すべてのユーザーがこのリクエストを行うことを許可している。
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
            'note' => 'nullable|string|max:1000',        // メモは文字列型、最大1000文字。指定されていない場合はnull。
            'is_owned' => 'required|in:0,1',             // 所有しているかどうかを示すフラグ。0または1の値のみ受け入れる。
            'is_read' => 'required|in:0,1',              // 読了しているかどうかを示すフラグ。0または1の値のみ受け入れる。
            'wants_to_buy' => 'required|in:0,1',         // 購入を希望しているかどうかを示すフラグ。0または1の値のみ受け入れる。
            'wants_to_read' => 'required|in:0,1',        // 読むことを希望しているかどうかを示すフラグ。0または1の値のみ受け入れる。
        ];
    }
}
