<x-layout>
    <x-card>
        @foreach($jobs as $job)
            <div class="mb-4">
                {{$job->title}}
            </div>
        @endforeach
    </x-card>
</x-layout>
