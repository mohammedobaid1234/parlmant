<div style="padding: 10px">
    <label  for=" {{ $name }} ">@lang($label) </label>
  
    <textarea name="{{$name}}"  class="form-control @error($name) is-invalid @enderror" name="{{$name}}" rows="3">
        {{old($name, $value ?? null )}}
    </textarea>
  <p class="invalid-feedback"> 
    @error($name) 
    {{$message}}  
    @enderror
  
  </p>    
  </div>