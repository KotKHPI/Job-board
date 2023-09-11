<x-layout>
    @foreach($jobs as $job)
        <div class="rounded-md border border-slate-300 bg-white p-4 shadow-sm mb-4">
            {{ $job->title }}
        </div>
    @endforeach
</x-layout>
