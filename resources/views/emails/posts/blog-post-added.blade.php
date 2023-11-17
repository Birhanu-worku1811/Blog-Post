<x-mail::message>
    # Some has posted a blog post

    Be sure to proof read it

    <x-mail::button :url="''">
        Button Text
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
