<x-page>
    <h2>Used Coupons</h2>
    <h6>*show all used coupons</h6>

    <form class="input-sm" action="{{route('filter') }}" method="POST">

      @csrf

      <input type="hidden" name="current_table" value="coupon.used">
      
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
  
  <input style="display: inline; height: 40px; width:120px; background-color:#ffffff;" type="text" placeholder="used times" class="ml-5" name="used_times"/>
      <input style="display: inline; height: 40px; width:120px; background-color:#ffffff;" type="text" placeholder="email" class="ml-5" name="email"/>
  
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
            <th scope="col">Email</th>
            <th scope="col">Used At</th>
          </tr>
        </thead>
        <tbody>

          @foreach ($useds as $used)
          
          <tr>
             <th scope="row">{{$used->id}}</th>
              <td>{{$used->type_name}}</td>
              <td>{{$used->subtype_name}}</td>
              <td>{{$used->value}}</td>
              <td>{{$used->limit}}</td>
              <td>{{$used->email}}</td>
              <td>{{$used->used_at}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
</x-page>