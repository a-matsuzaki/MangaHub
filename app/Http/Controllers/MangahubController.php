<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Http\Requests\EditSeriesRequest;
use App\Http\Requests\EditVolumeRequest;
use App\Models\MangaSeries;
use App\Models\MangaVolume;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MangahubController extends Controller
{
    /**
     * マンガシリーズのインデックスページを表示します。
     * 与えられたリクエストパラメータを使用して、マンガシリーズのリストをフィルタリングおよびページングします。
     *
     * @param  Request $request リクエストオブジェクト
     * @return \Illuminate\View\View マンガシリーズのインデックスビュー
     */
    public function index(Request $request)
    {
        // リクエストからすべての入力を取得
        $input = $request->all();

        // MangaSeriesモデルと関連するmangaVolumesを取得するクエリの準備
        $query = MangaSeries::with('mangaVolumes');

        // タイトルでの検索条件を追加
        if (isset($input['title']) && !empty($input['title'])) {
            $query->where('title', 'LIKE', '%' . $input['title'] . '%');
        }

        // 作者での検索条件を追加
        if (isset($input['author']) && !empty($input['author'])) {
            $query->where('author', $input['author']);
        }

        // 出版社での検索条件を追加
        if (isset($input['publication']) && !empty($input['publication'])) {
            $query->where('publication', $input['publication']);
        }

        // ノートでの検索条件を追加
        if (isset($input['note']) && !empty($input['note'])) {
            $query->where('note', 'LIKE', '%' . $input['note'] . '%');
        }

        // IDの降順でシリーズを取得し、ページネーションを10項目で適用
        $allSeries = $query->orderBy('id', 'desc')->paginate(10);

        // 各シリーズに対して、ボリュームの表示を設定
        foreach ($allSeries as $currentSeries) {
            $this->setVolumeDisplay($currentSeries, true);
            $this->setVolumeDisplay($currentSeries, false);
        }

        // タイトル、出版社、および作者の一覧を取得
        $titles = MangaSeries::select('title')->groupBy('title')->pluck('title');
        $publications = MangaSeries::select('publication')->groupBy('publication')->pluck('publication');
        $authors = MangaSeries::select('author')->groupBy('author')->pluck('author');

        // ビューを返す際に変数を渡す
        return view('mangahub.index', [
            'allSeries' => $allSeries,
            'titles' => $titles,
            'publications' => $publications,
            'authors' => $authors,
            'title' => $input['title'] ?? '',
            'publication' => $input['publication'] ?? '',
            'author' => $input['author'] ?? '',
            'note' => $input['note'] ?? '',
        ]);
    }

    /**
     * 指定されたIDに基づいてマンガシリーズの詳細ページを表示します。
     *
     * @param  int $id 表示するマンガシリーズのID
     * @return \Illuminate\View\View マンガシリーズの詳細ビュー
     */
    public function detail($id)
    {
        // 指定されたIDを持つマンガシリーズを取得。
        // 存在しない場合は、404エラーを返す。
        $seriesDetail = MangaSeries::findOrFail($id);

        // 全巻データを一旦取得
        $seriesDetail->mangaVolumes = $seriesDetail->mangaVolumes()->get();

        // 取得したマンガシリーズの巻数表示を設定
        $this->setVolumeDisplay($seriesDetail, true);
        $this->setVolumeDisplay($seriesDetail, false);

        // mangaVolumesリレーションにページネーションを適用
        // こちらの$paginatedVolumesはビューでページネーション表示に使うためのもの
        $paginatedVolumes = $seriesDetail->mangaVolumes()->paginate(10);

        // マンガシリーズの詳細ビューを返す。ビューにシリーズの詳細データとページネートされた巻数を渡す。
        return view('mangahub.detail', [
            'seriesDetail' => $seriesDetail,
            'paginatedVolumes' => $paginatedVolumes
        ]);
    }


    /**
     * 指定されたIDに基づいてマンガシリーズの編集ページを表示します。
     *
     * @param  int $id 編集するマンガシリーズのID
     * @return \Illuminate\View\View マンガシリーズの編集ビュー
     */
    public function editSeries($id)
    {
        // 指定されたIDを持つマンガシリーズを取得。
        // 存在しない場合は、404エラーを返す。
        $seriesDetail = MangaSeries::findOrFail($id);

        // 全巻データを一旦取得
        $seriesDetail->mangaVolumes = $seriesDetail->mangaVolumes()->get();

        // 取得したマンガシリーズの巻数表示を設定
        $this->setVolumeDisplay($seriesDetail, true);
        $this->setVolumeDisplay($seriesDetail, false);

        // mangaVolumesリレーションにページネーションを適用
        // こちらの$paginatedVolumesはビューでページネーション表示に使うためのもの
        $paginatedVolumes = $seriesDetail->mangaVolumes()->paginate(10);

        // マンガシリーズの詳細ビューを返す。ビューにシリーズの詳細データとページネートされた巻数を渡す。
        return view('mangahub.editSeries', [
            'seriesDetail' => $seriesDetail,
            'paginatedVolumes' => $paginatedVolumes
        ]);
    }

    /**
     * 指定されたIDに基づいてマンガの巻の編集ページを表示します。
     *
     * @param  int $volumeId 編集するマンガの巻のID
     * @return \Illuminate\View\View マンガの巻の編集ビュー
     */
    public function editVolume($volumeId)
    {
        // 指定されたIDを持つマンガの巻と、それに関連するmangaSeriesを取得。
        // 存在しない場合は、404エラーを返す。
        $volumeDetail = MangaVolume::with('mangaSeries')->findOrFail($volumeId);

        // マンガの巻の編集ビューを返す。ビューに巻の詳細と関連するマンガシリーズのデータを渡す。
        return view('mangahub.editVolume', [
            'volumeDetail' => $volumeDetail,
            'seriesDetail' => $volumeDetail->mangaSeries
        ]);
    }

    /**
     * マンガシリーズの情報を更新します。
     *
     * @param  EditSeriesRequest $request 更新のためのリクエストデータ
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンス
     */
    public function updateSeries(EditSeriesRequest $request)
    {
        try {
            // データベースのトランザクションを開始
            DB::beginTransaction();

            // リクエストからシリーズIDを取得し、該当するマンガシリーズを検索
            $seriesDetail = MangaSeries::findOrFail($request->input('id'));

            // リクエストから取得したデータでマンガシリーズの情報を更新
            $seriesDetail->title = $request->input('title');
            $seriesDetail->author = $request->input('author');
            $seriesDetail->publication = $request->input('publication');
            $seriesDetail->note = $request->input('note');
            $seriesDetail->save();

            // 追加する巻数の開始と終了の番号を取得
            $startVolumeAdd = (int)$request->input('start_volume_add');
            $endVolumeAdd = $request->input('end_volume_add') ? (int)$request->input('end_volume_add') : $startVolumeAdd;

            if ($startVolumeAdd > 0 && $endVolumeAdd >= $startVolumeAdd) {
                $allVolumes = range(1, $endVolumeAdd); // 1巻から最終巻までの範囲

                foreach ($allVolumes as $volume) {
                    $existingVolume = $seriesDetail->mangaVolumes()->where('volume', $volume)->first();

                    if ($volume >= $startVolumeAdd) { // ユーザーが持っている範囲内
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
                    } else { // ユーザーが持っていない範囲内
                        if (!$existingVolume) {
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
            }

            // 削除する巻数の開始と終了の番号を取得
            $startVolumeRemove = (int)$request->input('start_volume_remove');
            $endVolumeRemove = $request->input('end_volume_remove') ? (int)$request->input('end_volume_remove') : $startVolumeRemove;

            // 0巻の削除を防ぐためのチェック
            if ($startVolumeRemove > 0 && $endVolumeRemove >= $startVolumeRemove) {
                $volumesToRemove = range($startVolumeRemove, $endVolumeRemove);

                // 指定された巻数を削除するための処理
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

            // トランザクションをコミットしてデータベースの変更を保存
            DB::commit();
            return redirect('/')->with('status', '更新が完了しました。');
        } catch (\Exception $ex) {
            // 何らかのエラーが発生した場合、変更をロールバック
            DB::rollback();

            // エラーログを記録
            logger($ex->getMessage());

            // エラーメッセージを持ってリダイレクト
            return redirect('/')->withErrors($ex->getMessage());
        }
    }

    /**
     * マンガの巻の情報を更新します。
     *
     * @param  EditVolumeRequest $request 更新のためのリクエストデータ
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンス
     */
    public function updateVolume(EditVolumeRequest $request)
    {
        try {
            // データベースのトランザクションを開始
            DB::beginTransaction();

            // リクエストから提供されたIDを使用して、該当するマンガの巻を検索
            $volume = MangaVolume::findOrFail($request->input('id'));

            // リクエストデータを使用して、マンガの巻の属性を更新
            $volume->is_owned = $request->input('is_owned');
            $volume->is_read = $request->input('is_read');
            $volume->wants_to_buy = $request->input('wants_to_buy');
            $volume->wants_to_read = $request->input('wants_to_read');
            $volume->note = $request->input('note');

            // 更新したマンガの巻の情報をデータベースに保存
            $volume->save();

            // トランザクションをコミットしてデータベースの変更を保存
            DB::commit();

            // 更新完了のステータスを持ってmangahubにリダイレクト
            return redirect('/')->with('status', '更新が完了しました。');
        } catch (\Exception $ex) {
            // 何らかのエラーが発生した場合、変更をロールバック
            DB::rollback();

            // エラーログを記録
            logger($ex->getMessage());

            // エラーメッセージを持ってリダイレクト
            return redirect('/')->withErrors($ex->getMessage());
        }
    }

    /**
     * 新しいマンガ情報の入力フォームを表示する。
     *
     * @return \Illuminate\View\View マンガの新規追加フォームのビュー
     */
    public function new()
    {
        // 'mangahub.new' ビューを返す
        return view('mangahub.new');
    }

    /**
     * 新しいマンガシリーズをデータベースに保存する。
     *
     * @param CreateRequest $request バリデーション済みのリクエストデータ
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンス
     */
    public function create(CreateRequest $request)
    {
        try {
            // トランザクションの開始
            DB::beginTransaction();

            // 入力されたタイトルで既存のシリーズを検索
            $existingSeries = MangaSeries::where('title', $request->input('title'))->first();
            // 既存のシリーズが見つかった場合、例外をスロー
            if ($existingSeries) {
                throw new \Exception('このタイトルの漫画はすでに存在します。');
            }

            // 新しいMangaSeriesインスタンスの作成
            $seriesDetail = new MangaSeries();
            $seriesDetail->user_id = auth()->id(); // 現在のユーザーIDをセット
            $seriesDetail->title = $request->input('title');
            $seriesDetail->author = $request->input('author');
            $seriesDetail->publication = $request->input('publication');
            $seriesDetail->note = $request->input('note');
            // データベースに保存
            $seriesDetail->save();

            // 巻数の追加
            $startVolumeAdd = (int)$request->input('start_volume_add');
            $endVolumeAdd = $request->input('end_volume_add') ? (int)$request->input('end_volume_add') : $startVolumeAdd;

            // 1. $startVolumeAdd から 1 までの巻がデータベースに登録されているか確認
            for ($i = 1; $i < $startVolumeAdd; $i++) {
                $existingVolume = $seriesDetail->mangaVolumes()->where('volume', $i)->first();
                if (!$existingVolume) {
                    // 登録されていない巻は「持っていない」として保存
                    $seriesDetail->mangaVolumes()->create([
                        'user_id' => auth()->id(),
                        'type' => 1,
                        'volume' => $i,
                        'is_owned' => false,
                        'is_read' => false,
                        'wants_to_buy' => false,
                        'wants_to_read' => false,
                    ]);
                }
            }

            // 2. $startVolumeAdd から $endVolumeAdd の間の巻を「持っている」として保存
            for ($i = $startVolumeAdd; $i <= $endVolumeAdd; $i++) {
                $seriesDetail->mangaVolumes()->create([
                    'user_id' => auth()->id(),
                    'type' => 1,
                    'volume' => $i,
                    'is_owned' => true,
                    'is_read' => false,
                    'wants_to_buy' => false,
                    'wants_to_read' => false,
                ]);
            }

            // トランザクションをコミット
            DB::commit();
            // 成功した場合、メッセージとともにリダイレクト
            return redirect('/')->with('status', '新規作成が完了しました。');
        } catch (\Exception $ex) {
            // 例外が発生した場合、トランザクションをロールバック
            DB::rollback();
            // エラーログに例外のメッセージを記録
            logger($ex->getMessage());
            // エラーメッセージとともにリダイレクト
            return redirect('/')->withErrors($ex->getMessage());
        }
    }

    /**
     * 指定されたIDのマンガ巻をデータベースから削除する。
     *
     * @param int $id 削除するマンガ巻のID
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンス
     */
    public function remove($id)
    {
        try {
            // 指定されたIDでマンガ巻を検索
            $volume = MangaVolume::findOrFail($id);
            // マンガ巻をデータベースから削除
            $volume->delete();

            // 削除が成功した場合、メッセージとともにリダイレクト
            return redirect('/')->with('status', '本を削除しました。');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 指定されたIDのマンガ巻が存在しない場合の例外処理
            return redirect('/')->withErrors('指定された本が見つかりませんでした。');
        } catch (\Exception $ex) {
            // その他の例外処理
            logger($ex->getMessage());  // エラーログに例外のメッセージを記録
            return redirect('/')->withErrors($ex->getMessage());
        }
    }

    /**
     * 指定されたシリーズの巻数表示をセットします。
     *
     * この関数は、シリーズ内のマンガの巻数を、所有しているかどうかのステータスに基づいて取得し、
     * 連続する巻数の範囲を文字列としてシリーズの属性にセットします。
     *
     * @param MangaSeries $currentSeries 表示をセットする対象のシリーズオブジェクト
     * @param bool $isOwned 所有しているかどうかのフラグ。trueの場合は所有している巻、falseの場合は所有していない巻を対象とします。
     */
    private function setVolumeDisplay($currentSeries, $isOwned)
    {
        // 所有ステータスに基づき、シリーズに関連するマンガ巻を取得
        // その後、巻の数字を整数として取得し、昇順でソート
        $volumes = $currentSeries->mangaVolumes->where('is_owned', $isOwned)->pluck('volume')
            ->map(function ($volume) {
                return (int)$volume;
            })->sort()->values();

        // 所有状態に基づいて、どの属性名に表示をセットするかを決定
        // 所有している場合は 'owned_volumes_display'、そうでない場合は 'not_owned_volumes_display'
        $displayAttribute = $isOwned ? 'owned_volumes_display' : 'not_owned_volumes_display';

        // 指定した属性名に、巻数の範囲文字列をセット
        // getVolumeRangesは、巻数の配列を受け取り、連続する巻数の範囲を示す文字列を返す
        $currentSeries->$displayAttribute = $this->getVolumeRanges($volumes, $isOwned);
    }

    /**
     * 指定された巻数のリストから、表示用の文字列を生成します。
     *
     * この関数は、指定された巻数のリストを受け取り、
     * 所有状態に応じて連続する巻数の範囲として、または個別の巻数として文字列を生成します。
     *
     * @param Collection $volumes 巻数のリスト。例: [1,2,3,5]
     * @param bool $isOwned 所有しているかどうかのフラグ。trueの場合は巻数の範囲として、falseの場合は個別の巻数として文字列を生成。
     * @return string 表示用の文字列。例: "1-3,5" または "1,2,3,5"
     */
    private function getVolumeRanges(Collection $volumes, bool $isOwned): string
    {
        // 巻数のリストが空の場合、空の文字列を返す
        if ($volumes->isEmpty()) {
            return '';
        };
        // 所有している場合、巻数のリストを連続する巻数の範囲の文字列に変換
        if ($isOwned) {
            return $this->convertToRanges($volumes);
        } else { // 所有していない場合、巻数のリストを個別の巻数の文字列に変換
            return $this->convertToIndividualVolumes($volumes);
        }
    }

    /**
     * 与えられた巻数のリストから、連続する巻数を範囲で表示する関数。
     * 例えば、[1, 2, 3, 5] という巻数のリストが与えられた場合、"1〜3巻<br />5巻" という文字列を返す。
     *
     * @param Collection $volumes 巻数のリスト。例: [1,2,3,5]
     * @return string 範囲で表示された文字列。例: "1〜3巻<br />5巻"
     */
    private function convertToRanges(Collection $volumes): string
    {
        // 巻数のリストが空の場合、空の文字列を返す
        if ($volumes->isEmpty()) {
            return '';
        }

        $ranges = []; // 範囲のリストを保持する配列
        $start = $end = $volumes[0]; // 初期値としてリストの最初の巻数をセット

        // 2番目の巻数から最後の巻数までループ
        for ($i = 1; $i < $volumes->count(); $i++) {
            // 現在の巻数が前の巻数の次の番号である場合、範囲の終端を更新
            if ($volumes[$i] - $end === 1) {
                $end = $volumes[$i];
            } else {
                // 連続していない場合、範囲を$rangesに追加し、新たな範囲の開始点と終端をセット
                $ranges[] = ($start === $end) ? "{$start}巻" : "{$start}〜{$end}巻";
                $start = $end = $volumes[$i];
            }
        }

        // 最後の範囲を$rangesに追加
        $ranges[] = ($start === $end) ? "{$start}巻" : "{$start}〜{$end}巻";

        // $rangesの要素を"<br />"で連結して返す
        return implode('<br />', $ranges);
    }

    /**
     * 与えられた巻数のリストを「巻」という接尾辞を付けて、各巻数を個別に表示する関数。
     * 例えば、[1, 2, 3] という巻数のリストが与えられた場合、"1巻<br />2巻<br />3巻" という文字列を返す。
     *
     * @param Collection $volumes 巻数のリスト。例: [1, 2, 3]
     * @return string 巻ごとに表示された文字列。例: "1巻<br />2巻<br />3巻"
     */
    private function convertToIndividualVolumes(Collection $volumes): string
    {
        // Collectionの各要素に「巻」という接尾辞を付ける
        return $volumes->map(function ($volume) {
            // 各要素に「巻」を追加して返す
            return $volume . '巻';
        })
            // Collectionの要素を"<br />"で連結して返す
            ->implode('<br />');
    }
}
