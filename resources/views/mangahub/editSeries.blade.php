<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form class="w-full" action="{{ route('mangahub.updateSeries') }}" method="post">
                    @csrf
                    @method('PATCH')
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
                                                    <input type="hidden" name="id" value="{{ $seriesDetail->id }}">
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">タイトル</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="text" name="title" value="{{ $seriesDetail->title }}" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">巻の追加</span>
                                                            <div class="col-span-9 flex gap-2">
                                                                <input type="text" name="start_volume_add" placeholder="開始巻" class="text-sm px-2 py-1 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                                <span class="text-sm self-center">～</span>
                                                                <input type="text" name="end_volume_add" placeholder="終了巻" class="text-sm px-2 py-1 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">巻の削除</span>
                                                            <div class="col-span-9 flex gap-2">
                                                                <input type="text" name="start_volume_remove" placeholder="開始巻" class="text-sm px-2 py-1 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                                <span class="text-sm self-center">～</span>
                                                                <input type="text" name="end_volume_remove" placeholder="終了巻" class="text-sm px-2 py-1 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">所有巻数</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">{!! $seriesDetail->owned_volumes_display !!}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">持っていない巻数</span>
                                                            <span class="col-span-9 text-sm text-red-500 dark:text-gray-200">{!! $seriesDetail->not_owned_volumes_display !!}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">著者</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="text" name="author" value="{{ $seriesDetail->author }}" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">出版社</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="text" name="publication" value="{{ $seriesDetail->publication }}" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">メモ</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <div class="mt-2">
                                                                    <textarea id="note" name="note" rows="5" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">{{ $seriesDetail->note }}</textarea>
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
                            <button type="submit" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">変更</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
