@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{ __('عذرًا! هناك خطأ ما.') }}

        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            {{'أوراق الاعتماد هذه لا تتطابق مع سجلاتنا'}}
        </ul>
    </div>
@endif
