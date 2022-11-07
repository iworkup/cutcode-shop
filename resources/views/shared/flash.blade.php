@if($message = flash()->get())
    <div class="text-center py-16 lg:py-20 {{ $message->class() }}">
        {{ $message->message() }}
    </div>
@endif
