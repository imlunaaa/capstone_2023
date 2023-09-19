<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Members') }}
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
    <div class="p-6">
        <div class="row">
            <div class="col">
                <a href="/manage_accreditation">
                    <button class="btn btn-outline-secondary">
                        Go Back
                    </button>
                </a>
            </div>
            @if(Auth::user()->user_type == 'admin' || $roles->isCoordinator == 1)
            <div class="col text-end">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Members</button>
            </div>
            @endif
            <!-- Modal -->
            <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ Route('add_members') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="row py-2">
                                <div class="col">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                                </div>
                            </div>
                            <table>
                                <tbody id="user_table" class="list-group list-group-flush">
                                    @forelse($users as $key => $user)
                                        <tr class="list-group-item list-group-item-action list-group-item-light">
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" name="members[]" class="form-check-input" value="{{$user->id}}" id="{{$user->id}}" >
                                                    <label class="form-check-label" for="{{$user->user_id}}"><b class="fs-5">{{$user->lastname}} {{$user->firstname}}</b> <span class="fs-6">({{$user->campus_name}})</span>
                                                    <p class="fs-6">{{$user->program}}</p>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <center><a href="/add_users"><i class="fa-solid fa-user-plus"></i> No users, Add Here</a></center>
                                    @endforelse
                                </tbody>
                            </table>
                            <input type="hidden" name="acc_id" value="{{$id}}">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary">Save changes</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-4">
                <input type="text" name="search_member" id="search_member" class="form-control" placeholder="Search Member">
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="members_table">
                @forelse($members AS $member)
                @php
                    $roles = array();

                    if($member->isMember == 1):
                        array_push($roles, 'Member');
                    endif;

                    if($member->isAdmin == 1):
                        array_push($roles, 'Admin');
                    endif;

                    if($member->isAreachair == 1):
                        array_push($roles, 'Area Chair');
                    endif;

                    if($member->isAreamember == 1):
                        array_push($roles, 'Area Member');
                    endif;

                    if($member->isExternal == 1):
                         array_push($roles, 'External Accreditor');
                    endif;

                    if($member->isInternal == 1):
                         array_push($roles, 'Internal Accreditor');
                    endif;
                    if($member->isCoordinator == 1):
                         array_push($roles, 'Coordinator');
                    endif;

                    $role = implode(", ", $roles);
                @endphp
                <tr>
                    <td>
                        <b>{{$member->lname}} {{$member->fname}}</b>
                    </td>
                    <td>@php echo $role @endphp </td>
                    <td>
                        <a href="/manage_member/delete/{{$member->mid}}">
                            <button class="btn btn-outline-danger">
                                Remove <i class="fa-solid fa-user-minus"></i>
                            </button>
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#roleModal{{$member->mid}}">
                            Roles <i class="fa-solid fa-user"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="roleModal{{$member->mid}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><b>{{$member->lname}} {{$member->fname}}</b></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/update_role/{{$member->mid}}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <div class="form-group py-2">
                                    <div class="form-check">
                                        <input type="checkbox" id="coordinator" name="coordinator" value="1" class="form-check-input @error('coordinator') is-invalid @enderror" {{$member->isCoordinator == 1 ? 'checked' : ''}}>
                                        <label for="coordinator" class="form-check-label">Coordinator</label>
                                    </div>
                                    <div id="coordinatorError"  class="invalid-feedback">
                                        @error('coordinator') <p>Please select a role.</p> @enderror
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" id="internal" name="internal" value="1" class="form-check-input @error('internal') is-invalid @enderror" {{$member->isInternal == 1 ? 'checked' : ''}}>
                                        <label for="internal" class="form-check-label">Internal Accreditor</label>
                                    </div>
                                    <div id="programError"  class="invalid-feedback">
                                        @error('internal') <p>Please select a role.</p> @enderror
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" id="external" name="external" value="1" class="form-check-input @error('external') is-invalid @enderror" {{$member->isExternal == 1 ? 'checked' : ''}}>
                                        <label for="external" class="form-check-label">External Accreditor</label>
                                    </div>
                                    <div id="externalError"  class="invalid-feedback">
                                        @error('external') <p>Please select a role.</p> @enderror
                                    </div>

                                    <hr>
                                    <div class="form-check">
                                        <input type="radio" id="area_chair" name="areachair" value="0" class="form-check-input @error('areachair') is-invalid @enderror" {{$member->isAreachair == 1 ? 'checked' : ''}}>
                                        <label for="area_chair" class="form-check-label">Area Chair</label>
                                    </div>
                                    <div id="areachairError" class="invalid-feedback">
                                        @error('areachair') <p>Please select a role.</p> @enderror
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="radio" id="area_member" name="areachair" value="1" class="form-check-input @error('areamember') is-invalid @enderror" {{$member->isAreamember == 1 ? 'checked' : ''}}>
                                        <label for="area_member" class="form-check-label">Area Member</label>
                                    </div>
                                    <div id="areamemberError"  class="invalid-feedback">
                                        @error('areamember') <p>Please select a role.</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
                @empty
                    <tr>
                        <td colspan="3">
                            <center>
                               <i class="fa-solid fa-user-plus"></i> No members yet, 
                               <span data-bs-toggle="modal" data-bs-target="#addMemberModal" style="cursor:pointer;"><u>Add here </u></span>
                            </center>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#search').keyup(function(){
        search_table_users($(this).val());
        });

        function search_table_users(value)
        {
            $('#user_table tr').each(function(){
                var found = 'false';
                $(this).each(function(){
                   if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
                   {
                        found = 'true';
                   }
                });
                if(found == 'true')
                {
                    $(this).show();
                }
                else
                {
                    $(this).hide();
                }
            });
        }

        $('#search_member').keyup(function(){
        search_table_members($(this).val());
        });

        function search_table_members(value)
        {
            $('#members_table tr').each(function(){
                var found = 'false';
                $(this).each(function(){
                   if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
                   {
                        found = 'true';
                   }
                });
                if(found == 'true')
                {
                    $(this).show();
                }
                else
                {
                    $(this).hide();
                }
            });
        }

    });
</script>