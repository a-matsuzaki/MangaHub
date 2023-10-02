<x-app-layout>
    @if(session('status'))
    <x-ui.flash-message message="{{ session('status') }}"></x-ui.flash-message>
    @endif

    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="m-5">
                    <form action="{{ route('mangahub') }}" method="GET">
                        <div class="flex flex-col sm:flex-row">
                            <!-- タイトル -->
                            <div class="p-2 flex-1">
                                <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                                <input type="text" name="title" id="title" value="{{ $title }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <!-- 著者 -->
                            <div class="p-2 flex-1">
                                <label for="author" class="block text-sm font-medium text-gray-700">著者</label>
                                <select id="author" name="author" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">--</option>
                                    @foreach($authors as $option)
                                    <option value="{{ $option }}" @if($author==$option) selected @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- 出版 -->
                            <div class="p-2 flex-1">
                                <label for="publication" class="block text-sm font-medium text-gray-700">出版</label>
                                <select id="publication" name="publication" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">--</option>
                                    @foreach($publications as $option)
                                    <option value="{{ $option }}" @if($publication==$option) selected @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- メモ -->
                            <div class="p-2 flex-1">
                                <label for="note" class="block text-sm font-medium text-gray-700">メモ</label>
                                <input type="text" name="note" id="note" value="{{ $note }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        <!-- 検索ボタン -->
                        <div class="p-2">
                            <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">検索</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">買い忘れ</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">所有巻数</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">著者</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">出版社</th>
                                        <th scope="col" class="py-3"></th>
                                        <th scope="col" class="py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($allSeries as $series)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $series->title }}</td>
                                        <td class="px-6 py-4 text-sm text-red-500 dark:text-gray-200">{!! $series->not_owned_volumes_display !!}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{!! $series->owned_volumes_display !!}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $series->author }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $series->publication }}</td>
                                        <td class="py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button onclick="location.href='/detail/{{ $series->id }}'" type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-gray-500 text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all text-sm dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800">詳細</button>
                                        </td>
                                        <td class="py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button onclick="location.href='/editSeries/{{ $series->id }}'" type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">編集</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $allSeries->links() }}
                        </div>

                        <!-- モバイルビュー: カードスタイル -->
                        <div class="sm:hidden">
                            <p class="mb-4 text-sm text-red-500 dark:text-gray-200">※ 赤文字は未購入の巻数です</p>
                            <div class="max-h-500 overflow-y-auto">
                                @foreach($allSeries as $series)
                                <div class="border-b hover:bg-gray-100 dark:hover:bg-gray-700 p-4 mb-4">
                                    <h3 class="font-bold mb-2">{{ $series->title }}</h3>
                                    <div class="text-red-500 dark:text-gray-200 mb-1">{!! $series->not_owned_volumes_display !!}</div>
                                    <div class="mb-1">{!! $series->owned_volumes_display !!}</div>
                                    <div class="mb-1">{{ $series->author }}</div>
                                    <div class="mb-2">{{ $series->publication }}</div>
                                    <div class="mt-2">
                                        <button onclick="location.href='/detail/{{ $series->id }}'" type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-gray-500 text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all text-sm dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800">詳細</button>
                                        <button onclick="location.href='/editSeries/{{ $series->id }}'" type="button" class="ml-2 py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">編集</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{ $allSeries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
