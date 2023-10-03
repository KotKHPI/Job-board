<div>
    @if($allOption)
        <label for="{{$name}}" class="mb-1 flex items-center">
            <input type="radio" name="{{$name}}" value=""
                @checked(!request($name))/>
            <span class="ml-2">All</span>
        </label>
    @endif

    @foreach($optionsWithLabels as $lable => $option)

    <label for="{{$name}}" class="mb-1 flex items-center">
        <input type="radio" name="{{$name}}" value="{{$option}}"
            @checked($option === ($value ?? request($name)))/>
        <span class="ml-2">{{$lable}}</span>
    </label>
    @endforeach

        @if(session('error'))
            <div role="alert" class="my-8 rounded-md border-l-4 border-red-300 bg-red-100 p-4 text-red-700 opacity-75">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
</div>
