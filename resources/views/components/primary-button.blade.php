<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-4 bg-gradient-to-br from-blue-600 to-blue-700 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
