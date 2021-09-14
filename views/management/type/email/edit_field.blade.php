<div class="w-full flex flex-wrap mb-2">
    @if($label)
        <label class="w-full block text-gray-700 text-sm font-bold mb-2">{{$label}}</label>
    @endif
    
    <input 
        name="{{ $name }}" 
        class="shadow appearance-none border border-grey-100 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
        type="email" 
        @if($is_required)
         required
        @endif

        @if($placeholder)
         placeholder="{{ $placeholder }}"
        @endif

        @if($value)
         value="{{ $value }}"
        @endif
    >
</div>