<x-page>
  

    <h2>Emails</h2>

    <form class="input-sm" action="{{route('filter') }}" method="POST">

      @csrf

      <input type="hidden" name="current_table" value="email.addresse">
      
      <label for="startdate">from:</label>
      <input type="date" class = "datepicker ml-2" name = "created_at" id="StartDate" placeholder = "Start Date" style = "display: inline; height: 40px; width:150px; background-color:rgb(255, 255, 255);"/>
      
      <label class="ml-2" for="startdate">to:</label>
      <input type="date" class = "datepicker ml-2" name = "created_to" id="EndDate" placeholder = "End Date" style = "display: inline; height: 40px; width:150px; background-color:#ffffff;"/>
    
  <input style="display: inline; height: 40px; width:120px; background-color:#ffffff;" type="text" placeholder="coupons_used" class="ml-5" name="coupons_used"/>
      <input style="display: inline; height: 40px; width:120px; background-color:#ffffff;" type="text" placeholder="email" class="ml-5" name="email"/>
  
      <button type="submit" class="btn btn-primary px-4 py-2 ml-7">Filter</button>
      <button type="submit" class="btn btn-danger px-4 py-2 ml-7">Refresh</button>

  
    </form>

    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">EMAIL</th>
            <th scope="col">First Coupon Used</th>
            <th scope="col">Last Coupon Used</th>
            <th scope="col">Coupons Used</th>
            <th scope="col">Created At</th>
          </tr>
        </thead>
        <tbody>

          @foreach ($emails as $email)
          <tr>
             <th scope="row">{{$email->id}}</th>
              <td>{{$email->email}}</td>
              <td>{{$email->first_coupon_used}}</td>
              <td>{{$email->last_coupon_used}}</td>
              <td>{{$email->coupons_used}}</td>
              <td>{{$email->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>

      

</x-page>