@extends('layouts/layout')
@section('content')

<x-page>

<h2>Update Coupon</h2>

<form action="{{route('update', $coupon->id)}}" method="POST">
    @csrf
    @method("PATCH")

    <input type="hidden" value="{{$coupon->id}}" name="id">

@if ($coupon->type_id == 1)

<div class="mb-3 mt-3">
    <label for="exampleInputValue1" class="form-label">Value</label>
        <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: black; background: white;" id="exampleInputValue1" aria-describedby="valueHelp">        
    </div>
    <label for="exampleInputStatus" class="form-label">Select coupon status</label>
    <select class="form-select" style=" color: black; background: white;" aria-label="Default select example" name="status_id">
        <option value="1">active</option>
        <option value="2">used</option>    
    </select>

    @elseif ($coupon->type_id == 2)
    <div class="mb-3 mt-3">
        <label for="exampleInputValue1" class="form-label">Value</label>
        <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: black; background: white;" id="exampleInputValue1" aria-describedby="valueHelp">        
    </div>
    <div class="mb-3">
        <label for="exampleInputLimit" class="form-label">Limit</label>
        <input value="{{ $coupon->limit  }}" name="limit" type="text" class="form-control" style=" color: black; background: white;" id="exampleInputLimit" aria-describedby="limitHelp">        
    </div>
    <label for="exampleInputStatus" class="form-label">Select coupon status</label>
        <select class="form-select" style=" color: black; background: white;" aria-label="Default select example" name="status_id">
            <option value="1">active</option>
            <option value="3">inactive</option>    
        </select>

        @elseif ($coupon->type_id == 3 || $coupon->type_id == 4)
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: black; background: white;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Valid Until</label>
            <input value="{{ $coupon->valid_until }}" name="valid_until" type="date" class="form-control" style=" color: black; background: white;" id="exampleInputDate" aria-describedby="dateHelp">        
        </div>
        <label for="exampleInputStatus" class="form-label">Select coupon status</label>
            <select class="form-select" style=" color: black; background: white;" aria-label="Default select example" name="status_id">
                <option value="1">active</option>
                <option value="3">inactive</option>    
            </select>

        @else
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: black; background: white;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        
        <label for="exampleInputStatus" class="form-label">Select coupon status</label>
        <select class="form-select" style=" color: black; background: white;" aria-label="Default select example" name="status_id">
            <option value="1">active</option>
            <option value="3">inactive</option>    
        </select>

    @endif

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</x-page>
@endsection