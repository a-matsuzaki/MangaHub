<?php

namespace App\Http\Controllers;

use App\Models\MangaSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MangahubController extends Controller
{
    public function index()
    {
        // 全ての漫画シリーズを3つずつページングで取得する
        $allSeries = MangaSeries::with('mangaVolumes')->paginate(3);

        // 各シリーズの巻数表示をセット
        foreach ($allSeries as $currentSeries) {
            $this->setVolumeDisplay($currentSeries, true);
            $this->setVolumeDisplay($currentSeries, false);
        }

        // シリーズ一覧ビューを表示
        return view('mangahub.index', ['allSeries' => $allSeries]);
    }

    public function detail($id)
    {
        // 指定されたIDの漫画シリーズを取得
        $seriesDetail = MangaSeries::with('mangaVolumes')->findOrFail($id);

        // 該当シリーズの巻数表示をセット
        $this->setVolumeDisplay($seriesDetail, true);
        $this->setVolumeDisplay($seriesDetail, false);

        // シリーズ詳細ビューを表示
        return view('mangahub.detail', ['seriesDetail' => $seriesDetail]);
    }

    public function edit($id)
    {
        // 指定されたIDの漫画シリーズを取得
        $seriesDetail = MangaSeries::with('mangaVolumes')->findOrFail($id);

        // 該当シリーズの巻数表示をセット
        $this->setVolumeDisplay($seriesDetail, true);
        $this->setVolumeDisplay($seriesDetail, false);

        // シリーズ詳細ビューを表示
        return view('mangahub.edit', ['seriesDetail' => $seriesDetail]);
    }



    /**
     * 指定されたシリーズの巻数表示をセット
     *
     * @param MangaSeries $currentSeries セットするシリーズ
     * @param bool $isOwned 所有しているかどうか
     */
    private function setVolumeDisplay($currentSeries, $isOwned)
    {
        // 所有ステータスに基づいて巻数を取得
        $volumes = $currentSeries->mangaVolumes->where('is_owned', $isOwned)->pluck('volume')->sort()->values();

        // 表示をセットする属性名を決定
        $displayAttribute = $isOwned ? 'owned_volumes_display' : 'not_owned_volumes_display';
        $currentSeries->$displayAttribute = $this->getVolumeRanges($volumes, $isOwned);
    }

    /**
     * 指定された巻数から表示用の文字列を生成
     *
     * @param Collection $volumes 巻数のリスト
     * @param bool $isOwned 所有しているかどうか
     * @return string 表示用の文字列
     */
    private function getVolumeRanges(Collection $volumes, bool $isOwned): string
    {
        if ($volumes->isEmpty()) {
            return '';
        }

        if ($isOwned) {
            return $this->convertToRanges($volumes);
        } else {
            return $this->convertToIndividualVolumes($volumes);
        }
    }

    /**
     * 連続する巻数を範囲で表示（例: 1-3）
     *
     * @param Collection $volumes 巻数のリスト
     * @return string 範囲で表示された文字列
     */
    private function convertToRanges(Collection $volumes): string
    {
        if ($volumes->isEmpty()) {
            return '';
        }

        $ranges = [];
        $start = $end = $volumes[0];

        for ($i = 1; $i < $volumes->count(); $i++) {
            if ($volumes[$i] - $end == 1) {
                $end = $volumes[$i];
            } else {
                $ranges[] = ($start == $end) ? "{$start}巻" : "{$start}〜{$end}巻";
                $start = $end = $volumes[$i];
            }
        }

        $ranges[] = ($start == $end) ? "{$start}巻" : "{$start}〜{$end}巻";
        return implode('<br />', $ranges);
    }

    /**
     * 各巻数を「巻」として表示（例: 1巻、2巻）
     *
     * @param Collection $volumes 巻数のリスト
     * @return string 巻ごとに表示された文字列
     */
    private function convertToIndividualVolumes(Collection $volumes): string
    {
        return $volumes->map(function ($volume) {
            return $volume . '巻';
        })->implode('<br />');
    }
}
