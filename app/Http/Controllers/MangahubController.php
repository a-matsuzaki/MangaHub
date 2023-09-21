<?php

namespace App\Http\Controllers;

use App\Models\MangaSeries;
use App\Models\MangaVolume;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function editSeries($id)
    {
        // 指定されたIDの漫画シリーズを取得
        $seriesDetail = MangaSeries::with('mangaVolumes')->findOrFail($id);

        // 該当シリーズの巻数表示をセット
        $this->setVolumeDisplay($seriesDetail, true);
        $this->setVolumeDisplay($seriesDetail, false);

        // シリーズ詳細ビューを表示
        return view('mangahub.editSeries', ['seriesDetail' => $seriesDetail]);
    }

    public function editVolume($volumeId)
    {
        // 指定されたIDの漫画の巻を取得
        $volumeDetail = MangaVolume::with('mangaSeries')->findOrFail($volumeId);

        // ビューに複数の変数を渡す
        return view('mangahub.editVolume', [
            'volumeDetail' => $volumeDetail,
            'seriesDetail' => $volumeDetail->mangaSeries
        ]);
    }


    public function updateSeries(Request $request)
    {
        try {
            DB::beginTransaction();

            $seriesDetail = MangaSeries::findOrFail($request->input('id'));
            $seriesDetail->title = $request->input('title');
            $seriesDetail->author = $request->input('author');
            $seriesDetail->publication = $request->input('publication');
            $seriesDetail->note = $request->input('note');
            $seriesDetail->save();

            // 巻数の追加
            $startVolumeAdd = (int)$request->input('start_volume_add');
            $endVolumeAdd = $request->input('end_volume_add') ? (int)$request->input('end_volume_add') : $startVolumeAdd;

            // 0巻を避けるためのチェックを追加
            if ($startVolumeAdd > 0 && $endVolumeAdd >= $startVolumeAdd) {
                $volumesToAdd = range($startVolumeAdd, $endVolumeAdd);

                foreach ($volumesToAdd as $volume) {
                    $existingVolume = $seriesDetail->mangaVolumes()->where('volume', $volume)->first();
                    if ($existingVolume) {
                        $existingVolume->is_owned = true;
                        $existingVolume->save();
                    } else {
                        $seriesDetail->mangaVolumes()->create([
                            'user_id' => auth()->id(),
                            'type' => 1,
                            'volume' => $volume,
                            'is_owned' => true,
                            'is_read' => false,
                            'wants_to_buy' => false,
                            'wants_to_read' => false,
                        ]);
                    }
                }
            }

            // 巻数の削除
            $startVolumeRemove = (int)$request->input('start_volume_remove');
            $endVolumeRemove = $request->input('end_volume_remove') ? (int)$request->input('end_volume_remove') : $startVolumeRemove;
            $volumesToRemove = range($startVolumeRemove, $endVolumeRemove);

            // 0巻を避けるためのチェックを追加
            if ($startVolumeRemove > 0 && $endVolumeRemove >= $startVolumeRemove) {
                $volumesToRemove = range($startVolumeRemove, $endVolumeRemove);

                foreach ($volumesToRemove as $volume) {
                    $existingVolume = $seriesDetail->mangaVolumes()->where('volume', (int)$volume)->first();
                    if ($existingVolume) {
                        $existingVolume->is_owned = false;
                        $existingVolume->save();
                    } else {
                        $seriesDetail->mangaVolumes()->create([
                            'user_id' => auth()->id(),
                            'type' => 1,
                            'volume' => $volume,
                            'is_owned' => false,
                            'is_read' => false,
                            'wants_to_buy' => false,
                            'wants_to_read' => false,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect('mangahub')->with('status', '更新が完了しました。');
        } catch (\Exception $ex) {
            DB::rollback();
            logger($ex->getMessage());
            return redirect('mangahub')->withErrors($ex->getMessage());
        }
    }

    public function updateVolume(Request $request)
    {
        try {
            DB::beginTransaction();

            // 提供されたIDを使ってvolumeを検索
            $volume = MangaVolume::findOrFail($request->input('id'));

            // フォームからの情報でvolumeの属性を更新
            $volume->is_owned = $request->input('is_owned');
            $volume->is_read = $request->input('is_read');
            $volume->wants_to_buy = $request->input('wants_to_buy');
            $volume->wants_to_read = $request->input('wants_to_read');
            $volume->note = $request->input('note');

            $volume->save();

            DB::commit();

            return redirect('mangahub')->with('status', '更新が完了しました。');
        } catch (\Exception $ex) {
            DB::rollback();
            logger($ex->getMessage());
            return redirect('mangahub')->withErrors($ex->getMessage());
        }
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
        $volumes = $currentSeries->mangaVolumes->where('is_owned', $isOwned)->pluck('volume')->map(function ($volume) {
            return (int)$volume;
        })->sort()->values();

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
            if ($volumes[$i] - $end === 1) {
                $end = $volumes[$i];
            } else {
                $ranges[] = ($start === $end) ? "{$start}巻" : "{$start}〜{$end}巻";
                $start = $end = $volumes[$i];
            }
        }

        $ranges[] = ($start === $end) ? "{$start}巻" : "{$start}〜{$end}巻";
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
