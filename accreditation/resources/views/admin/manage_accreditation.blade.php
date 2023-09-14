<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Accreditation') }}
        </h2>
    </x-slot>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="p-4">
        @if(Auth::user()->isAdmin == '1')
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAccreditationModal">Create Accreditation</button>
        @endif
        <div class="row row-cols-2 g-2 my-3">
            @forelse($accreditations AS $accreditation)
            <div class="col">
                @if(Auth::user()->isAdmin == '1')
                <a href="#">
                @endif
                <a href="/parameters">
                    <div class="card text-bg-light mb-3 shadow p-3 bg-body rounded" >
                        <div class="card-header bg-transparent fs-3">{{ $accreditation->accreditation_name}}</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $accreditation->accreditation_name}}</h5>
                            <p class="card-text">Campus: <b>{{ $accreditation->cname }}</b></p>
                            <p class="card-text">Program: <b>{{ $accreditation->prog }}</b></p>
                            <p class="card-text">Accreditation type: <b>{{ $accreditation->accreditation_type }}</b></p>
                            <p class="card-text">Internal Accreditation: 
                                <b>{{ \Carbon\Carbon::parse($accreditation->internal_accreditation_date_start)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($accreditation->internal_accreditation_date_end)->format('M d, Y') }}</b>
                            </p>
                            <p class="card-text">External Accreditation: 
                                <b>{{ \Carbon\Carbon::parse($accreditation->external_accreditation_date_start)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($accreditation->external_accreditation_date_end)->format('M d, Y') }}</b>
                            </p>
                        </div>
                        @if(Auth::user()->isAdmin == '1')
                        <div class="card-footer bg-transparent text-end">
                            <a href="/manage_user/{{$accreditation->id}}"><button class="btn btn-outline-primary">View Members</button></a>
                            <a href=""><button class="btn btn-outline-success">Edit</button></a>
                            <a href="/manage_accreditation/{{$accreditation->id}}"><button class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button></a>
                        </div>
                        @endif
                    </div>
                </a>
            </div>
        
            @empty
                <center>No Accreditation at the moment</center>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addAccreditationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Create Accreditation</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('add_accreditation') }}">
              <div class="modal-body">
                    @csrf
                    <label for="accreditation_name">Accreditation Name</label>
                    <input id="accreditation_name" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="accreditation_name" value="{{ old('accreditation_name') }}" required autofocus>
                    <div id="accreditation_nameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter Accreditation name.
                    </div>
                    <!-- <label for="campus">Campus</label>
                    <select name="campus" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;">
                        <option selected disabled value="">Select Option</option>
                        @foreach($campuses AS $campus)
                        <option value="{{$campus->id}}">{{$campus->name}}</option>
                        @endforeach
                    </select>
                    <div id="campusError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an campus.
                    </div> -->
                     <label for="program">Program</label>
                    <select name="program" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;">
                        <option selected disabled value="">Select Option</option>
                        @foreach($programLevels AS $programLevel)
                        <option value="{{$programLevel->plID}}">{{$programLevel->cname}} : {{$programLevel->prog}} - Level {{$programLevel->level}}</option>
                        @endforeach
                    </select>
                    <div id="programError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an program.
                    </div>
                    <label for="acc_type">Accreditation Type</label>
                    <select name="acc_type" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;">
                        <option selected disabled value="">Select option</option>
                        <option value="New">New</option>
                        <option value="Old">Old</option>
                    </select>
                    <br><br><br>
                    <center><h4 class="fs-4">Internal Accreditation</h4></center>
                    <label for="inter_date_start">Internal Accreditaion Start Date</label>
                    <input id="inter_date_start" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="date" name="inter_date_start" value="{{ old('inter_date_start') }}" required autofocus>
                    <div id="inter_date_startError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter Internal Accreditaion Start Date.
                    </div>
                    <label for="inter_date_end">Internal Accreditaion End Date</label>
                    <input id="inter_date_end" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="date" name="inter_date_end" value="{{ old('inter_date_end') }}" required autofocus>
                    <div id="inter_date_endError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter Internal Accreditaion End Date.
                    </div>
                    <br><br><br>
                     <center><h4 class="fs-4">Enternal Accreditation</h4></center>
                    <label for="exter_date_start">External Accreditaion Start Date</label>
                    <input id="exter_date_start" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="date" name="exter_date_start" value="{{ old('exter_date_start') }}" required autofocus>
                    <div id="exter_date_startError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter External Accreditaion Start Date.
                    </div>
                    <label for="exter_date_end">External Accreditaion Start Date</label>
                    <input id="exter_date_end" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="date" name="exter_date_end" value="{{ old('exter_date_end') }}" required autofocus>
                    <div id="exter_date_endError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter External Accreditaion End Date.
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Create Accreditation</button>
              </div>
          </form>
        </div>
      </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function(){
        alert();
    });
    
</script>