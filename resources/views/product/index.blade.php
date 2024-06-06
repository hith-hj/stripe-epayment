<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-row ">
                    @forelse ($products as $product)
                        <div class="bg-gray-200 rounded-md shadow-md m-2 p-2 w-1/4">
                            <div class="header my-2 flex flex-col">
                                <h5 class="text-md font-bold">
                                    {{$product->name}}
                                </h5>
                                <span class="text-sm text-gray-900 font-semibold"> {{$product->slug}}</span>
                            </div>
                            <div class="body mb-6 border-b border-gray-500 py-2">
                                {{ Str::limit($product->description, 20)}}
                            </div>
                            <div class="footer flex justify-between">
                                <h6>{{'$ '.number_format($product->price,2) }}</h6>
                                <div>
                                    <a href="{{route('payment.item',['id'=>$product->id,'type'=>'product'])}}">
                                        <button class="bg-green-600 rounded hover:bg-green-300 hover:ring-green-600 transition-colors px-4">
                                            Buy
                                        </button>
                                    </a>
                                    <a href="{{route('payment.checkout.item',['id'=>$product->id,'type'=>'product'])}}">
                                        <button class="bg-blue-600 rounded hover:bg-blue-300 hover:ring-green-600 transition-colors px-4">
                                            Checkout
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <small>No products yet</small>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
