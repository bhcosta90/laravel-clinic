@php use Illuminate\Validation\ValidationException; @endphp
<div>
    @if($messageErrors)
        <div class="pb-3 gap-3">
            @foreach($messageErrors as $messageError)
                @if($messageError->exception === ValidationException::class)
                    <x-alert type="warning" class="mb-4">
                        <x-slot name="title">{{ __('There were some problems with your input with code :code.', ['code' => $messageError->code]) }}</x-slot>
                        <ul class="mt-3 list-disc list-inside text-sm">
                            @foreach($messageError->data as $fieldErrors)
                                @foreach($fieldErrors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </x-alert>
                @endif
            @endforeach
        </div>
    @endif
</div>
