<?php

namespace App\Http\Controllers;

use App\Models\MangaSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MangahubController extends Controller
{
    public function index()
    {
        // データベースから全ての漫画シリーズとそれに関連する漫画ボリュームを取得
        $allSeries = MangaSeries::with('mangaVolumes')->paginate(3);

        // 各シリーズに対して処理を行う
        foreach ($allSeries as $currentSeries) {
            // 所有している巻の表示をセット
            $this->setVolumeDisplay($currentSeries, true);
            // 所有していない巻の表示をセット
            $this->setVolumeDisplay($currentSeries, false);
        }

        // 'mangahub.index'ビューを表示し、シリーズデータをビューに渡す
        return view('mangahub.index', ['allSeries' => $allSeries]);
    }

    /**
     * シリーズに対して所有ステータスに基づいてボリュームの表示をセットする
     *
     * @param MangaSeries $currentSeries
     * @param bool $isOwned 所有しているかどうか
     */
    private function setVolumeDisplay($currentSeries, $isOwned)
    {
        // 所有ステータスに基づいてボリュームを取得
        $volumes = $currentSeries->mangaVolumes->where('is_owned', $isOwned)->pluck('volume')->sort()->values();

        // 表示属性をセット
        $displayAttribute = $isOwned ? 'owned_volumes_display' : 'not_owned_volumes_display';
        $currentSeries->$displayAttribute = $this->getVolumeRanges($volumes);
    }

    /**
     * 与えられたボリュームのコレクションを範囲の文字列表現に変換する
     *
     * @param Collection $volumes 巻数のコレクション
     * @return string 連続する巻数の範囲を表す文字列
     */
    private function getVolumeRanges(Collection $volumes): string
    {
        // 与えられた巻数が空の場合は空の文字列を返す
        if ($volumes->isEmpty()) {
            return '';
        }

        // 範囲を保存する配列を初期化
        $ranges = [];

        // 現在の範囲の開始と終了を初期化
        $start = $end = $volumes[0];

        // 各巻数に対して
        for ($i = 1; $i < $volumes->count(); $i++) {
            // 次の巻が現在の終端と連続していれば終端を更新
            if ($volumes[$i] - $end == 1) {
                $end = $volumes[$i];
            } else {
                // 連続していない場合は、現在の範囲を保存し、新しい範囲を開始
                $ranges[] = ($start == $end) ? $start : "$start-$end";
                $start = $end = $volumes[$i];
            }
        }

        // 最後の範囲を保存
        $ranges[] = ($start == $end) ? $start : "$start-$end";

        // 範囲の配列をカンマ区切りの文字列として結合して返す
        return implode(', ', $ranges);
    }
}
