@extends('layouts/layout')
@section('content')
    
<x-page>

  <h2>Create New Coupon</h2>
  
    <form action="{{route('coupon')}}" method="POST"> 
      @csrf

      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input  name="creator_email" class="form-control" id="creator_email" aria-describedby="emailHelp" placeholder="email" value="{{old('creator_email')}}">
        <span style="color:red">@error('creator_email'){{ $message }} @enderror</span>
      </div> <br>
      
      
      <div>
        <label for="type_id">Type:</label><br>
        <select class="form-select" name="type_id"  aria-label="Default select example">
          <option value="">Select type</option>
          @foreach ($types as $type)
          <option value="{{$type->id}}">{{$type->type_name}}</option>
          @endforeach
        </select> 
        <span style="color:red">@error('type_id'){{ $message }}@enderror</span>
      </div>
      
      
      <div>

        <label for="subtype_id">Subtype:</label><br>
        <select name="subtype_id" class="form-select" aria-label="Default select example">
          <option value="">Select subtype</option>
          @foreach ($subtypes as $subtype)
          <option value="{{$subtype->id}}">{{$subtype->subtype_name}}</option>
          @endforeach
        </select> 
        <span style="color:red">@error('subtype_id'){{ $message }}@enderror</span>
      </div>
      
      {{-- <div>
        
        <label for="status_id">Status:</label><br>
        <select name="status_id" class="form-select" aria-label="Default select example">
          <option value="">Select status</option>
          @foreach ($statuses as $status)
          <option value="{{$status->id}}">{{$status->status_name}}</option>
          @endforeach
        </select>
        <span style="color:red">@error('status_id'){{ $message }}@enderror</span>
      </div> --}}
      
      
      <label for="value">Value:</label><br>
      <input type="number" id="value" name="value" value="{{old('value')}}"><br>
      <span style="color:red">@error('value'){{ $message }}@enderror</span>
      <br>
      
      <label for="limit">Limit:</label><br>
      <input type="number" id="limit" name="limit" value="{{old('limit')}}"><br>
      <span style="color:red">@error('limit'){{ $message }}@enderror</span>
      <br>
      
      <label for="valid_until">Valid until:</label>
      <input type="datetime-local" id="valid_until" name="valid_until"
      value="2018-07-22"
      min="current" max="2050-12-31">
      <span style="color:red">@error('valid_until'){{ $message }}@enderror</span>
      
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
  </x-page>
  @endsection