<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="'/posts'">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
