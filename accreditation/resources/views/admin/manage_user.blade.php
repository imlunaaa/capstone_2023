<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage User') }}
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
            <div class="col text-end">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Members</button>
            </div>
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
                                <!-- <form class="row">
                                    <div class="col">
                                        <input type="text" name="search" class="form-control" placeholder="Search">
                                        <button type="submit" class="btn btn-outline-primary">Search</button>
                                    </div>
                                </form> -->
                            @forelse($users as $index => $user)
                                <div class="form-check">
                                    <input type="checkbox" name="members[]" class="form-check-input" value="{{$user->id}}" id="{{$user->id}}">
                                    <label class="form-check-label" for="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</label>
                                </div>
                            @empty
                                <center><a href="/add_users"><i class="fa-solid fa-user-plus"></i> No users, Add Here</a></center>
                            @endforelse

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
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members AS $member)
                <tr>
                    <td>
                        {{$member->fname}} {{$member->lname}}
                    </td>
                    <td><a href="/manage_user/delete/{{$member->mid}}"><button class="btn btn-outline-danger">Remove <i class="fa-solid fa-user-minus"></i></button></a></td>
                </tr>
                @empty
                    <tr>
                        <td colspan="2">
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