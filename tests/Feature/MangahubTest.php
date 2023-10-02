<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MangaSeries;
use App\Models\MangaVolume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MangaHubTest extends TestCase
{
    use RefreshDatabase; // テスト実行時にデータベースをリセット

    /**
     * 認証済みユーザーがindexページにアクセスできるかのテスト
     *
     * 1. テスト用のユーザーを作成
     * 2. そのユーザーとしてindexページにアクセス
     * 3. ステータスコード200が返されるか確認
     */
    public function test_authenticated_user_can_access_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    /**
     * 認証済みユーザーがdetailページにアクセスできるかのテスト
     *
     * 1. テスト用のユーザーとマンガシリーズを作成
     * 2. そのユーザーとして該当のマンガシリーズのdetailページにアクセス
     * 3. ステータスコード200が返されるか確認
     */
    public function test_authenticated_user_can_access_detail()
    {
        $user = User::factory()->create();
        $manga = MangaSeries::factory()->create();
        $response = $this->actingAs($user)->get("/detail/{$manga->id}");
        $response->assertStatus(200);
    }

    /**
     * 認証済みユーザーがeditSeriesページにアクセスできるかのテスト
     *
     * 1. テスト用のユーザーとマンガシリーズを作成
     * 2. そのユーザーとして該当のマンガシリーズのeditページにアクセス
     * 3. ステータスコード200が返されるか確認
     */
    public function test_authenticated_user_can_access_editSeries()
    {
        $user = User::factory()->create();
        $manga = MangaSeries::factory()->create();
        $response = $this->actingAs($user)->get("/editSeries/{$manga->id}");
        $response->assertStatus(200);
    }

    /**
     * 認証済みユーザーがeditVolumeページにアクセスできるかのテスト
     *
     * 1. テスト用のユーザーとマンガの巻を作成
     * 2. そのユーザーとして該当のマンガの巻のeditページにアクセス
     * 3. ステータスコード200が返されるか確認
     */
    public function test_authenticated_user_can_access_editVolume()
    {
        $user = User::factory()->create();
        MangaSeries::factory()->create();
        $volume = MangaVolume::factory()->create();
        $response = $this->actingAs($user)->get("/editVolume/{$volume->id}");
        $response->assertStatus(200);
    }

    /**
     * 認証済みユーザーがnewページにアクセスできるかのテスト
     *
     * 1. テスト用のユーザーを作成
     * 2. そのユーザーとしてnewページにアクセス
     * 3. ステータスコード200が返されるか確認
     */
    public function test_authenticated_user_can_access_new()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get("/new");
        $response->assertStatus(200);
    }

    /**
     * ゲストがindexページにアクセスすると、ログインページにリダイレクトされるかのテスト
     *
     * 1. ゲストとしてindexページにアクセス
     * 2. ログインページにリダイレクトされるか確認
     */
    public function test_guest_is_redirected_to_login_when_accessing_index()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    /**
     * ゲストがdetailページにアクセスすると、ログインページにリダイレクトされるかのテスト
     *
     * 1. テスト用のマンガシリーズを作成
     * 2. ゲストとして該当のマンガシリーズのdetailページにアクセス
     * 3. ログインページにリダイレクトされるか確認
     */
    public function test_guest_is_redirected_to_login_when_accessing_detail()
    {
        User::factory()->create();
        $manga = MangaSeries::factory()->create();
        $response = $this->get("/detail/{$manga->id}");
        $response->assertRedirect('/login');
    }

    /**
     * ゲストがeditSeriesページにアクセスすると、ログインページにリダイレクトされるかのテスト
     *
     * 1. テスト用のマンガシリーズを作成
     * 2. ゲストとして該当のマンガシリーズのeditページにアクセス
     * 3. ログインページにリダイレクトされるか確認
     */
    public function test_guest_is_redirected_to_login_when_accessing_editSeries()
    {
        User::factory()->create();
        $manga = MangaSeries::factory()->create();
        $response = $this->get("/editSeries/{$manga->id}");
        $response->assertRedirect('/login');
    }

    /**
     * ゲストがeditVolumeページにアクセスすると、ログインページにリダイレクトされるかのテスト
     *
     * 1. テスト用のマンガの巻を作成
     * 2. ゲストとして該当のマンガの巻のeditページにアクセス
     * 3. ログインページにリダイレクトされるか確認
     */
    public function test_guest_is_redirected_to_login_when_accessing_editVolume()
    {
        User::factory()->create();
        MangaSeries::factory()->create();
        $volume = MangaVolume::factory()->create();
        $response = $this->get("/editVolume/{$volume->id}");
        $response->assertRedirect('/login');
    }

    /**
     * ゲストがnewページにアクセスすると、ログインページにリダイレクトされるかのテスト
     *
     * 1. ゲストとしてnewページにアクセス
     * 2. ログインページにリダイレクトされるか確認
     */
    public function test_guest_is_redirected_to_login_when_accessing_new()
    {
        $response = $this->get("/new");
        $response->assertRedirect('/login');
    }

    /**
     * 認証済みユーザーが無効なIDで詳細ページにアクセスした場合、404エラーが返されるかのテスト
     *
     * 1. 認証ユーザーを作成し、ログイン状態にする
     * 2. 無効なIDを指定して詳細ページにアクセス
     * 3. 404エラーが返されるか確認
     */
    public function test_authenticated_user_gets_404_when_accessing_detail_with_invalid_id()
    {
        $user = User::factory()->create();
        $invalidId = MangaSeries::max('id') + 1;

        $response = $this->actingAs($user)->get("/detail/{$invalidId}");
        $response->assertStatus(404);
    }


    /**
     * 認証済みユーザーが無効なIDで巻数ページにアクセスした場合、404エラーが返されるかのテスト
     *
     * 1. 認証ユーザーを作成し、ログイン状態にする
     * 2. 無効なIDを指定して巻数ページにアクセス
     * 3. 404エラーが返されるか確認
     */
    public function test_authenticated_user_gets_404_when_accessing_volume_with_invalid_id()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get("/volume/999999");  // 高確率で存在しないID
        $response->assertStatus(404);
    }

    /**
     * 認証済みユーザーが最小のIDを使用して、詳細ページにアクセスできるかのテスト
     *
     * 1. 認証ユーザーを作成し、ログイン状態にする
     * 2. 最小のIDを持つマンガシリーズを取得
     * 3. 該当のIDを使用して詳細ページにアクセス
     * 4. 正常にアクセスできるか確認
     */
    public function test_authenticated_user_can_access_detail_with_min_id()
    {
        // Userのデータを事前に作成
        User::factory()->count(5)->create();

        // MangaSeriesのデータを事前に作成
        MangaSeries::factory()->count(5)->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $minId = MangaSeries::min('id');
        $response = $this->get("/detail/{$minId}");
        $response->assertOk();
    }
}
