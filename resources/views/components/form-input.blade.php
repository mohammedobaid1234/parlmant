<div style="padding: 10px">
    <label  for=" {{ $name }} ">@lang($label) </label>
  
  <input type="{{ $type ?? 'text'}}"
   class= " form-control @error($name)
    is-invalid @enderror" name="{{$name}}" 
   value="{{old($name, $value ?? null )}}">
  
  <p class="invalid-feedback"> 
    @error($name) 
    {{$message}}  
    @enderror
  
  </p>    
  </div>