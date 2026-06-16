@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full py-4 px-4 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-300 text-gray-700']) }}>
