<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="px-4 pb-4 sm:px-0">
                            <h2 class="text-xl font-extrabold leading-7 text-gray-900">{{ $seriesDetail->title }}</h2>
                        </div>
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="p-1.5 min-w-full inline-block align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                <tr>
                                                    <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                        <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">タイトル</span>
                                                        <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                            <input type="text" name="title" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                        <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">巻の追加/削除</span>
                                                        <div class="col-span-9 flex gap-2">
                                                            <input type="text" name="start_volume" placeholder="開始巻" class="text-sm px-2 py-1 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            <span class="text-sm self-center">～</span>
                                                            <input type="text" name="end_volume" placeholder="終了巻" class="text-sm px-2 py-1 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            <button type="submit" name="action" value="add" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">購入</button>
                                                            <button type="submit" name="action" value="delete" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">削除</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                        <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">著者</span>
                                                        <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                            <input type="text" name="publication" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                        <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">出版社</span>
                                                        <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                            <input type="text" name="title" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                        <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">メモ</span>
                                                        <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                            <div class="mt-2">
                                                                <textarea id="note" name="note" rows="5" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"></textarea>
                                                            </div>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 flex justify-center space-x-4">
                        <button onclick="history.back()" type="button" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-gray-500 text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all text-sm dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800">戻る</button>
                        <button onclick="location.href='/mangahub/edit/{{ $seriesDetail->id }}'" type="button" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">編集</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
