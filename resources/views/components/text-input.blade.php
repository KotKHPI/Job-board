<div class="relative">
    @if('textarea' != $type)
        @if ($formRef)
            <button type="button" class="absolute top-0 right-0 flex h-full items-center pr-1"
                    @click="$refs['input-{{ $name }}'].value = ''; $refs['{{ $formRef }}'].submit();">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        @endif
        <input x-ref="input-{{$name}}" placeholder="{{ $placeholder }}" type="{{ $type }}"
               name="{{ $name }}" value="{{ old($name, $value) }}" id="{{$name}}"
            @class(['w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2',
                'pr-8' => $formRef,
                'ring-slate-300' => !$errors->has($name),
                'ring-red-300' => $errors->has($name),]) />
    @else
        <textarea id="{{$name}}" name="{{ $name }}" @class([
        'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2',
        'pr-8' => $formRef,
        'ring-slate-300' => !$errors->has($name),
        'ring-red-300' => $errors->has($name),])>
            {{ old($name, $value) }}
        </textarea>
    @endif

    @error($name)
        <div class="mt-1 text-xs text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
