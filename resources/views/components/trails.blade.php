<div class="flex flex-row">
    @forelse ($trails as $trail)
        @if(!$loop->last)
            <a href="{{$trail['link']}}" class="text-green-600 hover:text-green-500">
                {{$trail['name']}} / 
            </a>
        @endif
    @empty
    @endforelse
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-1">
        {{$title}}
    </h2>
</div>