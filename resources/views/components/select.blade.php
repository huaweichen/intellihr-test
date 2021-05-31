@props(['id', 'options', 'value' => null])

<select id="{{ $id }}" {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    <option></option>
    @foreach($options as $option)
        <option
            value="{{ $option['value'] }}"
            @if ($option['value'] === $value)
            selected
            @endif
        >
            {{ $option['label'] }}
        </option>
    @endforeach
</select>
