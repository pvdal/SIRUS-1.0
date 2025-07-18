@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm']) !!}>
