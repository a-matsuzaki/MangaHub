<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <!-- ソーシャルログイン -->
  <div class="max-w-md mx-auto mt-10">
    <div class="mb-6">
      <!-- Googleログインボタン -->
      <a href="/login/google" class="w-full bg-white border border-gray-200 shadow-sm text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mb-4 hover:shadow-md">
        <img src="images/google_btn_base.png" alt="Google" class="mr-6">
        Googleで新規登録/ログインする
      </a>
    </div>

    <div class="my-6">
      <p class="text-center text-gray-600">または</p>
    </div>

    <!-- メールアドレスでのログイン -->
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- メールアドレス -->
      <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- パスワード -->
      <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- 認証情報の記憶 -->
      <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
          <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
          <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
        @endif

        <x-primary-button class="ml-3">
          {{ __('Log in') }}
        </x-primary-button>
      </div>
    </form>
    <div class="mt-6 text-center">
      <a href="/register" class="text-sm text-blue-500 hover:text-blue-700">メールアドレスでの新規登録はこちら</a>
    </div>
  </div>
</x-guest-layout>
