<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>
    </header>

    <div class="mt-4">
        <x-primary-button onclick="location.href='{{ route('password.request') }}'">
            {{ __('パスワードを更新する') }}
        </x-primary-button>
    </div>

</section>
