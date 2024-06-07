<x-app-layout>
    <x-slot name="header">
        {{ __('Products') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 md:flex md:flex-wrap">
                    @forelse ($products as $product)
                        <div class="bg-gray-100 rounded-md shadow-md my-2 p-2 mx-auto min-w-auto ">
                            <div class="header flex flex-col">
                                <h5 class="text-lg font-bold">
                                    {{$product->name}}
                                </h5>
                                <span class="text-sm text-gray-900 font-medium">
                                    {{$product->slug}}
                                </span>
                            </div>
                            <div class="body border-b border-gray-300 py-2">
                                <p>
                                    {{ Str::limit($product->description, 30)}}
                                </p>
                            </div>
                            <div class="footer flex justify-between py-2">
                                <h6>{{'$ '.number_format($product->price,2) }}</h6>
                                <div class="text-white">
                                    <a href="{{route('payment.item',['id'=>$product->id,'type'=>'product'])}}">
                                        <button class="bg-green-600 rounded hover:bg-green-700 hover:ring-green-600 transition-colors px-4">
                                            Buy
                                        </button>
                                    </a>
                                    <a href="{{route('payment.checkout.item',['id'=>$product->id,'type'=>'product'])}}">
                                        <button class="bg-blue-500 rounded hover:bg-blue-600 hover:ring-green-600 transition-colors px-4">
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
