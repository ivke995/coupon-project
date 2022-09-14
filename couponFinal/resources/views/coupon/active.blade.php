<x-page>
    <h2>Active Coupons</h2>
    <h6>*all active coupons,that have limit date or unlimited</h6>
    

    <form class="input-sm" action="{{route('filter') }}" method="POST">

      @csrf
  
      <input type="hidden" name="current_table" value="coupon.active">
      
      <label for="startdate">from:</label>
      <input type="date" class = "datepicker ml-2" name = "created_at" id="StartDate" placeholder = "Start Date" style = "display: inline; height: 40px; width:150px; background-color:rgb(255, 255, 255);"/>
      
      <label class="ml-2" for="startdate">to:</label>
      <input type="date" class = "datepicker ml-2" name = "created_to" id="EndDate" placeholder = "End Date" style = "display: inline; height: 40px; width:150px; background-color:#ffffff;"/>
      
      <select style="display: inline; height: 40px; width:130px; background-color:#ffffff; color:rgb(0, 0, 0);" class="form-select ml-5" aria-label="Default select example" name="type_id">
        <option value="" disabled selected>type</option>
    @foreach ($types as $type)
        <option value="{{ $type->id }}">{{ $type->type_name }}</option>  
    @endforeach
    </select>
  
    <select style="display: inline; height: 40px; width:130px; background-color:#ffffff; color:rgb(0, 0, 0);" class="form-select ml-5" aria-label="Default select example" name="subtype_id">
      <option value="" disabled selected>subtype</option>
  @foreach ($subtypes as $subtype)
      <option value="{{ $subtype->id }}">{{ $subtype->subtype_name }}</option>  
  @endforeach
  </select>
  
  <input style="display: inline; height: 40px; width:120px; background-color:#ffffff; " type="text" placeholder="value" class="ml-5" name="value"/>
  
  <select style="display: inline; height: 40px; width:120px; background-color:#ffffff; color:rgb(0, 0, 0);" class="form-select ml-5" aria-label="Default select example" name="status_id">
    <option value="" disabled selected>status</option>
    <option value="1">active</option>
    <option value="2">used</option>   
  </select>
  
  <input style="display: inline; height: 40px; width:120px; background-color:#ffffff;" type="text" placeholder="used times" class="ml-5" name="used_times"/>
      {{-- <input style="display: inline; height: 40px; width:120px; background-color:#ffffff;" type="text" placeholder="email" class="ml-5" name="email"/> --}}
  
      <button type="submit" class="btn btn-primary px-4 py-2 ml-7">Filter</button>
      <button type="submit" class="btn btn-danger px-4 py-2 ml-7">Refresh</button>
  
      
    </form>
    

    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Type</th>
            <th scope="col">Subtype</th>
            <th scope="col">Value</th>
            <th scope="col">Limit</th>
            <th scope="col">Status</th>
            <th scope="col">Used Times</th>
            <th scope="col">Valid Until</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Used At</th>
            <th scope="col">Options</th>
          </tr>
        </thead>
        <tbody>

          @foreach ($coupons as $coupon)
          <tr>
             <th scope="row">{{$coupon->id}}</th>
              <td>{{$coupon->type->type_name}}</td>
              <td>{{$coupon->subtype->subtype_name}}</td>
              <td>{{$coupon->value}}</td>
              <td>{{$coupon->limit}}</td>
              <td>{{$coupon->status->status_name}}</td>
              <td>{{$coupon->used_times}}</td>
              <td>{{$coupon->valid_until}}</td>
              <td>{{$coupon->created_at}}</td>
              <td>{{$coupon->updated_at}}</td>
              <td>{{$coupon->used_at}}</td>
              @if ($coupon->status->id == 1)
              <td>
<form style="display:inline" action="{{route('edit', $coupon->id)}}" method="POST">
@csrf

  <input type="hidden" name="id" value="{{$coupon->id}}">
  <button type="submit" class="btn btn-primary" class="text-light">Edit</button>
</form>
<form style="display: inline" action="{{route('delete')}}" method="POST">
  @csrf
  @method("DELETE")

  <input type="hidden" value="{{$coupon->id}}" name="id">
  <button type="submit" class="btn btn-danger" class="text-light">Delete</button>
</form>     
              </td>
              @else
              <td>X</td>
            </tr>
            @endif
            @endforeach
            </tr>
        </tbody>
      </table>
</x-page>