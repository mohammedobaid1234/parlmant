<div style="padding: 10px">
    <label  for=" {{ $name }} ">@lang($label) </label>
    {{-- <img src="{{old('image', $value ?? null)}}" style="width: 100px; height: 100px"> --}}
  <input type="{{ $type ?? 'text'}}"
   class= " @error($name) is-invalid @enderror" name="{{$name}}" 
   value="{{old($name, $value ?? null )}}">
  
  <p class="invalid-feedback"> 
    @error($name) 
    {{$message}}  
    @enderror
  
  </p>    
</div>