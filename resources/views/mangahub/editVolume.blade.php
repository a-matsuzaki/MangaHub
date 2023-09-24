<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <form class="w-full" action="{{ route('mangahub.updateVolume') }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="p-6 text-gray-900">
                        <div>
                            <div class="px-4 pb-4 sm:px-0">
                                <h2 class="text-xl font-extrabold leading-7 text-gray-900">{{ $seriesDetail->title }} 第{{ $volumeDetail->volume }}巻</h2>
                            </div>
                            <div class="flex flex-col">
                                <div class="-m-1.5 overflow-x-auto">
                                    <div class="p-1.5 min-w-full inline-block align-middle">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    <input type="hidden" name="id" value="{{ $volumeDetail->id }}">
                                                    <tr x-data="{ isOwned: {{ $volumeDetail->is_owned }} }">
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">所有</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="radio" name="is_owned" value="1" x-model="isOwned">
                                                                <label>持っている</label>
                                                                <input type="radio" name="is_owned" value="0" x-model="isOwned">
                                                                <label>持っていない</label>
                                                                <input type="hidden" name="is_owned" x-bind:value="isOwned">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr x-data="{ isRead: {{ $volumeDetail->is_read }} }">
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">既読</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="checkbox" x-bind:checked="isRead == 1" x-on:change="isRead = $event.target.checked ? 1 : 0">
                                                                <label>既読</label>
                                                                <input type="hidden" name="is_read" x-bind:value="isRead">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr x-data="{ wantsToBuy: {{ $volumeDetail->wants_to_buy }} }">
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">買いたい</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="checkbox" x-bind:checked="wantsToBuy == 1" x-on:change="wantsToBuy = $event.target.checked ? 1 : 0">
                                                                <label>買いたい</label>
                                                                <input type="hidden" name="wants_to_buy" x-bind:value="wantsToBuy">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr x-data="{ wantsToRead: {{ $volumeDetail->wants_to_read }} }">
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">読みたい</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <input type="checkbox" x-bind:checked="wantsToRead == 1" x-on:change="wantsToRead = $event.target.checked ? 1 : 0">
                                                                <label>読みたい</label>
                                                                <input type="hidden" name="wants_to_read" x-bind:value="wantsToRead">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="grid grid-cols-12 px-6 py-4 items-center">
                                                            <span class="col-span-3 text-sm font-medium text-gray-800 dark:text-gray-200">メモ</span>
                                                            <span class="col-span-9 text-sm text-gray-800 dark:text-gray-200">
                                                                <div class="mt-2">
                                                                    <textarea id="note" name="note" rows="5" class="py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">{{ $volumeDetail->note }}</textarea>
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
                <div class="absolute bottom-10 right-0">
                    <form action="/mangahub/remove/{{ $volumeDetail->id }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="mr-4 py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
