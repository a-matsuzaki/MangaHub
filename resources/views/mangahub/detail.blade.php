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
                                                    <td class="grid grid-cols-10 px-6 py-4">
                                                        <span class="col-span-4 text-sm font-medium text-gray-800 dark:text-gray-200">タイトル</span>
                                                        <span class="col-span-6 text-sm text-gray-800 dark:text-gray-200">{{ $seriesDetail->title }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-10 px-6 py-4">
                                                        <span class="col-span-4 text-sm font-medium text-gray-800 dark:text-gray-200">所有巻数</span>
                                                        <span class="col-span-6 text-sm text-gray-800 dark:text-gray-200">{!! $seriesDetail->owned_volumes_display !!}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-10 px-6 py-4">
                                                        <span class="col-span-4 text-sm font-medium text-gray-800 dark:text-gray-200">持っていない巻数</span>
                                                        <span class="col-span-6 text-sm text-red-500 dark:text-gray-200">{!! $seriesDetail->not_owned_volumes_display !!}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-10 px-6 py-4">
                                                        <span class="col-span-4 text-sm font-medium text-gray-800 dark:text-gray-200">著者</span>
                                                        <span class="col-span-6 text-sm text-gray-800 dark:text-gray-200">{{ $seriesDetail->author }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-10 px-6 py-4">
                                                        <span class="col-span-4 text-sm font-medium text-gray-800 dark:text-gray-200">出版社</span>
                                                        <span class="col-span-6 text-sm text-gray-800 dark:text-gray-200">{{ $seriesDetail->publication }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grid grid-cols-10 px-6 py-4">
                                                        <span class="col-span-4 text-sm font-medium text-gray-800 dark:text-gray-200">メモ</span>
                                                        <span class="col-span-6 text-sm text-gray-800 dark:text-gray-200">{{ $seriesDetail->note }}</span>
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
                        <button onclick="location.href='/mangahub/editSeries/{{ $seriesDetail->id }}'" type="button" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">編集</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="hidden lg:block">
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="p-1.5 min-w-full inline-block align-middle">
                                    <div class="overflow-y-auto max-h-[400px]">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-100 dark:bg-gray-800">
                                                <tr>
                                                    <th scope="col" class="sticky top-0 w-3/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800">巻数</th>
                                                    <th scope="col" class="sticky top-0 w-1/12 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800">所有</th>
                                                    <th scope="col" class="sticky top-0 w-1/12 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800">既読</th>
                                                    <th scope="col" class="sticky top-0 w-1/12 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800">買いたい</th>
                                                    <th scope="col" class="sticky top-0 w-1/12 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800">読みたい</th>
                                                    <th scope="col" class="sticky top-0 w-4/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800">メモ</th>
                                                    <th scope="col" class="sticky top-0 w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100 dark:bg-gray-800"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($seriesDetail->mangaVolumes as $volume)
                                                <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                                                    <td class="w-2/12 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $seriesDetail->title }}第{{ $volume->volume }}巻</td>
                                                    <td class="w-1/12 px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800 dark:text-gray-200">
                                                        @if($volume->is_owned === 1)
                                                        <i class="fa-solid fa-square-check"></i>
                                                        @else
                                                        <i class="fa-regular fa-square"></i>
                                                        @endif
                                                    </td>
                                                    <td class="w-1/12 px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800 dark:text-gray-200">
                                                        @if($volume->is_read === 1)
                                                        <i class="fas fa-star"></i>
                                                        @endif
                                                    </td>
                                                    <td class="w-1/12 px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800 dark:text-gray-200">
                                                        @if($volume->wants_to_buy === 1)
                                                        <i class="fas fa-star"></i>
                                                        @endif
                                                    </td>
                                                    <td class="w-1/12 px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800 dark:text-gray-200">
                                                        @if($volume->wants_to_read === 1)
                                                        <i class="fas fa-star"></i>
                                                        @endif
                                                    </td>
                                                    <td class="w-2/12 px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $volume->note }}</td>
                                                    <td class="w-1/12 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                        <button type="button" onclick="location.href='/mangahub/editVolume/{{ $volume->id }}'" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">編集</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4">
                                        {{ $seriesDetail->mangaVolumes->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:hidden">
                        <div class="overflow-y-auto max-h-[500px]">
                            @foreach($seriesDetail->mangaVolumes as $volume)
                            <div class="bg-white shadow-sm mb-4 p-4 dark:bg-slate-900">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $seriesDetail->title }}第{{ $volume->volume }}巻</div>
                                <div class="mt-2">
                                    <span class="text-gray-500">所有:</span>
                                    @if($volume->is_owned === 1)
                                    <i class="fa-solid fa-square-check"></i>
                                    @else
                                    <i class="fa-regular fa-square"></i>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <span class="text-gray-500">既読:</span>
                                    @if($volume->is_read === 1)
                                    <i class="fas fa-star"></i>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <span class="text-gray-500">買いたい:</span>
                                    @if($volume->wants_to_buy === 1)
                                    <i class="fas fa-star"></i>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <span class="text-gray-500">読みたい:</span>
                                    @if($volume->wants_to_read === 1)
                                    <i class="fas fa-star"></i>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <span class="text-gray-500">メモ:</span>
                                    {{ $volume->note }}
                                </div>
                                <button type="button" onclick="location.href='/mangahub/editVolume/{{ $volume->id }}'" class="mt-4 py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">編集</button>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $seriesDetail->mangaVolumes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
