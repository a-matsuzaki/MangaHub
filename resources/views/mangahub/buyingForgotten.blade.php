<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex flex-col">

            <!-- デスクトップビュー: テーブル形式 -->
            <div class="hidden sm:block">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">タイトル</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">出版社</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                  @foreach($volumes as $volume)
                  <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $volume->mangaSeries->title }}</td>
                    <td class="px-6 py-4 text-sm text-red-500 dark:text-gray-200">{{ $volume->volume }}巻</td>
                    <td class="px-6 py-4 text-sm text-red-500 dark:text-gray-200"></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- モバイルビュー: カードスタイル -->
            <div class="sm:hidden">
              <div class="max-h-500 overflow-y-auto">
                @foreach($volumes as $volume)
                <div class="border-b hover:bg-gray-100 dark:hover:bg-gray-700 p-4 mb-4">
                  <h3 class="font-bold mb-2">{{ $volume->mangaSeries->title }}</h3>
                  <div class="text-red-500 dark:text-gray-200 mb-1">{{ $volume->volume }}巻</div>
                  <div class="text-red-500 dark:text-gray-200 mb-1"></div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
