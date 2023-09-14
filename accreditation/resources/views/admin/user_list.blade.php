<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
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
        <table class="table"> 
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Campus</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users AS $user)
                @php
                    $roles = array();
                    if($user->isAdmin == 1):
                        array_push($roles, 'Admin');
                    endif;

                    if($user->isAreachair == 1):
                        array_push($roles, 'Area Chair');
                    endif;

                    if($user->isAreamember == 1):
                        array_push($roles, 'Area Member');
                    endif;

                    if($user->isExternal == 1):
                         array_push($roles, 'External Accreditor');
                    endif;

                    if($user->isInternal == 1):
                         array_push($roles, 'Internal Accreditor');
                    endif;

                    $role = implode(", ", $roles);

                @endphp
                <tr>
                    <td>{{$user->firstname}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->campus_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$role}}</td>
                    <td><a href="/edit_user/{{$user->id}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="/user_list/{{$user->id}}"><button class="btn btn-outline-danger" onclick="return confirm('You are about to delete this accont')">Delete</button></a></td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>